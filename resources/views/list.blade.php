    @extends('layouts.default')

    @section('title', '登録リスト')

    @section('content')

    <div class="bg_image_list bg_help">
        <div class="bg_mask">
            <main class="container list_box">
                <div class="flex_container">
                    <h1 class="title_shape title_white">登録リスト</h1>
                    <p class="back_box btn_center">
                        <a href="/" class="btn back">メニューへ戻る</a>
                    </p>
                </div> <!-- .flex_container -->
                <dl>
                    @foreach ($items as $item)
                    <div class="medi_list medi_">
                        <a href="{{ action('ItemsController@edit', $item->id) }}">
                            <dt class="list_dt">
                                {{ $item->name }}
                            </dt>
                            <!-- <div class="listbox_center"> -->
                            <dd class="list_dd">
                                <p>残り数： {{ $item->stock_num }} {{ $item->unit }}</p>
                                <p>1回 {{ $item->use_num }} {{ $item->unit }}</p>
                            </dd>
                        </a>
                        <form action="{{ action('ItemsController@delete', $item->id) }}" method="post"
                            class="delete_box" id="form_{{ $item->id }}">
                            {{ csrf_field() }}
                            <button type="btn" data-id="{{ $item->id }}" class="btn delete_btn list_delete">削除</button>
                        </form>
                        <!-- </div> -->
                    </div>
                    @endforeach
                </dl>
                <div class="pagination_box">
                    {{ $items->links() }}
                </div>
            </main>
        </div>
    </div>
    <script src="/js/medicine.js"></script>
    @endsection