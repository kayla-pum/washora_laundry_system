<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_code',
        'user_id',
        'pickup_address',
        'customer_note',
        'total_weight',
        'total_price',
        'estimated_completed_at',
        'status',
        'confirmed_at',
        'confirmed_by',
    ];

    protected function casts(): array
    {
        return [
            'total_weight' => 'decimal:2',
            'total_price' => 'decimal:2',
            'estimated_completed_at' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    public const STATUSES = [
        'pending' => [
            'label' => 'Menunggu Verifikasi',
            'badge' => 'bg-amber-100 text-amber-800 border-amber-300',
            'dot' => 'bg-amber-500',
            'icon' => 'clock',
            'step' => 1,
        ],
        'confirmed' => [
            'label' => 'Terkonfirmasi',
            'badge' => 'bg-blue-100 text-blue-800 border-blue-300',
            'dot' => 'bg-blue-500',
            'icon' => 'check-circle',
            'step' => 2,
        ],
        'processing' => [
            'label' => 'Diproses / Penjemputan',
            'badge' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
            'dot' => 'bg-indigo-500',
            'icon' => 'truck',
            'step' => 3,
        ],
        'washing' => [
            'label' => 'Sedang Dicuci',
            'badge' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
            'dot' => 'bg-cyan-500',
            'icon' => 'droplet',
            'step' => 4,
        ],
        'finishing' => [
            'label' => 'Finishing & Setrika',
            'badge' => 'bg-purple-100 text-purple-800 border-purple-300',
            'dot' => 'bg-purple-500',
            'icon' => 'sparkles',
            'step' => 5,
        ],
        'ready' => [
            'label' => 'Siap Diambil / Diantar',
            'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'dot' => 'bg-emerald-500',
            'icon' => 'package-check',
            'step' => 6,
        ],
        'completed' => [
            'label' => 'Selesai',
            'badge' => 'bg-slate-100 text-slate-800 border-slate-300',
            'dot' => 'bg-slate-600',
            'icon' => 'badge-check',
            'step' => 7,
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'badge' => 'bg-rose-100 text-rose-800 border-rose-300',
            'dot' => 'bg-rose-500',
            'icon' => 'x-circle',
            'step' => 0,
        ],
    ];

    public function getStatusInfoAttribute(): array
    {
        return self::STATUSES[$this->status] ?? [
            'label' => ucfirst($this->status),
            'badge' => 'bg-gray-100 text-gray-800 border-gray-300',
            'dot' => 'bg-gray-500',
            'icon' => 'info',
            'step' => 0,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class, 'order_id')->latest();
    }

    /**
     * Generate WhatsApp confirmation message link
     */
    public function getWhatsAppUrlAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->user->phone ?? '');
        if (str_starts_with($phone, '0')) {
            $phone = '62'.substr($phone, 1);
        }

        $itemsSummary = $this->items->map(function ($item) {
            return '• '.$item->item_name.' ('.$item->quantity.' '.$item->unit.') : Rp '.number_format($item->subtotal, 0, ',', '.');
        })->implode("\n");

        $estCompletion = $this->estimated_completed_at ? $this->estimated_completed_at->translatedFormat('d M Y - H:i WIB') : 'Segera dikonfirmasi';
        $totalBiaya = number_format($this->total_price ?? 0, 0, ',', '.');
        $weight = $this->total_weight ? $this->total_weight.' Kg' : '-';

        $text = "Halo Kak *{$this->user->name}*! 👋\n\n"
            ."Terima kasih telah mencuci di *Washora Laundry* ✨\n"
            ."Pesanan Anda telah kami periksa dan konfirmasi dengan rincian berikut:\n\n"
            ."📦 *Kode Pesanan:* #{$this->order_code}\n"
            ."⚖️ *Total Berat/Qty:* {$weight}\n"
            ."📋 *Rincian Layanan:*\n{$itemsSummary}\n\n"
            ."💰 *Total Biaya:* Rp {$totalBiaya}\n"
            ."⏱️ *Estimasi Selesai:* {$estCompletion}\n\n"
            ."Anda dapat memantau proses pencucian secara realtime melalui link website kami:\n"
            .url('/tracking?code='.$this->order_code)."\n\n"
            .'Ada pertanyaan? Silakan balas pesan ini. Terima kasih! 🙏';

        return 'https://api.whatsapp.com/send?phone='.$phone.'&text='.urlencode($text);
    }
}
