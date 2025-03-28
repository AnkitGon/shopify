<!DOCTYPE html>

<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('shopify-app.app_name') }} — Login</title>

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            padding: 2.5em 0;
            color: #212b37;
            font-family: -apple-system,BlinkMacSystemFont,San Francisco,Roboto,Segoe UI,Helvetica Neue,sans-serif;
        }

        .container {
            width: 100%;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }

        @media screen and (min-width: 510px) {
            .container {
                width: 510px;
            }
        }

        .title {
            font-size: 1.5em;
            margin: 2em auto;
            display: flex;
            align-items: center;
            justify-content: center;
            word-break: break-all;
        }

        .subtitle {
            font-size: 0.8em;
            font-weight: 500;
            color: #64737f;
            line-height: 2em;
        }

        .error {
            line-height: 1em;
            padding: 0.5em;
            color: #b30000;
            margin-bottom: 2em;
        }

        input.marketing-input {
            width: 100%;
            height: 52px;
            padding: 0 15px;
            box-shadow: 0 0 0 1px #ddd;
            border: 0;
            border-radius: 5px;
            background-color: #fff;
            font-size: 1em;
            margin-bottom: 15px;
        }

        input.marketing-input:focus {
            color: #000;
            outline: 0;
            box-shadow: 0 0 0 2px #008060;
        }

        button.marketing-button {
            display: inline-block;
            width: 100%;
            padding: 1.0625em 1.875em;
            background-color: #008060;
            color: #fff;
            font-weight: 700;
            font-size: 1em;
            text-align: center;
            outline: none;
            border: 0 solid transparent;
            border-radius: 5px;
            cursor: pointer;
        }

        button.marketing-button:hover {
            background: linear-gradient(to bottom, #008060, #008060);
            border-color: #008060;
        }

        button.marketing-button:focus {
            box-shadow: 0 0 0.1875em 0.1875em rgba(94,110,191,0.5);
            background-color: #223274;
            color: #fff;
        }
    </style>
</head>
<body>
<main class="container" role="main">
    <h3 class="title">
        {{ config('shopify-app.app_name') }}
    </h3>

    @if (session()->has('error'))
        <div class="error">
            <strong>Oops! An error has occured:</strong> {{ session('error') }}
        </div>
    @endif

    <p class="subhead">
        <label for="shop">Enter your Shopify domain to login.</label>
    </p>

    <form method="POST" action="{{ route('authenticate') }}">
        {{ csrf_field() }}
        <input id="shop" name="shop" type="text" autofocus="autofocus" placeholder="example.myshopify.com" class="marketing-input">
        <button type="submit" class="marketing-button">Install</button>
    </form>
</main>
</body>
</html>
