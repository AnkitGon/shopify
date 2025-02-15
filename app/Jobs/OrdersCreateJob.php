<?php

namespace App\Jobs;

use App\Http\Controllers\LoyaltyProgramController;
use App\Models\CustomerPoint;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use stdClass;
use Carbon\Carbon;

class OrdersCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var ShopDomain|string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string   $shopDomain The shop's myshopify domain.
     * @param stdClass $data       The webhook data (JSON decoded).
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // Convert domain
        $this->shopDomain = ShopDomain::fromNative($this->shopDomain);
        $totalPrice = $this->data->total_price;

        try {
            $shop = User::where('name', $this->shopDomain->toNative())->first();

            $program = new LoyaltyProgramController();
            $responseArray = json_decode($program->index()->getContent(), true);
            $earnablePoints = ($totalPrice / 1000) * $responseArray['data']['points_per_dollar'];

            $redemptionRate = $responseArray['data']['redemption_rate'];
            $creditAmount = $earnablePoints * $redemptionRate;
            $expiresAt = Carbon::now()->addYear()->toIso8601String(); //after one year

            $customerGrapghqlId = $this->data->customer->admin_graphql_api_id;

            $query = <<<'GRAPHQL'
        mutation storeCreditAccountCredit($id: ID!, $creditInput: StoreCreditAccountCreditInput!) {
            storeCreditAccountCredit(id: $id, creditInput: $creditInput) {
                storeCreditAccountTransaction {
                    amount {
                        amount
                        currencyCode
                    }
                    account {
                        id
                        balance {
                            amount
                            currencyCode
                        }
                    }
                }
                userErrors {
                    message
                    field
                }
            }
        }
        GRAPHQL;

            $variables = [
                'id' => $customerGrapghqlId,
                'creditInput' => [
                    'creditAmount' => [
                        'amount' => $creditAmount,
                        'currencyCode' => $this->data->currency,
                    ],
                    'expiresAt' => $expiresAt,
                ],
            ];

            $client = $shop->api()->graph($query, $variables);

            if ($client['errors'] === false && $client['status'] === 200) {
                $amountAdded = $client['body']['container']['data']['storeCreditAccountCredit']['storeCreditAccountTransaction']['amount']['amount'];
                $currencyCode = $client['body']['container']['data']['storeCreditAccountCredit']['storeCreditAccountTransaction']['amount']['currencyCode'];
                $totalAmount = $client['body']['container']['data']['storeCreditAccountCredit']['storeCreditAccountTransaction']['account']['balance']['amount'];

                CustomerPoint::updateOrCreate(
                    ['customer_id' => $this->data->customer->id],
                    [
                        'customer_graphql_id' => $customerGrapghqlId,
                        'point' => $amountAdded,
                    ]
                );

                Log::info('Amount Added: ' . $amountAdded . ', Currency code: ' . $currencyCode . ', Total amount: ' . $totalAmount);
            }
        } catch (\Throwable $th) {
            Log::info('-----------------------------------Exception--------------------------------');
            Log::info($th->getMessage());
            Log::info('-----------------------------------End Exception--------------------------------');
        }
    }
}
