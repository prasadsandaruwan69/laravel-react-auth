<?php

namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Hotel;
use App\Models\Guid;    
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
        public function stats()
    {
        return response()->json([
            'cars' => Car::count(),
            'hotels' => Hotel::count(),
            'guids' => Guid::count(),
            'users' => User::count(),
        ]);
    }
}
