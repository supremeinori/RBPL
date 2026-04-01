<?php

namespace App\Http\Controllers\Desainer;

use App\Http\Controllers\Controller;
use App\Models\order;

class DesainerDashboardController extends Controller
{
    public function index()
    {
        // Get all orders that have at least one desain draft
        $orders = order::with(['desains' => function ($q) {
            $q->orderBy('draft_ke', 'desc');
        }])
        ->whereHas('desains')
        ->get();

        return view('desainer.dashboard.desainer', compact('orders'));
    }
}