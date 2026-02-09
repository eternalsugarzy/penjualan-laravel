<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Login POS System</title>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-200">
        
        <div class="flex justify-center mb-4">
            <img src="{{ asset('img/logo.png') }}" 
                 alt="Logo Aplikasi" 
                 class="h-28 w-auto object-contain drop-shadow-md hover:scale-105 transition-transform duration-300">
        </div>

        <div class="mb-8 text-center">
            <h1 class="text-blue-600 font-extrabold text-xl leading-tight tracking-tight">
                PEMASARAN PRODUK<br>DAUR ULANG
            </h1>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-400"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" value="{{ old('username') }}" 
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all placeholder-slate-400 text-slate-700" 
                        placeholder="Masukkan username..." required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-400"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" 
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all placeholder-slate-400 text-slate-700" 
                        placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-500/30 transition duration-200 transform hover:scale-[1.02] flex items-center justify-center gap-2">
                <span>MASUK SEKARANG</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-xs text-slate-400">© {{ date('Y') }} Sistem Manajemen Daur Ulang</p>
        </div>
    </div>

    @if(session()->has('loginError'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: "{{ session('loginError') }}",
            confirmButtonColor: '#2563eb',
            customClass: {
                popup: 'rounded-xl'
            }
        });
    </script>
    @endif

</body>
</html>