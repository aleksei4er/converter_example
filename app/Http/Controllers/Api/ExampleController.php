<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RateCollection;
use App\Services\Rate as ServicesRate;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function rates(ServicesRate $rate)
    {
        $rate->syncItems();

        return $rate->getItems();
    }

    public function convert(Request $request, ServicesRate $rate)
    {
        return $rate->convert($request->only(['currency_from', 'currency_to', 'value']));
    }

    public function badAuthentication()
    {
        return response()->json([
            'status' => 'error',
            'code' => 403,
            'message' => 'Invalid token'
        ], 403);
    }
}
