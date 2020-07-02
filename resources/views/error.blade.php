@extends('layouts.default')

@section('title', '購入を中断しました')

@section('content')
<h1>購入を中断しました</h1>
@forelse ($error_items as $error_item)
<p>在庫が足りません: {{ $error_item }}</p>
@empty
<p>エラーはありません</p>
@endforelse

<a href="{{ route('cart') }}">カートへ戻る</a>

@endsection