@extends('layouts.default')

@section('title', 'お薬登録')

@section('content')

<main class="container form_container margin_top">
    <div class="flex_container">
        <h1 class="title_shape regist_title_black">お薬登録</h1>
        <p class="back_box btn_right">
            <a href="/" class="btn back">メニューへ戻る</a>
        </p>
    </div> <!-- .flex_container -->
    <form action="/add" method="post" class="form margin_top">
        {{ csrf_field() }}
        <!-- 薬の名前 -->
        <div class="d_container flexiblebox">
            <dt class="dt regist_dt_bg"><label for="name">薬の名前</label>
            </dt>
            <dd class="dd">
                <input type="text" name="name" id="name" class="input_text" value="{{ old('name') }}">
                @if ($errors->has('name'))
                <p class="error">{{ $errors->first('name') }}</p>
                @endif
            </dd>
        </div> <!-- .flexiblebox -->
        <!-- 服用する曜日 -->
        <div class="d_container flexiblebox">
            <dt class="dt regist_dt_bg">服用する曜日</dt>
            <dd class="dd week_dd">
                <!-- 薬の登録 -->
                @php
                $week = ['日', '月', '火', '水', '木', '金', '土'];
                @endphp
                @for ($i = 0; $i < 7; $i++) <div class="check_layout">
                    <input type="checkbox" name="week[]" id="{{ $week[$i] }}" class="regist_week_check" value="{{ $i }}"
                        {{ is_array(old('week')) && in_array($i, old('week')) ? 'checked': '' }}>
                    <label for="{{ $week[$i] }}">{{ $week[$i] }}曜</label>
        </div> <!-- .check_layout -->
        @endfor
        <div class="all_check_box">
            <input type="checkbox" id="all_check" class="all_check">
            <label for="all_check">全ての曜日</label>
        </div> <!-- .all_check_box -->
        @if ($errors->has('week'))
        <p class="error">{{ $errors->first('week') }}</p>
        @endif
        </dd>
        </div> <!-- .flexiblebox -->
        <!-- 服用する時刻 -->
        <div class="d_container flexiblebox">
            <dt class="dt regist_dt_bg">服用する時刻</dt>
            <dd class="dd">
                <!-- 薬の登録 -->
                @for ($i=0; $i < 24; $i++) <div class="check_layout">
                    <input type="checkbox" name="time[]" id="{{ $i }}" value="{{ $i }}"
                        {{ is_array(old('time')) && in_array($i, old('time')) ? 'checked': '' }}>
                    <label for="{{ $i }}">{{ $i }}:00</label>
        </div> <!-- .check_layout -->
        @endfor
        @if ($errors->has('time'))
        <p class="error">{{ $errors->first('time') }}</p>
        @endif
        </dd>
        </div> <!-- .flexiblebox -->
        <!-- 薬を使い始める日付 -->
        <div class="d_container flexiblebox">
            <dt class="dt regist_dt_bg"><label for="get_date">薬を使い始める日付</label>
            </dt>
            <dd class="dd">
                <input type="date" id="get_date" class="input_text" name="get_date" value="{{ old('get_date') }}">
                @if ($errors->has('get_date'))
                <p class="error">{{ $errors->first('get_date') }}</p>
                @endif
            </dd>
        </div> <!-- .flexiblebox -->
        <!-- 一回に服用する量 -->
        <div class="d_container flexiblebox">
            <dt class="dt regist_dt_bg"><label for="use_num">一回に服用する量</label></dt>
            <dd class="dd">
                <!-- 薬の登録 -->
                <input type="text" name="use_num" class="input_text" value="{{ old('use_num') }}">
                <select name="unit" class="select">
                    <option value="錠">錠</option>
                    <option value="g">g</option>
                    <option value="ml">ml</option>
                    <option value="包">包</option>
                </select>
                @if ($errors->has('use_num'))
                <p class="error">{{ $errors->first('use_num') }}</p>
                @endif
            </dd>
        </div> <!-- .flexiblebox -->
        <!-- 在庫数 -->
        <div class="flexiblebox">
            <dt class="dt regist_dt_bg"><label for="stock_num">在庫数</label></dt>
            <dd class="dd">
                <input type="text" name="stock_num" id="stock" class="input_text" placeholder="(例) 60"
                    value="{{ old('stock_num') }}">
                @if ($errors->has('stock_num'))
                <p class="error">{{ $errors->first('stock_num') }}</p>
                @endif
            </dd>
        </div> <!-- .flexiblebox -->
        <!-- 薬の登録 -->
        <p class="btn_center"><input type="submit" class="submit  regist_sub_design regist_submit_color" value="登録">
        </p>
    </form>
</main>

@endsection