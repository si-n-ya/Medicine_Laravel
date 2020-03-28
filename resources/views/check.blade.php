    @extends('layouts.default')

    @section('title', 'お薬服用チェック')

    @section('content')

    <div class="bg_image_check bg_help">
        <div class="bg_mask">
            <main class="container check_container margin_top">
                <div class="flex_container">
                    <h1 class="title_shape title_white">お薬服用チェック</h1>
                    <p class="back_box btn_center">
                        <a href="/" class="btn back">メニューへ戻る</a>
                    </p>
                </div> <!-- .flex_container -->
                <!-- カレンダー -->
                @include('calender')

                @isset($request)
                <ul class="list_all">
                    @foreach ($items as $item)
                    <!-- 在庫数(stock_num)が０より大きい時に表示 -->
                    @if ($item->stock_num > 0)

                    @php
                    $weeks = explode(',', $item->week);
                    $get_date = new DateTime($item->get_date);
                    @endphp

                    <!-- 登録した曜日の数だけループ -->
                    @foreach ($weeks as $week)
                    <!-- GETパラメータのidの日付の曜日(format('w'))が登録している曜日($week_one)と等しい時かつ、idの日付が登録した日付よりも大きい時 -->
                    @if ($request_date->format('w') == $week && $request_date >= $get_date)

                    @php
                    $times = explode(',', $item->time);
                    @endphp

                    <!-- 登録した時間の数だけループ -->
                    @foreach ($times as $time)

                    @php
                    $checked = '';
                    $done = '';


                    if ($states != '') {
                    foreach ($states as $state) {
                    if ($state->item_id == $item->id) {
                    $time_states = explode(',', $state->time_state);
                    foreach ($time_states as $time_state) {
                    if ($time_state == $time) {
                    $checked = 'checked';
                    $done = 'done';
                    }
                    }
                    }
                    }
                    }
                    @endphp

                    <label for="check_{{ $item->id }}_{{ $time }}" class="name_check">
                        <li class="list_one hover {{ $done == 'done' ? 'done': '' }}" data-id="{{ $item->id }}"
                            data-time="{{ $time }}" data-week="{{ $week }}"
                            data-date="{{ $request_date->format('Y-m-d') }}" data-num="{{ $item->use_num }}">
                            <input type="checkbox" class="check" id="check_{{ $item->id }}_{{ $time }}"
                                {{ $checked == 'checked' ? 'checked': '' }}>
                            <span class="list name_list">
                                {{ $item->name }}
                            </span>
                            <span class="list num_list">
                                {{ $item->use_num }}
                                {{ $item->unit }}
                            </span>
                            <span class="list time_list">
                                {{ $time }}:00
                            </span>
                        </li>
                    </label>
                    @endforeach
                    @break
                    @endif
                    @endforeach
                    @endif
                    @endforeach
                </ul>
                @endisset
            </main>
        </div>
    </div>
    @endsection