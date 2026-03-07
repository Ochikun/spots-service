@extends('layouts.default')

@section('content')
    @if(session('success'))
        <p class="text-green-600 bg-green-50 px-4 py-2 rounded border border-green-200">{{ session('success') }}</p>
    @endif
<div class="min-h-screen bg-gray-50 pb-20">
    <div class="max-w-xl mx-auto bg-white min-h-screen shadow-lg border-x border-gray-100 relative">

        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md flex items-center justify-between px-4 py-3 border-b border-gray-50">
            <!--戻る-->
            <a href="{{route('spots.index')}}" class="text-gray-600 hover:text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <!--戻る-->

            <!--編集 削除-->
            <div class="flex items-center gap-4">
                <a href="{{route('spots.edit', $spot->id)}}" class="text-gray-400 hover:text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </a>
                <form action="{{route('spots.destroy', $spot->id)}}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button class="text-gray-400 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
            <!--編集 削除-->
        </div>

        <!--画像表示 地図リンク-->
        <div class="w-full aspect-[4/5] bg-gray-200 relative">
            @if($spot->image)
                <img src="{{$spot->S3Url}}" class="w-full h-full object-cover">
            @else
                <div class="flex items-center justify-center h-full text-gray-400">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            <a href="{{route('map.index',['spot_id' => $spot->id])}}" class="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-4 py-2 rounded-full shadow-lg flex items-center gap-2 text-sm font-bold text-indigo-600 hover:bg-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                地図で確認
            </a>
        </div>
        <!--画像表示 地図リンク-->

        <div class="p-6">
            <!--日記本文-->
            <div class="flex items-center justify-between mb-4">
                <span class="px-3 py-1 rounded-full text-xs font-bold" style="background-color: {{($spot->category->color ?? '#f3f4f6')}}20; color: {{$spot->category->color ?? '#666'}}">
                    {{$spot->category->name}}
                </span>
                <span class="text-xs text-gray-400 font-medium">訪問日: {{$spot->date}}</span>
            </div>

            <h1 class="text-2xl font-black text-gray-900 mb-4 leading-tight text-center">
                {{ $spot->title ?? '無題' }}
            </h1>

            <div class="text-gray-700 leading-relaxed text-sm mb-10 whitespace-pre-wrap">
                {{ $spot->body }}
            </div>

            <div class="pt-4 mb-5 space-y-1">
                <p class="text-[10px] text-gray-300 uppercase tracking-widest">投稿日: {{$spot->created_at->format('Y-m-d')}}</p>
                <p class="text-[10px] text-gray-300 uppercase tracking-widest">更新日: {{$spot->updated_at->format('Y-m-d')}}</p>
            </div>
            <!--日記本文-->

            <!--前後記事リンク-->
            <div class="border-t border-gray-100 py-6 flex items-center justify-between">
                @if($prevSpot)
                    <a href="{{route('spots.show',$prevSpot) }}" class="flex items-center gap-2 group">
                        <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 group-hover:bg-indigo-50 text-gray-400 group-hover:text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-300 font-bold">PREV</span>
                            <span class="text-xs font-bold text-gray-400 group-hover:text-indigo-600">前の日記</span>
                        </div>
                    </a>
                @else
                    <div class="w-10"></div>
                @endif

                <div class="h-8 w-[1px] bg-gray-100"></div>

                @if($nextSpot)
                    <a href="{{ route('spots.show',$nextSpot) }}" class="flex items-center gap-2 group text-right">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-300 font-bold">NEXT</span>
                            <span class="text-xs font-bold text-gray-400 group-hover:text-indigo-600 ">次の日記</span>
                        </div>
                        <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 group-hover:bg-indigo-50 text-gray-400 group-hover:text-indigo-600 ">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </a>
                @else
                    <div class="w-10"></div>
                @endif
            </div>
            <!--前後記事リンク-->
        </div>
    </div>
</div>
@endsection
