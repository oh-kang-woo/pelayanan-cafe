<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Table;
use App\Models\User;
use App\Helpers\Notify;

class OrderController extends Controller
{
    // Simpan order (umum)
    public function store(Request $request)
    {
        $order = Order::create([
            'table_id' => $request->table_id,
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'status' => 'pending',
            'total_price' => $request->total_price
        ]);

        // Notifikasi untuk waiter
        $waiters = User::where('role','waiter')->get();
        foreach ($waiters as $w) {
            Notify::send(
                $w->id,
                "Pesanan Baru",
                "Ada pesanan baru dari meja {$order->table_id}",
                "order"
            );
        }

        // Notifikasi untuk barista
        $baristas = User::where('role','barista')->get();
        foreach ($baristas as $b) {
            Notify::send(
                $b->id,
                "Order Masuk",
                "Ada pesanan yang harus dibuat",
                "order"
            );
        }

        return back();
    }

    // Buat order dari waiter (pilih meja)
   public function storeFromTable(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'customer_name' => 'required|string|max:255',
        ]);

        $order = Order::create([
            'table_id' => $request->table_id,
            'user_id'  => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'status'   => 'pending',
        ]);

        foreach ($request->menus as $menuId => $qty) {
            if ($qty > 0) {
                $menu = Menu::find($menuId);

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $menu->id,
                    'quantity' => $qty,
                    'subtotal' => $menu->price * $qty,
                ]);
            }
        }

        // UPDATE STATUS MEJA
        Table::where('id', $request->table_id)
            ->update(['status' => 'occupied']);

        // ============================================
        // 🔔 NOTIFIKASI BARISTA (PENTING)
        // ============================================
        $baristas = User::where('role', 'barista')->get();

        foreach ($baristas as $b) {
            Notify::send(
                $b->id,
                "Order Masuk",
                "Ada pesanan baru dari meja {$order->table_id}",
                "order"
            );
        }

        return redirect()->route('waiters.table.select')
            ->with('success', 'Order berhasil dibuat!');
    }

    // Barista index
    public function baristaIndex()
    {
        $orders = Order::whereIn('status', ['pending', 'processing', 'ready'])
            ->with('table')
            ->orderBy('created_at', 'asc')
            ->get();

        // ambil notif untuk user barista yang login
        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('barista.orders.index', compact('orders', 'notifications'));
    }


    public function baristaShow($id)
    {
        $order = Order::with(['items.menu', 'table'])->findOrFail($id);

        return view('barista.orders.show', compact('order'));
    }

    public function markReady($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return back()->with('error', 'Order tidak ditemukan!');
        }

        $order->status = 'ready';
        $order->save();

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
}
