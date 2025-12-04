<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Helpers\Notify;

class BaristaController extends Controller
{
    // Halaman utama barista: pesanan hari ini atau semua pending/processing/ready
  public function index(Request $request)
    {
        // Default = hari ini
        $date = $request->date ?? now()->toDateString();

        $orders = Order::whereDate('created_at', $date)
            ->with('table')
            ->orderBy('created_at', 'desc') // terbaru di atas
            ->get();

        // ambil notif
        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('barista.orders.index', compact('orders', 'notifications', 'date'));
    }

    // Detail order untuk barista
    public function show($id)
    {
        $order = Order::with(['items.menu', 'table'])->findOrFail($id);
        return view('barista.orders.show', compact('order'));
    }

    // Update status READY
    public function markReady($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'ready';
        $order->save();

        // Kirim notifikasi ke waiter
        $waiter = User::find($order->user_id);
        if ($waiter) {
            Notify::send(
                $waiter->id,
                "Pesanan Siap!",
                "Pesanan untuk meja {$order->table_id} sudah siap disajikan.",
                "ready"
            );
        }

        return back()->with('success', 'Status pesanan diubah menjadi READY');
    }

    // Filter pesanan berdasarkan tanggal
    public function filter(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');

        $orders = Order::whereDate('created_at', $date)
            ->with(['items.menu', 'table'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Tambahkan ini
        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('barista.orders.index', compact('orders', 'notifications'));
    }

}
