<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Osiset\ShopifyApp\Util;

class AuthController extends Controller
{
    /**
     *
     *  This method will redirect all fallback requests to route.
     *  It will allow routes to work with the App bridge routing system.
     */
    public function redirectHome()
    {
        return redirect()->route(Util::getShopifyConfig('route_names.home'), request()->query());
    }

    /**
     *
     *  Redering main application.
     */
    public function index()
    {
        // $shop = Auth::user();

        // $response = $shop->api()->rest('GET', '/admin/api/2025-01/webhooks.json');
        // dd($response);

        return view('layouts.app');
    }

    /**
     *
     *  Redering login page.
     */
    public function login()
    {
        return view('auth.login');
    }
}
