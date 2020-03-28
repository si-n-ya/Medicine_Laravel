<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\State;

class StatesController extends Controller
{
    //
    public function ajax(Request $request)
    {
        $item = State::join('items', 'states.item_id', '=', 'items.id')->where('states.use_date', $request->date)->where('states.item_id', $request->id)->select('states.*')->first();
        // var_dump($item);

        // 薬を服用時（チェックをつける）
        if ($request->mode == 'add_check') {
            // $itemが空の時（stateテーブルが空の時）
            if (empty($item)) {
                // stateテーブルにINSERT
                $state = new State;
                $state->item_id = $request->id;
                $state->week_state = $request->week_id;
                $state->time_state = $request->time_id;
                $state->use_date = $request->date;
                $state->save();

                // itemテーブルの在庫数の変更
                $item = Item::find($request->id);
                $item->stock_num = $item->stock_num - $request->use_num;
                $item->save();

            // $itemを取り出せた時（stateテーブルに値があるとき）
            } else {
                // 新しいtime_state の値を用意
                $new_time = $item->time_state . ',' . $request->time_id;

                // 在庫数とtime_stateの更新
                $item->item->stock_num = $item->item->stock_num - $request->use_num;
                $item->time_state = $new_time;
                $item->save();
            }

            // チェックを外した時
        } elseif ($request->mode == 'remove_check') {
            // time_stateに ',' が含まれている時（数字が2つ以上ある時）
            if (strpos($item->time_state, ',') !== false) {
                $get_times = explode(',', $item->time_state);

                $new_time = '';
                $get_time = '';
                $count = 0;
                foreach ($get_times as $get_time) {
                    // explodeしたtime_stateの値とAjaxのtime_idが一致した時、continue をして、次の値でループする
                    // チェックした値をcontinueで飛ばすことで、削除できる（$new_time に代入されない）
                    if ($get_time == $request->time_id) {
                        continue;
                    }
                    
                    // $countが0の時、explodeしたtime_stateの値を.=でつなげる（データベースに入る最初の値になるため、','が先に挿入されるのを防ぐため）
                    if ($count == 0) {
                        $new_time .= $get_time;
                    } else {
                        // $countが0以外の時、','とexplodeしたtime_stateの値でつなげる（2回目以降のループの時であり、$new_time には既に値が入っているため、','を先に入れて値を入れる）
                        $new_time .= ',' . $get_time;
                    }
                    $count++;
                }

                // 在庫数
                $item->item->stock_num = $item->item->stock_num + $request->use_num;
                $item->time_state = $new_time;
                $item->save();

            // time_stateの文字に','が含まれていない時（数字が1つの時）
            } else {
                // stateテーブルのレコードを削除
                State::where('item_id', $request->id)->where('use_date', $request->date)->first()->delete();

                // itemテーブルの在庫数の変更
                $item = Item::find($request->id);
                $item->stock_num = $item->stock_num + $request->use_num;
                $item->save();
            }
        }
        return response()->json([]);
    }

    public function delete(Request $request)
    {
        if (isset($request->history_check)) {
            foreach ($request->history_check as $id) {
                State::find($id)->delete();
            }
            return redirect()->action('ItemsController@history');
        } elseif (isset($request->search_check)) {
            foreach ($request->search_check as $id) {
                State::find($id)->delete();
            }
            /*
            $request->session()->put('session_name', $request->hidden_name);
            $request->session()->put('session_date', $request->hidden_date);
            */
            return redirect()->action('ItemsController@search');
        } else {
            return redirect()->action('ItemsController@history');
        }
    }
}