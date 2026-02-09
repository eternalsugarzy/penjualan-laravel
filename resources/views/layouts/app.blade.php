<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>@yield('title') | POS PRO</title>
</head>
<body class="bg-slate-50 flex">

    @include('layouts.sidebar')

    <div class="flex-1 min-h-screen">
        <header class="bg-white border-b p-4 px-8 flex justify-between items-center sticky top-0 z-10">
            <h2 class="font-bold text-slate-700">@yield('header')</h2>
            <div class="flex items-center space-x-3">
                <span class="text-sm font-bold">{{ Auth::user()->nama }}</span>
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama }}&background=0D8ABC&color=fff" class="w-8 h-8 rounded-full">
            </div>
        </header>

        <main class="p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>