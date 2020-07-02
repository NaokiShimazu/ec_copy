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
<div style="text-align:center; margin: 10px;">
    <button type="button" class="btn btn-success" style="padding: .375em 7em;" data-toggle="modal"
        data-target="#add-modal">
        <i class="material-icons">add</i>
    </button>
    <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="add-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-modal-title">商品追加</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tool.insert') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>商品名: <input class="form-control" type="text" name="name"></label>
                            <label>価格: <input class="form-control" type="number" name="price"></label>
                            <label>数量: <input class="form-control" type="number" name="stock"></label>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="status">
                                <option value="1">公開</option>
                                <option value="0">非公開</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input id="file" style="display: none;" type="file" name="image" onchange="$('#file-name').val($(this).val())">
                            <button type="button" id="file-button" class="btn btn-secondary">
                                <i class="material-icons">insert_photo</i>
                            </button>
                            <input id="file-name" readonly type="text" value="">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="material-icons">cancel</i>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="material-icons">check</i>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<section>
    <h3 style="display: inline;">商品を編集</h3>
    <button type="button" class="btn btn-primary" style="padding: .375em;" data-toggle="modal"
        data-target="#sort-modal">
        <i class="material-icons">search</i>
    </button>
    <div class="modal fade" id="sort-modal" tabindex="-1" role="dialog" aria-labelledby="sort-modal-title"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sort-modal-title">検索・並べ替え</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tool.options') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('options') }}
                        <div class="form-group">
                            価格が
                            <input type="number" name="lowest_price">
                            円以上
                            <input type="number" name="highest_price">
                            円以下
                        </div>
                        <div class="form-group">
                            在庫が
                            <input type="number" name="lowest_stock">
                            個以上
                            <input type="number" name="highest_stock">
                            個以下
                        </div>
                        <div class="form-group">
                            <input type="radio" name="status" value="1">公開
                            <input type="radio" name="status" value="0">非公開
                            <input type="radio" name="status" value="2" checked="checked">両方
                        </div>
                        <div class="form-group">
                            <select name="sort_method">
                                <option value="created_at">追加日</option>
                                <option value="updated_at">更新日</option>
                                <option value="price">価格</option>
                                <option value="stock">在庫</option>
                            </select>
                            <select name="order">
                                <option value="asc">昇順</option>
                                <option value="desc">降順</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="material-icons">cancel</i>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="material-icons">check</i>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                <span>{{ $item->stock }} 個</span>
                <button type="button" class="btn btn-success" data-toggle="modal"
                    data-target="#stock-{{ $item->id }}-modal">
                    <i class="material-icons">edit</i>
                </button>
                <div class="modal fade" id="stock-{{ $item->id }}-modal" tabindex="-1" role="dialog"
                    aria-labelledby="stock-{{ $item->id }}-modal-title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="stock-{{ $item->id }}-modal-title">在庫数変更</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('tool.update', ['item_id' => $item->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <input type="number" name="new_quantity" value="{{ $item->stock }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="material-icons">cancel</i>
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="material-icons">check</i>
                                </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <span>{{ $item->status==true ? '公開' : '非公開' }}</span>
                <form action="{{ route('tool.switch', ['item_id' => $item->id]) }}" style="display: inline;" method="post">
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

<script>
    $('#file-button').click(function(){
        $('#file').click();
        return false;
    });
</script>
@endsection
