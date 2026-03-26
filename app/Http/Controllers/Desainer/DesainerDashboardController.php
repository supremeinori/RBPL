<?php

namespace App\Http\Controllers\Desainer;

use App\Http\Controllers\Controller;
use App\Models\desain;

class DesainerDashboardController extends Controller
{
    public function index()
    {
        $desains = desain::with('order')
            ->whereIn('id_desain', function ($query) {
                $query->selectRaw('MAX(id_desain)')
                      ->from('desain')
                      ->groupBy('id_pemesanan');
            })
            ->get();

        return view('desainer.dashboard.desainer', compact('desains'));
    }

    public function show($id)
    {
        $desain = desain::with('order')->findOrFail($id);
        return view('desainer.desain.show', compact('desain'));
    }


}