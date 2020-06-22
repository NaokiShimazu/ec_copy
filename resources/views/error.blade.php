@extends('layouts.default')

@section('title', '購入を中断しました')

@section('content')
<h1>購入を中断しました</h1>
@forelse ($err_msgs as $err_msg)
<p>在庫が足りません: {{ $err_msg }}</p>
@empty
<p>エラーはありません</p>
@endforelse
@endsection