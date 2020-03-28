<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistRequest;

use App\Item;
use App\State;

// use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    //
    public function index()
    {
        $day = new \Datetime('today');
        $day = $day->format('Y-m-d');
        return view('index', ['day' => $day]);
    }

    public function add()
    {
        return view('add');
    }
    public function create(RegistRequest $request)
    {
        /*
        $save_week = implode(',', $request->week);
        $save_time = implode(',', $request->time);
        $param = [
            'name' => $request->name,
            'week' => $save_week,
            'time' => $save_time,
            'get_date' => $request->get_date,
            'use_num' => $request->use_num,
            'unit' => $request->unit,
            'stock_num' => $request->stock_num
        ];
        DB::table('items')->insert($param);
        return redirect('/');
        */

        $save_week = implode(',', $request->week);
        $save_time = implode(',', $request->time);
        $item = new Item;
        $item->name = $request->name;
        $item->week = $save_week;
        $item->time = $save_time;
        $item->get_date = $request->get_date;
        $item->use_num = $request->use_num;
        $item->unit = $request->unit;
        $item->stock_num = $request->stock_num;
        unset($request->_token);
        $item->save();
        return redirect('/');
    }

    public function check(Request $request)
    {
        $items = Item::all();
        $request_date = new \DateTime($request->id);

        // stateレコードがあるかのチェック
        if (State::where('use_date', $request_date->format('Y-m-d'))->exists()) {
            $states = State::where('use_date', $request_date->format('Y-m-d'))->get();
        } else {
            $states = '';
        }

        return view('check', [
            'request' => $request->id,
            'items' => $items,
            'states' => $states,
            'request_date' => $request_date,
            ]);
    }

    public function list()
    {
        $items = Item::paginate(5);
        return view('list', ['items' => $items]);
    }

    public function edit(Request $request, $id)
    {
        $item = Item::find($id);
        $get_week = explode(',', $item->week);
        $get_time = explode(',', $item->time);
        return view('edit', [
            'form' => $item,
            'get_week' => $get_week,
            'get_time' => $get_time
            ]);
    }

    public function update(RegistRequest $request, $id)
    {
        $save_week = implode(',', $request->week);
        $save_time = implode(',', $request->time);
        
        $item = Item::find($id);
        $item->name = $request->name;
        $item->week = $save_week;
        $item->time = $save_time;
        $item->get_date = $request->get_date;
        $item->use_num = $request->use_num;
        $item->unit = $request->unit;
        $item->stock_num = $request->stock_num;
        unset($request->_token);
        $item->save();
        return redirect('/');
    }

    public function delete($id)
    {
        Item::findOrFail($id);
        State::where('item_id', $id)->delete();
        Item::find($id)->delete();
        return redirect('/list');
    }

    public function history()
    {
        $items = Item::join('states', 'items.id', '=', 'states.item_id')->orderBy('use_date', 'asc')->select('items.*', 'states.*')->paginate(20);
        return view('history', ['items' => $items]);
    }

    public function search(Request $request)
    {
        /*
        // 検索後の状態で削除後、delete()からリダイレクトされたとき、セッションの値（検索時の名前と日付の値）を代入し、そのセッションの値で検索しviewに渡す。（削除後に検索した状態に戻るため）
        if ($request->session()->exists('session_name') || $request->session()->exists('session_date')) {
            $request->search_name = $request->session()->get('session_name');
            $request->search_date = $request->session()->get('session_date');
            // セッションを全て削除
            $request->session()->flush();
        }
        */
        
        // 名前と日付が両方検索されたときに、両方に一致するレコードを取り出す
        if ($request->search_name != "" && $request->search_date != "") {
            $search_results = Item::join('states', 'items.id', '=', 'states.item_id')->where('name', 'like', '%' . $request->search_name . '%')->where('use_date', 'like', '%'. $request->search_date . '%')->get();

        // 名前だけが検索されたとき
        } elseif ($request->search_name != "") {
            $search_results = Item::join('states', 'items.id', '=', 'states.item_id')->where('name', 'like', '%' . $request->search_name . '%')->get();

        // 日付だけが検索されたとき
        } elseif ($request->search_date != '') {
            $search_results = Item::join('states', 'items.id', '=', 'states.item_id')->where('use_date', 'like', '%' . $request->search_date . '%')->get();

        // 名前と日付が未入力で検索されたとき（全件表示される）
        } else {
            return redirect()->action('ItemsController@history');
        }

        // 検索した結果がなかったとき
        if (count($search_results) < 1) {
            $no_result = $search_results;
            return view('history', ['no_result' => $no_result]);
            
        // 検索された値があったとき
        } else {
            /*
            // 検索された状態で削除後、検索された状態に戻るため（input type="hidden" の value に、検索された内容をセッションとして残す）
            $request->session()->put('search_content_name', $request->search_name);
            $request->session()->put('search_content_date', $request->search_date);
            */
            return view('history', ['search_results' => $search_results]);
        }
    }
}