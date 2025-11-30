<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Barista: daftar order
    public function index() {
        $orders = Order::with('table','items.menu','user')
            ->orderBy('created_at','desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    // Waiter pilih menu setelah pilih meja
    public function createFromTable($tableId)
    {
        $table = Table::findOrFail($tableId);
        $menus = Menu::all();

        return view('waiters.orders.create', compact('table', 'menus'));
    }

    // Simpan order
    public function storeFromTable(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'customer_name' => 'required|string|max:255',
        ]);

        // Buat order
        $order = Order::create([
            'table_id' => $request->table_id,
            'user_id'  => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'status'   => 'pending',
        ]);

        // Simpan item order
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

        // ubah meja jadi occupied
        Table::where('id', $request->table_id)
            ->update(['status' => 'occupied']);

        return redirect()->route('waiters.table.select')
            ->with('success', 'Order berhasil dibuat!');
    }

    // Barista update status
    public function updateStatus(Order $order, Request $request) {
        $request->validate(['status' => 'required|in:pending,proses,selesai']);
        $order->update(['status' => $request->status]);

        return back()->with('success','Status order diperbarui!');
    }


    public function baristaIndex()
    {
        // Tampilkan semua order yang belum selesai
        $orders = Order::whereIn('status', ['pending', 'processing', 'ready'])
        ->with('table')
        ->orderBy('created_at', 'asc')
        ->get();

        return view('barista.orders.index', compact('orders'));
    }

    public function baristaShow($id)
    {
        $order = Order::with(['items.menu', 'table'])->findOrFail($id);

        return view('barista.orders.show', compact('order'));
    }

    public function setReady($id)
    {
        $order = Order::findOrFail($id);

        $order->status = "ready";
        $order->save();

        return redirect()->route('barista.orders.index')->with('success', 'Pesanan sudah siap!');
    }

}
