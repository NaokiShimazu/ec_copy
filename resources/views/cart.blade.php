@extends('layouts.default')

@section('title', 'カート')

@section('content')
<h1>カート内の商品一覧</h1>

<section class="link">
    <form action="{{ url('/logout') }}" method="post" class="flex">
        {{ csrf_field() }}
        <button type="submit">ログアウト</button>
    </form>

    <a href="{{ route('result') }}" class="flex">購入履歴へ</a>
</section>

@foreach ($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach

@if (Session::has('success'))
<p>成功しました</p>
@endif

<table>
    <tr>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
        <th>操作</th>
    </tr>
    @forelse ($carts as $cart)
    <tr>
        <td><img src="{{ asset('storage/photos/' . $cart->item->image) }}"></td>
        <td>{{ $cart->item->name }}</td>
        <td class="price">{{ $cart->item->price }}円</td>
        <td>
            <form action="{{ route('cart.update', ['item_id' => $cart->item->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <input type="number" name="new_quantity" value="{{ $cart->amount }}">個
                <input type="submit" value="変更する">
            </form>
        </td>
        <td>
            <form action="{{ route('cart.delete' , ['item_id' => $cart->item->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <input type="submit" value="削除する">
            </form>
        </td>
    </tr>
    @empty
    <p>アイテムはありません</p>
    @endforelse
</table>

<section class="right">
    <div class="sum">
        合計: <span class="price">{{ $sum }}円</span>
    </div>

    <div>
        <form action="{{ route('finish') }}" method="post">
            {{ csrf_field() }}
            <input type="submit" value="購入する">
        </form>
    </div>
</section>
@endsection