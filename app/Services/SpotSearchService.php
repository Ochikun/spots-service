<?php

namespace App\Services;

use Illuminate\Http\Request;

class SpotSearchService
{
    public function applyQuery($query, $request)
    {
        $this->applyFilter($request,$query);
        $this->applySort($request,$query);

        return $query;
    }

    private function applyFilter(Request $request, $query)
    {
        //カテゴリ
        if($request->filter_category){
            $query->where('category_id',$request->filter_category);
        }
        //キーワード
        if($request->filter_keyword){
            $keyword = $request->filter_keyword;
            $query->where(function($q) use ($keyword){
                $q->where('title','like',"%{$keyword}%")
                  ->orWhere('body','like',"%{$keyword}%");
            });
        }
        //日付
        if($request->fillter_period){
            $period = $request->fillter_period;

            if($period == '1week'){
                    $query->where('date', '>=', now()->subWeek());
                }elseif($period == '3month'){
                     $query->where('date', '>=', now()->subMonth(3));
                }elseif($period == '1year'){
                    $query->where('date', '>=', now()->subYear());
            }
        }
    }

    private function applySort(Request $request, $query)
    {
        switch($request->sort){
            case 'visited_asc':
                $query->orderBy('date','asc');
                break;
            case 'visited_desc':
                $query->orderBy('date','desc');
                break;
            case 'title_asc':
                $query->orderBy('title','asc');
                break;
            case 'title_desc':
                $query->orderBy('title','desc');
                break;
            default:
                $query->orderBy('date','desc');
        }
    }

}
