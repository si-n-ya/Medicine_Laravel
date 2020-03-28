@php
$day = new \Datetime('today');
$day = $day->format('Y-m-d');
@endphp
<header class="header">
    <div class="header_container header_flex">
        <div class="header_inner container">
            <p>
                <a href="/" class="top_title">お薬管理アプリ</a>
            </p>
            <button class="btn_hamburger">
                <span class="hamburger_logo"></span>
            </button>
        </div> <!-- .header_inner -->
        <nav class="global_nav">
            <ul>
                <li class="nav_list">
                    <a href="{{ action('ItemsController@add') }}" class="nav_link">お薬登録</a>
                </li>
                <li class="nav_list">
                    <a href="check?id={{ $day }}" class="nav_link">お薬服用チェック</a>
                </li>
                <li class="nav_list">
                    <a href="{{ action('ItemsController@list') }}" class="nav_link">登録リスト</a>
                </li>
                <li class="nav_list">
                    <a href="{{ action('ItemsController@history') }}" class="nav_link">お薬服用履歴</a>
                </li>
            </ul>
        </nav>
    </div> <!-- .header_container -->
</header>