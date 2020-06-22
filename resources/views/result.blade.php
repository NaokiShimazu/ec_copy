@extends('layouts.default')

@section('title', 'あなたの購入履歴')

@section('content')
<h1>あなたの購入履歴</h1>

<a href="{{ route('tool') }}">管理ページへ</a>

<table>
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
        <td>{{ $result->sum }}円</td>
        <td>
            <form action="{{ route('detail', ['result_id' => $result->id]) }}" method="post">
                {{ csrf_field() }}
                <input type="submit" value="詳細へ">
            </form>
        </td>
    </tr>
    @empty
    <p>購入履歴はありません</p>
    @endforelse
</table>
@endsection