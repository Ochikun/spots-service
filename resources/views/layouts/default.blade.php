
<html lang="ja">
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>@yield('title', '旅日記')</title>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>
    </head>

    <body class="antialiased bg-body text-body font-body">
        <!--共通ヘッダー-->
        <header class="bg-gray-300 w-full">
            <div class="px-6 md:px-12 w-full">
                <nav class="flex items-center justify-between py-4 md:py-6">

                    <a class="text-2xl md:text-3xl font-semibold leading-none" href="{{route('map.index')}}">旅日記</a>

                    <ul class="hidden lg:flex ml-12 mr-auto space-x-12">
                        <li><a class="text-md text-gray-500 hover:text-blue-600" href="{{route('map.index')}}">地図</a></li>
                        <li><a class="text-md text-gray-500 hover:text-blue-600" href="{{route('spots.index')}}">日記一覧</a></li>
                    </ul>

                    <div class="flex items-center space-x-2 md:space-x-4">
                        <div class="relative inline-block text-left" id="userMenuContainer">
                            <!--プロフィール欄-->
                            <button type="button" id="userMenuBtn" class="flex items-center pl-2 md:pl-4 border-l border-gray-400 focus:outline-none cursor-pointer">
                                <span class="text-sm text-gray-700 font-medium truncate max-w-[70px] md:max-w-[150px] inline-block">
                                    {{\Auth::user()->name}}
                                </span>
                                <img class="ml-2 md:ml-3 w-8 h-8 md:w-10 md:h-10 rounded-full object-cover border border-white shadow-sm"
                                     src="{{\Auth::user()->S3Url ?? asset('storage/photos/noprofile.jpg')}}">

                                <svg class="ml-1 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!--プロフィール欄-->

                            <!--ドロップダウンメニュー-->
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white/90 backdrop-blur-md border border-gray-200 rounded shadow-lg z-[9999] overflow-hidden">
                                <div class="py-1">
                                    <div class="lg:hidden border-b border-gray-200/50 mb-1">
                                        <a href="{{route('map.index')}}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-500 hover:text-white">地図</a>
                                        <a href="{{route('spots.index')}}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-500 hover:text-white">日記一覧</a>
                                    </div>

                                    <a href="{{route('auth.profile.edit')}}" class="block px-4 py-3 md:py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white transition-colors duration-200">プロフィール編集</a>

                                    <a href="{{route('auth.password.edit')}}" class="block px-4 py-3 md:py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white transition-colors duration-200">パスワード変更</a>

                                    <div class="border-t border-gray-200/50"></div>

                                    <form method="POST" action="{{ route('auth.logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-3 md:py-2 text-sm text-red-600 hover:bg-red-500 hover:text-white transition-colors duration-200 cursor-pointer">
                                            ログアウト
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <!--ドロップダウンメニュー-->
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!--共通ヘッダー-->

        <!--ページ毎の内容-->
        <main>
            @yield('content')
        </main>
        <!--ページ毎の内容-->

        <!--共通フッター-->
<footer class="bg-black text-white">
    <div class="px-4 container mx-auto p-10 flex flex-col md:flex-row justify-between items-center md:items-start">
        <div class="mb-6 md:mb-0">
            <h2 class="text-xl font-semibold">旅日記</h2>
            <p class="text-gray-400 text-sm mt-2">&copy; 2026 旅日記</p>
        </div>

        <div class="flex space-x-12">
            <ul>
                <li class="font-bold mb-2">サービス</li>
                <li><a href="{{route('map.index')}}" class="text-gray-400 hover:text-white text-sm">地図</a></li>
                <li><a href="{{route('spots.index')}}" class="text-gray-400 hover:text-white text-sm">日記一覧</a></li>
            </ul>
            <ul>
                <li class="font-bold mb-2">その他</li>
                <li><a href="/contact" class="text-gray-400 hover:text-white text-sm">お問い合わせ</a></li>
                <li><a href="https://github.com/Ochikun" class="text-gray-400 hover:text-white text-sm">GitHub</a></li>
            </ul>
        </div>
    </div>
</footer>
        <!--共通フッター-->
    </body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('userMenuBtn');
        const menu = document.getElementById('userDropdown');

        if (btn && menu) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', function() {
                menu.classList.add('hidden');
            });
        }
    });
</script>
