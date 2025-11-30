<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class WaiterOrderController extends Controller
{
    // Halaman pilih meja
    public function selectTable()
    {
        $tables = Table::all();
        return view('waiters.tables.select', compact('tables'));
    }

    // Halaman buat order
    public function create(Table $table)
    {
        $menus = Menu::all();
        return view('waiters.orders.create', compact('table', 'menus'));
    }

    // Simpan order
    public function store(Request $request)
    {
        // Next step nanti kita isi
    }
}
