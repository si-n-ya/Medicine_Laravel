@extends('layouts.default')

@section('title', 'お薬服用履歴')

@section('content')

<div class="container history_container">
    <main class="container">
        <div class="flex_container">
            <h1 class="title_shape conf_title_black">お薬服用履歴</h1>
            <p class="back_box btn_right">
                <a href="/" class="btn back">メニューへ戻る</a>
            </p>
        </div> <!-- .flex_container -->
        <div class="history_form_container">
            <form action="{{ action('ItemsController@search') }}" method="post" class="history_form">
                {{ csrf_field() }}
                <dl>
                    <dt class="history_dt">お薬の名前</dt>
                    <dd class="history_dd">
                        <input type="text" name="search_name" class="input_text input_history">
                    </dd>
                    <dt class="history_dt">服用した日付</dt>
                    <dd class="history_dd">
                        <input type="date" name="search_date" class="input_text input_history">
                    </dd>
                </dl>
                <p class="history_submit_box btn_center">
                    <input type="submit" name="submit" value="検索" class="submit history_submit">
                </p>
            </form>
        </div>
        <!-- 検索結果が0の時 -->

        @if (isset($no_result))
        <p class="error history_error">*検索結果はありません</p>
        <!-- 検索結果がある時 -->
        @elseif (isset($search_results))
        <form action="{{ action('StatesController@delete') }}" method="post" name="delete_form">
            <!-- <input type="hidden" name="hidden_name" value="{{ session()->get('search_content_name') }}">
            <input type="hidden" name="hidden_date" value="{{ session()->get('search_content_date') }}"> -->
            {{ csrf_field() }}
            <table border="1" class="history_table">
                <thead>
                    <tr>
                        <th></th>
                        <th>日付</th>
                        <th>時間</th>
                        <th>名前</th>
                        <th>量</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($search_results as $search_result)
                    @php
                    $times = explode(',', $search_result->time_state);
                    @endphp
                    <tr class="history_tr history_{{ $search_result->id }}">
                        <td class="history_td">
                            <input type="checkbox" class="check history_check" name="search_check[]"
                                value="{{ $search_result->id }}">
                        </td>
                        <td class="history_td">
                            {{ $search_result->use_date }}
                        </td>
                        <td class=" history_td">
                            @foreach ($times as $time)
                            <span>{{ $time }}:00</span>
                            @endforeach
                        </td>
                        <td class="history_td">
                            {{ $search_result->name }}
                        </td>
                        <td class="history_td">
                            {{ $search_result->use_num }}{{ $search_result->unit }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex_container history_flex_box">
                <div class="all_check_box history_all_check_box">
                    <input type="checkbox" id="all_check" class="all_check check">
                    <label for="all_check">全ての履歴</label>
                </div> <!-- .all_check_box -->
                <p colspan="5" class="btn_box btn_center history_delete_box">
                    <button class="btn history_delete delete_btn">削除</button>
                </p>
            </div> <!-- .history_flex_box -->
        </form>
        <!-- 検索をしていない時 -->
        @elseif (!isset($search_results))
        <form action="{{ action('StatesController@delete') }}" method="post" name="delete_form">
            {{ csrf_field() }}

            <table border="1" class="history_table">
                <thead>
                    <tr>
                        <th></th>

                        <th>日付</th>
                        <th>時間</th>
                        <th>名前</th>
                        <th>量</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    @php
                    $times = explode(',', $item->time_state);
                    @endphp
                    <tr class="history_tr history_{{ $item->id }}">
                        <td class="history_td">
                            <input type="checkbox" class="check history_check" name="history_check[]"
                                value="{{ $item->id }}">
                        </td>
                        <td class="history_td">
                            {{ $item->use_date }}
                        </td>
                        <td class="history_td">
                            @foreach ($times as $time)
                            <span>{{ $time }}:00</span>
                            @endforeach
                        </td>
                        <td class="history_td">
                            {{ $item->name }}
                        </td>
                        <td class="history_td">
                            {{ $item->use_num }}{{ $item->unit }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex_container history_flex_box">
                <div class="all_check_box history_all_check_box">
                    <input type="checkbox" id="all_check" class="all_check check">
                    <label for="all_check">全ての履歴</label>
                </div> <!-- .all_check_box -->
                <p class="btn_box btn_center history_delete_box">
                    <button type="btn" class="btn history_delete delete_btn">削除</button>
                </p>
            </div> <!-- .history_flex_box -->
        </form>
        @endif
        <div>
            {{ $items->links() }}
        </div>
    </main>
</div> <!-- .history_container -->
<script src="/js/medicine.js"></script>
@endsection