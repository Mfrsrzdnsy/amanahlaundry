<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;

class DashboardController extends Controller
{
    public function index()
    {
        return view('page.dashboard', [
            'pelanggan' => Pelanggan::count(),
        ]);
    }
}
