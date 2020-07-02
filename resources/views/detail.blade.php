@extends('layouts.default')

@section('title', '購入詳細')

@section('content')

@section('nav_title', '購入明細')

@section('nav_content')
<li>
    <a class="nav_link" href="{{ route('result') }}">購入履歴へ</a>
</li>
@endsection
<table class="table">
    <tr>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
        <th>小計</th>
    </tr>
    @forelse ($details as $detail)
    <tr>
        <td>{{ $detail->item->name }}</td>
        <td class="price">{{ $detail->item->price }}円</td>
        <td>{{ $detail->amount }}個</td>
        <td>{{ $detail->subtotal }}円</td>
    </tr>
    @empty
    <p>アイテムはありません</p>
    @endforelse
</table>
@endsection