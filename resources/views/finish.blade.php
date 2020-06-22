@extends('layouts.default')

@section('title', '購入完了')

@section('content')
<h1>お買い上げありがとうございます</h1>

<form action="{{ url('/logout') }}" method="post">
    {{ csrf_field() }}
    <button type="submit">ログアウト</button>
</form>

<a href="{{ route('index') }}">商品一覧へ</a>

<table>
    <tr>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
    </tr>
    @forelse ($carts as $cart)
    <tr>
        <td><img src="{{ asset('storage/photos/' . $cart->item->image) }}"></td>
        <td>{{ $cart->item->name }}</td>
        <td>{{ $cart->item->price }}円</td>
        <td>{{ $cart->amount }}個</td>
    </tr>
    @empty
    <p>アイテムはありません</p>
    @endforelse
</table>

<div>
    合計: {{ $sum }}円
</div>
@endsection