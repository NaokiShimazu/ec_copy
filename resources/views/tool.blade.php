@extends('layouts.default')

@section('title', '管理ツール')

@section('content')
@section('nav_title', '商品管理ページ')

@section('nav_content')
<li>
    <a class="nav-link" href="{{ route('result') }}">購入履歴へ</a>
</li>
@endsection
@foreach ($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach

@if (Session::has('success'))
<p>成功しました</p>
@endif

<section>
    <form action="{{ route('tool.insert') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label>商品名: <input class="form-control" type="text" name="name"></label>
            <label>価格: <input class="form-control" type="number" name="price"></label>
            <label>数量: <input class="form-control" type="number" name="stock"></label>
        </div>
        <div class="form-group">
            <select class="form-control" style="width: 200px;" name="status">
                <option value="1">公開</option>
                <option value="0">非公開</option>
            </select>
        </div>
        <div class="form-group">
            <input class="form-control" style="width: 500px;" type="file" name="image">
        </div>
        <input type="submit" value="追加">
    </form>
</section>

<section>
    <table class="table">
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
            <td class="price">{{ $item->price }}円</td>
            <td>
                <form action="{{ route('tool.update', ['item_id' => $item->id]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <input type="number" name="new_quantity" value="{{ $item->stock }}">
                    <button type="submit" class="btn btn-success">
                        <i class="material-icons">autorenew</i>
                    </button>
                </form>
            </td>
            <td>
                {{ $item->status==true ? '公開' : '非公開' }}
                <form action="{{ route('tool.switch', ['item_id' => $item->id]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <button type="submit" class="btn btn-success">
                        <i class="material-icons">swap_horiz</i>
                    </button>
                </form>
            </td>
            <td>
                <form action="{{ route('tool.delete', ['item_id' => $item->id]) }}" method="post">
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
</section>
@endsection