@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Pilih Meja</h2>

<div class="grid grid-cols-3 gap-4">
    @foreach($tables as $table)
        <a href="{{ route('waiters.order.create', $table->id) }}"
           class="p-4 bg-blue-500 text-white rounded shadow block text-center">
           {{ $table->name }} <br>
           Status: {{ $table->status }}
        </a>
    @endforeach
</div>
@endsection
