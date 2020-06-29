@extends('layouts.default')

@section('title', '商品一覧')

@section('content')
@section('nav_title', '商品一覧')
@section('nav_content')
<li>
    <a class="nav_link" href="{{ route('cart') }}">カートへ</a>
</li>
<li>
    <a class="nav_link" href="{{ route('result') }}">購入履歴へ</a>
</li>
@endsection
@foreach ($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach

@if (Session::has('success'))
<p>成功しました</p>
@endif

<section>
    <ul class="list-group" style="display.flex">
        @forelse ($items as $item)
        @if(intval($item->stock) < 0) <li class="list-group-item disabled">
            @else
            <li class="list-group-item" style="display: flex;">
                @endif
                <div style="width: 30%;">
                    <div>
                        <img src="{{ asset('storage/photos/' . $item->image) }}">
                    </div>
                    <div>
                        <span>{{ $item->name }}: </span>
                        <span class="price">{{ $item->price }}円</span>
                    </div>
                </div>
                <span class="item">
                    <form action="{{ route('cart.add', ['item_id' => $item->id]) }}" method="post">
                        {{ csrf_field() }}
                        @if(intval($item->stock) > 0)
                        <button type="submit" class="btn btn-primary">
                            <i class="material-icons">shopping_cart</i>
                        </button>
                        @else
                        <p style="color: red">売り切れ</p>
                        @endif
                    </form>
                </span>
            </li>
            @empty
            <p>商品はありません</p>
            @endforelse
    </ul>
</section>

@endsection