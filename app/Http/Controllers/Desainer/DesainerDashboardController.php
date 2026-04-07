<?php

namespace App\Http\Controllers\Desainer;

use App\Http\Controllers\Controller;
use App\Models\order;

class DesainerDashboardController extends Controller
{
    public function index()
    {
        // Get only orders that are assigned to this designer
        $orders = order::with(['desains' => function ($q) {
            $q->orderBy('draft_ke', 'desc');
        }])
        ->where('id_desainer', auth()->id())
        ->whereHas('desains')
        ->get();

        return view('desainer.dashboard.desainer', compact('orders'));
    }
}