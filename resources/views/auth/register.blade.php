<!DOCTYPE html>
<html lang="ja">

    <head>
        <title>アカウント作成 - 旅日記</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-50 antialiased font-sans text-gray-900">
        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg border border-gray-100">

                <div class="text-center mb-10">
                    <a href="{{route('auth.showLoginForm')}}" class="text-3xl font-extrabold text-blue-600">旅日記</a>
                    <p class="mt-2 text-sm text-gray-500">新しいアカウントを作成して旅に出よう</p>
                </div>

                <form action="{{route('auth.register.store')}}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-1">お名前</label>
                        <input type="text" placeholder="山田 太郎" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200">
                        @error('name')
                            <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold mb-1">メールアドレス</label>
                        <input type="email" placeholder="mail@example.com" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200">
                        @error('email')
                            <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">パスワード</label>
                        <input type="password" placeholder="8文字以上" name="password"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200">
                        @error('password')
                            <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">パスワード（確認）</label>
                        <input type="password" placeholder="もう一度入力してください" name="password_confirmation"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200">
                    </div>

                    <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                        アカウントを作成する
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-600">
                        既にアカウントをお持ちですか？
                        <a href="{{route('auth.showLoginForm')}}" class="font-bold text-blue-600 hover:underline">ログイン</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
