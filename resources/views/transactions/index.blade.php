@extends('layouts.app')

@section('content')
<h2>Daftar Transaksi</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5">
    <tr>
        <th>Kode</th>
        <th>Meja</th>
        <th>Nama Tamu</th>
        <th>Menu</th>
        <th>Total</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->code }}</td>
            <td>{{ $transaction->order->table->name }}</td>
            <td>{{ $transaction->order->customer_name }}</td>
            <td>
                <ul>
                    @foreach($transaction->order->items as $item)
                        <li>{{ $item->menu->name }} x {{ $item->quantity }} = Rp {{ number_format($item->subtotal) }}</li>
                    @endforeach
                </ul>
            </td>
            <td>Rp {{ number_format($transaction->total) }}</td>
            <td>{{ $transaction->status }}</td>
            <td>
                @if($transaction->status == 'unpaid')
                <form action="{{ route('transactions.pay', $transaction->order->id) }}" method="POST">
                    @csrf
                    <button type="submit">Bayar</button>
                </form>
                @else
                    Sudah Dibayar
                @endif
            </td>
        </tr>
    @endforeach
</table>
@endsection
