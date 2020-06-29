@extends('layouts.default')

@section('title', 'あなたの購入履歴')

@section('content')

@if ($user === 'admin')
@section('nav_title', '全ての購入履歴')
@else
@section('nav_title', $user . 'さんの購入履歴')
@endif

@section('nav_content')
    <li>
    <a class="nav_link" href="{{ route('tool') }}">商品管理ページへ</a>
    </li>
@endsection

<table class="table">
    <tr>
        <th>注文番号</th>
        <th>購入日</th>
        <th>合計金額</th>
        <th>詳細</th>
    </tr>

    @forelse ($results as $result)
    <tr>
        <td>{{ $result->id }}</td>
        <td>{{ $result->created_at }}</td>
        <td class="price">{{ $result->sum }}円</td>
        <td>
            <form action="{{ route('detail', ['result_id' => $result->id]) }}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary">
                    <i class="material-icons">article</i>
                </button>
            </form>
        </td>
    </tr>
    @empty
    <p>購入履歴はありません</p>
    @endforelse
</table>
@endsection