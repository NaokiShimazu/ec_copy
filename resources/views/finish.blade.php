@extends('layouts.default')

@section('title', '購入完了')

@section('content')

@section('nav_title', 'お買い上げありがとうございます')

@section('nav_content')
<li>
    <a class="nav_link" href="{{ route('index') }}">商品一覧へ</a>
</li>
<li>
    <a class="nav_link" href="{{ route('result') }}">購入履歴へ</a>
</li>
@endsection

@foreach ($error_items as $error_item)
<p>在庫不足のため購入できませんでした: {{ $error_item }}</p>
@endforeach

<table class="table">
    <tr>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
    </tr>
    @forelse ($purchases as $purchase)
    <tr>
        <td><img src="{{ asset('storage/photos/' . $purchase->item->image) }}" style="height: 80px"></td>
        <td>{{ $purchase->item->name }}</td>
        <td class="price">{{ $purchase->item->price }}円</td>
        <td>{{ $purchase->amount }}個</td>
    </tr>
    @empty
    <p>アイテムはありません</p>
    @endforelse
</table>

<div class="text-center">
    合計: <span class="price">{{ $sum }}円</span>
</div>
@endsection