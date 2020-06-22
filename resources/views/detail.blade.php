@extends('layouts.default')

@section('title', '購入詳細')

@section('content')
<h1>購入詳細</h1>

<a href="{{ route('result') }}">注文履歴へ</a>

<table>
    <tr>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
        <th>小計</th>
    </tr>
    @forelse ($details as $detail)
    <tr>
        <td>{{ $detail->item->name }}</td>
        <td>{{ $detail->item->price }}円</td>
        <td>{{ $detail->amount }}個</td>
        <td>{{ $detail->subtotal }}円</td>
    </tr>
    @empty
    <p>アイテムはありません</p>
    @endforelse
</table>
@endsection