@extends('layouts.default')

@section('title', '商品一覧')

@section('content')

<h1>商品一覧</h1>

<section>
    <form action="{{ url('/logout') }}" method="post">
        {{ csrf_field() }}
        <button type="submit">ログアウト</button>
    </form>

    <a href="{{ route('cart') }}">カートへ</a>

</section>

@foreach ($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach

@if (Session::has('success'))
<p>成功しました</p>
@endif

<section>
    <ul>
        @forelse ($items as $item)
        <li>
            <div>
                <img src="{{ asset('storage/photos/' . $item->image) }}">
            </div>
            <div>
                <span>{{ $item->name }}: </span>
                <span>{{ $item->price }}円</span>
            </div>
            <div>
                <form action="{{ route('cart.add', ['item_id' => $item->id]) }}" method="post">
                    {{ csrf_field() }}
                    @if(intval($item->stock) > 0)
                    <input type="submit" value="カートに追加する">
                    @else
                    <p>売り切れ</p>
                    @endif
                </form>
            </div>
        </li>
        @empty
        <p>商品はありません</p>
        @endforelse
    </ul>
</section>

@endsection