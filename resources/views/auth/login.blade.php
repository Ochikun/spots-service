<!DOCTYPE html>
<html lang="ja">
    @if(session('success'))
        <p class="text-green-600 mb-4 bg-green-50 px-4 py-2 rounded border border-green-200">{{ session('success') }}</p>
    @endif

    <head>
        <title>旅日記</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="antialiased bg-gray-50 text-gray-900 font-sans">
        <div class="min-h-screen flex items-center justify-center py-12 px-4" style="background-image: url('{{ asset('storage/photos/') }}');">
            <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">

                <h1 class="mb-8 text-2xl font-bold text-center">旅日記</h1>

                <form action="{{route('auth.login')}}" method="POST" class="space-y-4">
                    @csrf

                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <p class="error-message text-red-500 text-sm mt-1">{{$error}}</p>
                        @endforeach
                    @endif

                    <div>
                        <input class="w-full p-4 text-sm bg-gray-50 border border-gray-200 rounded outline-none focus:border-blue-500 transition" type="email" placeholder="メールアドレス" name="email" value="{{old('email')}}">
                    </div>

                    <div>
                        <input class="w-full p-4 text-sm bg-gray-50 border border-gray-200 rounded outline-none focus:border-blue-500 transition" type="password" placeholder="パスワード"  name="password">
                    </div>

                    <div class="flex items-center">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">ログイン状態を保持する</span>
                        </label>
                    </div>

                    <button type="submit"class="block w-full p-4 text-sm text-white font-semibold bg-blue-600 hover:bg-blue-700 rounded transition duration-200">
                        ログイン
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{route('auth.register.show')}}" class="text-xs text-gray-400 hover:text-blue-500 transition">
                        新しいアカウントを作成する
                    </a>
                </div>

            </div>
        </div>

    </body>
</html>
