<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Invoice #{{ $order->order_code }} - Washora Laundry</title>
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
            .print-card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen p-4 sm:p-8 flex flex-col items-center font-sans text-slate-800 antialiased">
    <!-- Top Action Toolbar -->
    <div class="no-print max-w-lg w-full mb-6 flex items-center justify-between">
        <button onclick="window.close()" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold transition-all">
            &larr; Tutup Jendela
        </button>
        <button onclick="window.print()" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak Struk Sekarang</span>
        </button>
    </div>

    <!-- Printable Thermal Invoice Card -->
    <div class="print-card bg-white max-w-lg w-full rounded-3xl p-8 border border-slate-200 shadow-xl space-y-6">
        <!-- Brand Header -->
        <div class="text-center space-y-1 pb-4 border-b-2 border-dashed border-slate-200">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">WASHORA LAUNDRY</h1>
            <p class="text-xs text-slate-500">Smart & Modern Laundry Services</p>
            <p class="text-[11px] text-slate-400">Jl. Pelajar Pejuang 45 No. 88 &bull; Telp / WA: 0812-3456-7890</p>
        </div>

        <!-- Receipt Metadata -->
        <div class="grid grid-cols-2 gap-2 text-xs">
            <div>
                <span class="text-slate-400 block font-semibold">No. Nota / Resi:</span>
                <span class="font-mono font-bold text-slate-900 text-sm">#{{ $order->order_code }}</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block font-semibold">Tanggal:</span>
                <span class="font-medium text-slate-800">{{ $order->created_at->translatedFormat('d/m/Y H:i') }}</span>
            </div>
            <div class="pt-2">
                <span class="text-slate-400 block font-semibold">Pelanggan:</span>
                <span class="font-bold text-slate-900">{{ $order->user->name }} ({{ $order->user->phone }})</span>
            </div>
            <div class="pt-2 text-right">
                <span class="text-slate-400 block font-semibold">Estimasi Selesai:</span>
                <span class="font-bold text-slate-900">{{ $order->estimated_completed_at ? $order->estimated_completed_at->translatedFormat('d/m/Y H:i') : '-' }}</span>
            </div>
        </div>

        <!-- Items Breakdown -->
        <div class="py-2 border-y border-dashed border-slate-200">
            <table class="w-full text-xs text-left">
                <thead>
                    <tr class="text-slate-400 uppercase text-[10px] font-bold">
                        <th class="py-2">Item Layanan</th>
                        <th class="py-2 text-center">Qty</th>
                        <th class="py-2 text-right">Harga</th>
                        <th class="py-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-2.5 font-bold text-slate-800">
                                {{ $item->item_name }}
                            </td>
                            <td class="py-2.5 text-center font-medium text-slate-600">
                                {{ $item->quantity }} {{ $item->unit }}
                            </td>
                            <td class="py-2.5 text-right font-medium text-slate-600">
                                {{ number_format($item->unit_price, 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 text-right font-bold text-slate-900">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Price Totals -->
        <div class="space-y-1.5 text-xs text-slate-600">
            <div class="flex justify-between">
                <span>Total Berat Ditimbang:</span>
                <span class="font-bold text-slate-900">{{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}</span>
            </div>
            <div class="flex justify-between pt-2 border-t border-slate-200 text-sm">
                <span class="font-black text-slate-900">TOTAL BIAYA:</span>
                <span class="text-lg font-black text-slate-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer / QR Note -->
        <div class="text-center pt-4 border-t-2 border-dashed border-slate-200 space-y-2 text-[11px] text-slate-400">
            <p class="font-bold text-slate-700">Terima kasih atas kepercayaan Anda!</p>
            <p>Lacak status laundry Anda secara realtime di: <strong class="text-slate-700">{{ url('/tracking?code=' . $order->order_code) }}</strong></p>
            <p class="italic text-[10px]">Harap membawa nota ini saat pengambilan laundry fisik di outlet.</p>
        </div>
    </div>
</body>
</html>
