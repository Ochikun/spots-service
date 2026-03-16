<?php

namespace App\Http\Controllers;

use App\Services\SpotSearchService;
use App\Models\Spot;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MapController extends Controller
{
    public function index(Request $request, SpotSearchService $searchService){

        $categories =Category::all();

        $query = Auth::user()->spots()->with('category');

        //spots.showからの呼出しの場合は1件の記事をmap.indexに渡して表示
        //初回読込,フィルター適用時は$searchServiceでクエリビルダを発行
        if($request->has('spot_id')){
            $spots = Auth::user()->spots()->where('id', $request->spot_id)->get();
        } else{
            $query = $searchService->applyQuery($query,$request);
            $spots = $query->get();
        }

        return view('map.index',['spots' => $spots, 'categories' => $categories]);
    }
}
