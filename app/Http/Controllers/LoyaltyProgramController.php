<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\LoyaltyProgram;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class LoyaltyProgramController extends Controller
{
    public function index(){
        $programs = LoyaltyProgram::first();

        return ApiResponse::success($programs);
    }
    public function save(Request $request)
    {
        $validated = $request->validate([
            'points_per_dollar' => 'required|integer',
            'redemption_rate' => 'required|integer',
        ]);

        try {
            LoyaltyProgram::truncate();

            $loyalty = LoyaltyProgram::create($validated);

            return ApiResponse::success($loyalty);

        } catch (Exception $exception) {

            return ApiResponse::error($exception->getMessage());

        }
    }

}
