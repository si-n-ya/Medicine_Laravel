@extends('layouts.default')

@section('title', 'メインメニュー')

@section('content')

<div class="top_container">
    <main class="container">
        <h1 class="btn_center main_menu_title">メインメニュー</h1>
        <ul class="list_container">
            <li class="btn_center">
                <a href="{{ action('ItemsController@add') }}" class="btn btn_shape">お薬登録</a>
            </li>
            <li class="btn_center">
                <a href="check?id={{ $day }}" class="btn btn_shape">お薬服用チェック</a>
            </li>
            <li class="btn_center">
                <a href="{{ action('ItemsController@list') }}" class="btn btn_shape">登録リスト</a>
            </li>
            <li class="btn_center">
                <a href="{{ action('ItemsController@history') }}" class="btn btn_shape">お薬服用履歴</a>
            </li>
        </ul>
    </main>
    <div>
        @endsection