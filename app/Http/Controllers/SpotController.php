<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\SpotSearchService;
use App\Http\Requests\StoreSpotRequest;
use App\Http\Requests\UpdateSpotRequest;
use App\Models\Spot;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
class SpotController extends Controller
{
    //日記一覧表示
    public function index(Request $request, SpotSearchService $searchService)
    {
        $categories = Category::all();

        $query = Auth::user()->spots();
        $query = $searchService->applyQuery($query,$request);

        $spots = $query->paginate(10);

        return view('spots.index',['spots' => $spots, 'categories' => $categories]);
    }

    //日記保存処理
    public function store(StoreSpotRequest $request)
    {
        $validated = $request->validated();
        //s3への保存とファイルパスを返す
            if($request->hasFile('image')){
                $imgManager = new ImageManager(new Driver());

                $imgFile = $request->file('image');
                $image = $imgManager->read($imgFile);

                $encoded = $image->toJpeg(70);
                $fileName = 'photos/' . Str::random(40) . '.jpg';

                Storage::disk('s3')->put($fileName,(string) $encoded);
                $validated['image'] = $fileName;
            }

            Auth::user()->spots()->create($validated);

            return to_route('map.index')->with('success','日記を追加しました');
    }

    //日記の詳細表示
    public function show($id)
    {

        $spot = Auth::user()->spots()->findOrFail($id);
        //spots.showの前後リンクのデータを取得する
        //SELECT * FROM spots　
        //WHERE user_id = auth_id
        //AND (date < $spot->date
        //  OR (date = $spot->date and id < spot->id ))
        //ORDERBY date DESC, id DESC LIMIT 1;
        $prevSpot = Auth::user()->spots()
                        ->where(function ($query) use ($spot) {
                            $query->where('date','<',$spot->date)
                                ->orwhere(function ($q) use ($spot){
                                    $q->where('date','=',$spot->date)
                                      ->where('id','<',$spot->id);
                                });
                        })
                        ->orderBy('date','desc')
                        ->orderBy('id','desc')
                        ->first();
        //SELECT * FROM spots　
        //WHERE user_id = auth_id
        //AND (date > $spot->date
        //  OR (date = $spot->date and id > spot->id ))
        //ORDERBY date ASC, id ASC LIMIT 1;
        $nextSpot = Auth::user()->spots()
                            ->where(function ($query) use ($spot) {
                                $query->where('date','>',$spot->date)
                                    ->orwhere(function ($q) use ($spot){
                                        $q->where('date','=',$spot->date)
                                        ->where('id','>',$spot->id);
                                    });
                            })
                            ->orderBy('date','asc')
                            ->orderBy('id','asc')
                            ->first();

        return view('spots.show',[
                                    'spot' => $spot,
                                    'prevSpot' => $prevSpot,
                                    'nextSpot' => $nextSpot
                                 ]);
    }

    //日記編集用ページ表示
    public function edit($id)
    {
       $categories = Category::all();
       $spot = Auth::user()->spots()->findOrFail($id);
       return view('spots.edit',['spot' => $spot, 'categories' => $categories]);
    }

    //日記編集処理
    public function update(UpdateSpotRequest $request, $id)
    {
        $spot = Auth::user()->spots()->findOrFail($id);
        $updateData = $request->validated();

            if($request->hasFile('image')){
                if(!empty($spot->image)){
                    Storage::disk('s3')->delete($spot->image);
                }
                $imgManager = new ImageManager(new Driver());

                $imgFile = $request->file('image');
                $image = $imgManager->read($imgFile);

                $encoded = $image->toJpeg(70);
                $fileName = 'photos/' . Str::random(40) . '.jpg';

                Storage::disk('s3')->put($fileName,(string) $encoded);
                $updateData['image'] = $fileName;
            }
            $spot->update($updateData);

            return to_route('spots.show',['spot' => $spot])->with('success','日記を更新しました');

    }

    //日記削除処理
    public function destroy($id)
    {
        $spot = Auth::user()->spots()->findOrFail($id);

        if(!empty($spot->image)){
            Storage::disk('s3')->delete($spot->image);
        }
        $spot->delete();

        return to_route('spots.index')->with('success','日記を削除しました');
    }
}
