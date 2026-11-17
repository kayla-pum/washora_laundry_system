<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
  
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = trim($request->input('search', ''));

        $query = Review::with(['user', 'order'])->latest();

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'pending') {
            $query->where('is_published', false);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('comment', 'like', "%{$search}%")
                    ->orWhereHas('order', function ($oq) use ($search) {
                        $oq->where('order_code', 'like', "%{$search}%");
                    });
            });
        }

        $reviews = $query->paginate(12)->withQueryString();

        $stats = [
            'total' => Review::count(),
            'published' => Review::where('is_published', true)->count(),
            'pending' => Review::where('is_published', false)->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'status', 'search', 'stats'));
    }

   
    public function toggle(Review $review)
    {
        $review->update([
            'is_published' => ! $review->is_published,
        ]);

        $message = $review->is_published
            ? 'Testimoni berhasil disetujui dan akan ditampilkan secara publik di halaman beranda.'
            : 'Testimoni berhasil disembunyikan dari tampilan publik.';

        return back()->with('success', $message);
    }

    
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}
