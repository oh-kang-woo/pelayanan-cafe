<?php

namespace App\Http\Controllers;

use App\Models\Table;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();

        return view('waiters.table.index', compact('tables'));
    }
}

