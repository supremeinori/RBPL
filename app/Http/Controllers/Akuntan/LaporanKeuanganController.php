<?php

namespace App\Http\Controllers\Akuntan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::orderBy('nama')->get();

        $data = null;
        $filters = null;

        if ($request->filled('dari_tanggal') && $request->filled('sampai_tanggal')) {
            $data   = $this->generateData($request);
            $filters = $request->all();
        }

        return view('akuntan.laporan', compact('customers', 'data', 'filters'));
    }

    public function downloadPdf(Request $request)
    {
        $customers = Customer::orderBy('nama')->get();
        $data      = $this->generateData($request);
        $filters   = $request->all();

        $pdf = Pdf::loadView('akuntan.laporan_pdf', compact('data', 'filters'))
            ->setPaper('a4', 'landscape');

        $filename = 'laporan-keuangan-' . $filters['dari_tanggal'] . '-sd-' . $filters['sampai_tanggal'] . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadCsv(Request $request)
    {
        $data    = $this->generateData($request);
        $filters = $request->all();

        $filename = 'laporan-keuangan-' . $filters['dari_tanggal'] . '-sd-' . $filters['sampai_tanggal'] . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($data, $filters) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fputs($file, "\xEF\xBB\xBF");

            $jenis = $filters['jenis_laporan'] ?? 'ringkasan';

            // Header info
            fputcsv($file, ['LAPORAN KEUANGAN MR BONGKENG']);
            fputcsv($file, ['Periode:', $filters['dari_tanggal'] . ' s/d ' . $filters['sampai_tanggal']]);
            fputcsv($file, ['Jenis:', ucwords(str_replace('_', ' ', $jenis))]);
            fputcsv($file, []);

            if ($jenis === 'ringkasan') {
                fputcsv($file, ['RINGKASAN PEMASUKAN']);
                fputcsv($file, ['Total Transaksi', $data['ringkasan']['total_transaksi']]);
                fputcsv($file, ['Total Pembayaran Masuk', 'Rp ' . number_format($data['ringkasan']['total_masuk'], 0, ',', '.')]);
                fputcsv($file, ['Total DP Masuk', 'Rp ' . number_format($data['ringkasan']['total_dp'], 0, ',', '.')]);
                fputcsv($file, ['Total Pelunasan', 'Rp ' . number_format($data['ringkasan']['total_pelunasan'], 0, ',', '.')]);
                fputcsv($file, []);
            }

            // Detail transaksi header
            fputcsv($file, ['Tanggal Bayar', 'Pesanan', 'Pelanggan', 'Jenis', 'Metode', 'Status', 'Nominal']);

            foreach ($data['transaksi'] as $row) {
                fputcsv($file, [
                    date('d/m/Y', strtotime($row->tanggal_bayar)),
                    $row->order->nama_pesanan ?? '-',
                    $row->order->customer->nama ?? '-',
                    strtoupper($row->jenis_pembayaran),
                    $row->metode_pembayaran ?? '-',
                    strtoupper($row->status_verifikasi),
                    $row->nominal,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateData(Request $request): array
    {
        $query = Pembayaran::with(['order.customer'])
            ->whereBetween('tanggal_bayar', [
                $request->dari_tanggal,
                $request->sampai_tanggal,
            ]);

        // Filter status verifikasi
        if ($request->filled('status_pembayaran') && $request->status_pembayaran !== 'semua') {
            $query->where('status_verifikasi', $request->status_pembayaran);
        }

        // Filter jenis (dp / pelunasan)
        if ($request->filled('jenis_pembayaran') && $request->jenis_pembayaran !== 'semua') {
            $query->where('jenis_pembayaran', $request->jenis_pembayaran);
        }

        // Filter pelanggan
        if ($request->filled('id_pelanggan') && $request->id_pelanggan !== 'semua') {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('id_pelanggan', $request->id_pelanggan);
            });
        }

        $transaksi = $query->orderBy('tanggal_bayar', 'asc')->get();

        $approved = $transaksi->where('status_verifikasi', 'disetujui');

        $ringkasan = [
            'total_transaksi'  => $transaksi->count(),
            'total_masuk'      => $approved->sum('nominal'),
            'total_dp'         => $approved->where('jenis_pembayaran', 'dp')->sum('nominal'),
            'total_pelunasan'  => $approved->where('jenis_pembayaran', 'pelunasan')->sum('nominal'),
        ];

        return [
            'transaksi' => $transaksi,
            'ringkasan' => $ringkasan,
        ];
    }
}
