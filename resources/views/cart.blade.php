@extends('layouts.default')

@section('title', 'カート')

@section('content')
@section('nav_title', 'カート内の商品一覧')
    
@section('nav_content')
<li class="nav-item">
    <a class="nav_link" href="{{ route('result') }}">購入履歴へ</a>
</li>
<li class="nav-item">
    <a class="nav_link" href="{{ route('index') }}">商品一覧へ</a>
</li>

@endsection

@foreach ($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach

@if (Session::has('success'))
<p>成功しました</p>
@endif

<table class="table">
    <tr>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
        <th>操作</th>
    </tr>
    @forelse ($carts as $cart)
    <tr>
        <td><img src="{{ asset('storage/photos/' . $cart->item->image) }}" style="height: 80px;"></td>
        <td>{{ $cart->item->name }}</td>
        <td class="price">{{ $cart->item->price }}円</td>
        <td>
            <form action="{{ route('cart.update', ['item_id' => $cart->item->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <input type="number" name="new_quantity" value="{{ $cart->amount }}">個
                <button type="submit" class="btn btn-success">
                    <i class="material-icons">autorenew</i>
                </button>
            </form>
        </td>
        <td>
            <form action="{{ route('cart.delete' , ['item_id' => $cart->item->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <button type="submit" class="btn btn-danger">
                    <i class="material-icons">delete</i>
                </button>
            </form>
        </td>
    </tr>
    @empty
    <p>アイテムはありません</p>
    @endforelse
</table>

<section>
    <div class="text-center">
        合計: <span class="price">{{ $sum }}円</span>

        <form action="{{ route('finish') }}" method="post">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">
                <i class="material-icons">check_circle_outline</i>
            </button>
        </form>
    </div>
</section>
@endsection