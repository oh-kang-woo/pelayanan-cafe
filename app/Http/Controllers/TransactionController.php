<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // Lihat transaksi
    public function index() {
        $transactions = Transaction::with('order.table','order.items.menu')->orderBy('created_at','desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    // Bayar transaksi
    public function pay(Order $order) {
        $total = $order->items->sum('subtotal');
        $transaction = Transaction::create([
            'order_id' => $order->id,
            'code' => 'TRX-' . now()->format('Ymd') . '-' . $order->id,
            'total' => $total,
            'status' => 'paid',
        ]);

        $order->update(['status' => 'selesai']);
        return back()->with('success','Transaksi berhasil dibayar!');
    }
}
