<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan Laundry - Washora ({{ $periodLabel }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen p-8 font-sans text-slate-800 antialiased flex flex-col items-center">
    <!-- Toolbar -->
    <div class="no-print max-w-4xl w-full mb-6 flex items-center justify-between">
        <button onclick="window.close()" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold transition-all">
            &larr; Tutup
        </button>
        <button onclick="window.print()" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-md transition-all">
            Cetak Dokumen Laporan
        </button>
    </div>

    <!-- Printable Paper Sheet -->
    <div class="bg-white max-w-4xl w-full rounded-3xl p-10 border border-slate-200 shadow-xl space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between pb-6 border-b-2 border-slate-900">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">WASHORA LAUNDRY</h1>
                <p class="text-xs text-slate-500">Laporan Rekapitulasi Operasional & Omset Keuangan</p>
                <p class="text-[11px] text-slate-400">Jl. Pelajar Pejuang 45 No. 88 &bull; Telp: 0812-3456-7890</p>
            </div>
            <div class="text-right">
                <span class="text-xs font-bold text-slate-400 block">Periode Laporan:</span>
                <span class="text-sm font-black text-slate-900">{{ $periodLabel }}</span>
                <p class="text-[10px] text-slate-400 mt-1">Dicetak pada: {{ date('d/m/Y H:i') }} WIB</p>
            </div>
        </div>

        <!-- Summary Highlights -->
        <div class="grid grid-cols-3 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-200 text-center">
            <div>
                <p class="text-[10px] font-bold uppercase text-slate-400">Total Transaksi</p>
                <p class="text-xl font-black text-slate-900 mt-0.5">{{ $totalOrdersCount }} Pesanan</p>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase text-slate-400">Total Berat Diproses</p>
                <p class="text-xl font-black text-slate-900 mt-0.5">{{ number_format($totalWeight, 1) }} Kg</p>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase text-slate-400">Total Omset Pendapatan</p>
                <p class="text-xl font-black text-emerald-700 mt-0.5">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Table Data -->
        <table class="w-full text-xs text-left">
            <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-300">
                <tr>
                    <th class="py-2.5 px-3">No</th>
                    <th class="py-2.5 px-3">Kode Resi</th>
                    <th class="py-2.5 px-3">Pelanggan</th>
                    <th class="py-2.5 px-3">Tanggal</th>
                    <th class="py-2.5 px-3">Layanan</th>
                    <th class="py-2.5 px-3">Berat</th>
                    <th class="py-2.5 px-3 text-right">Total Biaya</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($orders as $idx => $order)
                    <tr>
                        <td class="py-2.5 px-3 text-slate-400">{{ $idx + 1 }}</td>
                        <td class="py-2.5 px-3 font-bold text-slate-900 font-mono">#{{ $order->order_code }}</td>
                        <td class="py-2.5 px-3">{{ $order->user->name }}</td>
                        <td class="py-2.5 px-3 text-slate-500">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="py-2.5 px-3">{{ $order->items->first()->item_name ?? '-' }}</td>
                        <td class="py-2.5 px-3">{{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}</td>
                        <td class="py-2.5 px-3 text-right font-bold text-slate-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-black bg-slate-100 text-slate-900 border-t-2 border-slate-900">
                    <td colspan="6" class="py-3 px-3 text-right">TOTAL KESELURUHAN:</td>
                    <td class="py-3 px-3 text-right text-sm">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Signature Lines -->
        <div class="pt-8 flex justify-between text-xs text-center">
            <div>
                <p class="text-slate-400">Dibuat Oleh:</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-900 border-t border-slate-400 pt-1 px-6">Petugas Administrasi</p>
            </div>
            <div>
                <p class="text-slate-400">Mengetahui:</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-900 border-t border-slate-400 pt-1 px-6">Manajer Operasional Washora</p>
            </div>
        </div>
    </div>
</body>
</html>
