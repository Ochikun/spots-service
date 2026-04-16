@extends('layouts.default')

@section('content')

<section>
    <div class="mb-6 py-4 bg-white rounded">
        <div class="flex px-6 pb-4 border-b">
            <h2 class="text-xl font-bold">日記一覧</h2>
            <div class="ml-auto">
                <a href="" class="py-2 px-3 text-xs text-white font-semibold bg-indigo-500 rounded-md">
                    新規投稿
                </a>
            </div>
        </div>

        <div class="pt-4 px-4 overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="text-xs text-gray-500 text-left">
                        <th class="font-medium px-4 py-2">タイトル</th>
                        <th class="font-medium px-4 py-2">カテゴリ</th>
                        <th class="font-medium px-4 py-2">更新日時</th>
                        <th class="font-medium px-4 py-2">操作</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- @foreach($spots as $spot) --}}
                    <tr class="text-sm hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <img class="w-12 h-12 mr-4 object-cover rounded-md"
                                     src="" alt="">
                                <p class="font-medium">
                                    <a href="" class="hover:underline">
                                       タイトル
                                    </a>
                                </p>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $spot->category->name ?? '未分類' }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{-- {{ $spot->updated_at->format('Y-m-d') }} --}}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex space-x-2">
                                <a href="{{-- route('spots.edit', $spot) --}}" class="text-indigo-600 hover:text-indigo-400">
                                    <svg class="w-5 h-5" ...></svg>
                                </a>

                                <form method="POST" action="{{-- route('spots.destroy', $spot) --}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-300">
                                        <svg class="w-5 h-5" ...></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>

            </table>
        </div>
    </div>

    {{-- ページャー --}}
    {{-- {{ $spots->onEachSide(1)->links() }} --}}

</section>
@endsection
