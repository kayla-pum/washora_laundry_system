<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Transaksi - Washora ({{ $periodLabel }})</title>
    <style>
        @page {
            margin: 28px 32px 35px 32px;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .brand-title {
            font-size: 20px;
            font-weight: 800;
            color: #0369a1;
            letter-spacing: -0.5px;
            margin: 0;
            padding: 0;
        }
        .brand-subtitle {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }
        .company-contact {
            font-size: 9px;
            color: #475569;
            margin-top: 3px;
        }
        .header-right {
            text-align: right;
            vertical-align: top;
        }
        .doc-title {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .doc-period {
            font-size: 10px;
            font-weight: 700;
            color: #0284c7;
            margin-top: 2px;
        }
        .doc-meta {
            font-size: 8px;
            color: #94a3b8;
            margin-top: 3px;
        }

        /* Summary Cards */
        .summary-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: separate;
            border-spacing: 8px 0;
        }
        .summary-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            text-align: center;
        }
        .summary-label {
            font-size: 8px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .summary-val {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
        }
        .text-revenue {
            color: #0369a1;
        }

        /* Transaction Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-top: 5px;
        }
        .data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: 700;
            text-align: left;
            padding: 7px 8px;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .data-table th.text-right,
        .data-table td.text-right {
            text-align: right;
        }
        .data-table th.text-center,
        .data-table td.text-center {
            text-align: center;
        }
        .data-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .data-table tfoot td {
            background-color: #f1f5f9;
            font-weight: 800;
            border-top: 2px solid #0f172a;
            padding: 8px;
            font-size: 9.5px;
            color: #0f172a;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 7.5px;
            font-weight: 700;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-completed {
            background-color: #dcfce7;
            color: #166534;
        }
        .badge-ready {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        .badge-washing, .badge-processing, .badge-finishing {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-confirmed {
            background-color: #f1f5f9;
            color: #334155;
        }
        .badge-pending {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Signatures */
        .sig-table {
            width: 100%;
            margin-top: 28px;
            page-break-inside: avoid;
        }
        .sig-box {
            width: 40%;
            text-align: center;
            font-size: 9px;
        }
        .sig-space {
            height: 48px;
        }
        .sig-name {
            font-weight: 800;
            text-decoration: underline;
            color: #0f172a;
        }

        /* Footer */
        .footer-note {
            margin-top: 20px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 6px;
            font-size: 7.5px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Header Identitas Usaha Washora -->
    <table class="header-table">
        <tr>
            <td style="vertical-align: top;">
                <h1 class="brand-title">WASHORA LAUNDRY SYSTEM</h1>
                <div class="brand-subtitle">Smart Laundry System &bull; Layanan Cuci Kiloan, Satuan & Paket Bundling</div>
                <div class="company-contact">
                    Jl. Pelajar Pejuang 45 No. 88 &bull; WhatsApp: 0889-0629-6474 &bull; Email: cs@washora.com
                </div>
            </td>
            <td class="header-right">
                <div class="doc-title">REKAP TRANSAKSI</div>
                <div class="doc-period">Periode: {{ $periodLabel }}</div>
                <div class="doc-meta">Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</div>
            </td>
        </tr>
    </table>

    <!-- Ringkasan Statistik -->
    <table class="summary-table">
        <tr>
            <td class="summary-card" style="width: 33.3%;">
                <div class="summary-label">Total Transaksi</div>
                <div class="summary-val">{{ $totalOrdersCount }} <span style="font-size: 10px; font-weight: normal; color: #64748b;">Pesanan</span></div>
            </td>
            <td class="summary-card" style="width: 33.3%;">
                <div class="summary-label">Total Omset Pendapatan</div>
                <div class="summary-val text-revenue">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </td>
            <td class="summary-card" style="width: 33.3%;">
                <div class="summary-label">Total Volume Cucian</div>
                <div class="summary-val">{{ number_format($totalWeight, 1) }} <span style="font-size: 10px; font-weight: normal; color: #64748b;">Kg</span></div>
            </td>
        </tr>
    </table>

    <!-- Rincian Transaksi -->
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 25px;">No</th>
                <th style="width: 75px;">Tanggal</th>
                <th style="width: 95px;">Kode Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Jenis Layanan / Paket</th>
                <th class="text-center" style="width: 75px;">Status</th>
                <th class="text-right" style="width: 85px;">Total Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $idx => $order)
                @php
                    $firstItem = $order->items->first();
                    $serviceLabel = $firstItem ? $firstItem->item_name : 'Layanan Laundry';
                    if ($order->items->count() > 1) {
                        $serviceLabel .= ' (+' . ($order->items->count() - 1) . ' item)';
                    }
                    
                    $badgeClass = match($order->status) {
                        'completed' => 'badge-completed',
                        'ready' => 'badge-ready',
                        'washing', 'processing', 'finishing' => 'badge-washing',
                        'confirmed' => 'badge-confirmed',
                        default => 'badge-pending',
                    };
                @endphp
                <tr>
                    <td class="text-center" style="color: #94a3b8;">{{ $idx + 1 }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td style="font-family: monospace; font-weight: 700; color: #0f172a;">#{{ $order->order_code }}</td>
                    <td><strong>{{ $order->user->name ?? 'Pelanggan Umum' }}</strong></td>
                    <td>{{ $serviceLabel }}</td>
                    <td class="text-center">
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="text-right" style="font-weight: 700; color: #0369a1;">
                        Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 25px; color: #94a3b8;">
                        Tidak ada catatan transaksi pada periode laporan ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($orders->isNotEmpty())
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right">TOTAL PENDAPATAN PERIODE INI:</td>
                    <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Tanda Tangan & Pengesahan -->
    <table class="sig-table">
        <tr>
            <td class="sig-box">
                <div>Petugas Kasir / Operasional,</div>
                <div class="sig-space"></div>
                <div class="sig-name">( Petugas Outlet Washora )</div>
                <div style="font-size: 8px; color: #64748b;">Staff Pelayanan</div>
            </td>
            <td style="width: 20%;"></td>
            <td class="sig-box">
                <div>Bandung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div>Penanggung Jawab / Admin,</div>
                <div class="sig-space"></div>
                <div class="sig-name">( Administrator Washora )</div>
                <div style="font-size: 8px; color: #64748b;">Manajer Operasional</div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Dokumen ini merupakan cetakan rekapitulasi resmi sistem komputerisasi Washora Laundry System &bull; Halaman dicetak secara otomatis &bull; Valid tanpa cap basah.
    </div>
</body>
</html>
