<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Menu;
use Illuminate\Http\Request;

class WaiterOrderController extends Controller
{
    // Halaman pilih meja
    public function selectTable()
    {
        $tables = Table::all();
        return view('waiters.table.index', compact('tables'));
    }

    // Halaman buat order setelah pilih meja
    public function create($tableId)
    {
        $table = Table::findOrFail($tableId);
        $menus = Menu::all();

        return view('waiters.orders.create', compact('table', 'menus'));
    }
}
