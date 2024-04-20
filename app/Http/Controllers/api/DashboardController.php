<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "message" => "Ini Project Team"
        ], 200);
    }
}
