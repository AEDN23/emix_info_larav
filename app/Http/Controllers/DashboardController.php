<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wi;
use App\Models\std;
use App\Models\msds;
use App\Models\coa;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'wi' => wi::count(),
            'std' => std::count(),
            'msds' => msds::count(),
            'coa' => coa::count(),
        ];

        return view('dashboard', compact('counts'));
    }
}
