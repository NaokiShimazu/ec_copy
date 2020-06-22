@extends('layouts.default')

@section('title', '管理ツール')

@section('content')
<h1>管理ページ</h1>
<section>
    <form action="{{ url('/logout') }}" method="post">
        {{ csrf_field() }}
        <button type="submit">ログアウト</button>
    </form>

    <a href="{{ route('result') }}">購入履歴へ</a>

</section>

@foreach ($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach

@if (Session::has('success'))
<p>成功しました</p>
@endif

<section>
    <form action="{{ route('tool.insert') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div>
            <label>商品名: <input type="text" name="name"></label>
            <label>価格: <input type="number" name="price"></label>
            <label>数量: <input type="number" name="stock"></label>
        </div>
        <div>
            <select name="status">
                <option value="1">公開</option>
                <option value="0">非公開</option>
            </select>
        </div>
        <div>
            <input type="file" name="image">
        </div>
        <div>
            <input type="submit" value="追加">
        </div>
    </form>
</section>

<section>
    <table>
        <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫</th>
            <th>ステータス</th>
            <th>操作</th>
        </tr>

        @forelse ($items as $item)
        <tr>
            <td><img src="{{ asset('storage/photos/' . $item->image) }}"></td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->price }}</td>
            <td>
                <form action="{{ route('tool.update', ['item' => $item->id]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <input type="number" name="new_quantity" value="{{ $item->stock }}">
                    <input type="submit" value="変更">
                </form>
            </td>
            <td>
                {{ $item->status==true ? '公開' : '非公開' }}
                <form action="{{ route('tool.switch', ['item' => $item->id]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <input type="submit" value="{{ $item->status==true ? '非公開にする' : '公開にする' }}">
                </form>
            </td>
            <td>
                <form action="{{ route('tool.delete', ['item' => $item->id]) }}" method="post">
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
</section>
@endsection