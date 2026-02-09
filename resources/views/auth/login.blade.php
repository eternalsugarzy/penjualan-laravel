<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login POS System</title>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-200">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">POS <span class="text-blue-600">SYSTEM</span></h2>
            <p class="text-slate-500 text-sm mt-1">Silakan masuk ke akun Anda</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all" 
                    placeholder="Masukkan username..." required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all" 
                    placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg transition duration-200 transform hover:scale-[1.02]">
                MASUK SEKARANG
            </button>
        </form>
    </div>

    @if(session()->has('loginError'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: "{{ session('loginError') }}",
            confirmButtonColor: '#2563eb'
        });
    </script>
    @endif

</body>
</html>