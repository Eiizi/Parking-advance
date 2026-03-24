<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Casheer Parkinglot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md border border-gray-100">
        <div class="text-center mb-8">
            <div class="bg-blue-600 text-white w-16 h-16 rounded-2xl flex items-center justify-center font-bold text-3xl mx-auto mb-4 shadow-md">
                PE
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Casheer Parkinglot</h1>
            <p class="text-gray-500 mt-1">Sistem Manajemen Parkir Terpadu</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-6 text-sm border border-red-100 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Email Akses</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Kata Sandi</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
            </div>

            <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md transform hover:-translate-y-0.5">
                Masuk Sistem
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-400">
            <p>Admin: admin@elmer.com | pegawai@elmer.com</p>
            <p>Pass: password123</p>
        </div>
    </div>

</body>
</html>