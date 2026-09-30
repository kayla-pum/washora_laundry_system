<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Washora - Sistem Informasi Laundry Modern')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS CDN Fallback + Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            300: '#7cc8fb',
                            400: '#36abf7',
                            500: '#0c8fe9',
                            600: '#0270c7',
                            700: '#0359a1',
                            800: '#074c84',
                            900: '#0c406e',
                            950: '#082949',
                        },
                        secondary: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
        .gradient-brand {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
        }
        .gradient-dark {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 flex flex-col antialiased selection:bg-brand-500 selection:text-white">
    
    <!-- Flash Messages Toast -->
    @if(session('success') || session('error') || session('info') || session('warning'))
        <div id="flash-toast" class="fixed top-5 right-5 z-50 max-w-md w-full transition-all transform duration-300 translate-y-0 opacity-100">
            @if(session('success'))
                <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl shadow-xl shadow-emerald-950/5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-emerald-500/30">
                        <i class="fa-solid fa-check text-lg"></i>
                    </div>
                    <div class="flex-1 text-sm font-medium">
                        <p class="font-bold text-emerald-950">Berhasil!</p>
                        <p class="text-emerald-800">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('flash-toast').remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl shadow-xl shadow-rose-950/5">
                    <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-rose-500/30">
                        <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                    </div>
                    <div class="flex-1 text-sm font-medium">
                        <p class="font-bold text-rose-950">Terjadi Kesalahan</p>
                        <p class="text-rose-800">{{ session('error') }}</p>
                    </div>
                    <button onclick="document.getElementById('flash-toast').remove()" class="text-rose-500 hover:text-rose-700 p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 text-blue-900 rounded-2xl shadow-xl shadow-blue-950/5">
                    <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-blue-500/30">
                        <i class="fa-solid fa-circle-info text-lg"></i>
                    </div>
                    <div class="flex-1 text-sm font-medium">
                        <p class="font-bold text-blue-950">Informasi</p>
                        <p class="text-blue-800">{{ session('info') }}</p>
                    </div>
                    <button onclick="document.getElementById('flash-toast').remove()" class="text-blue-500 hover:text-blue-700 p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('warning'))
                <div class="flex items-center gap-3 p-4 bg-amber-50 border border-amber-200 text-amber-900 rounded-2xl shadow-xl shadow-amber-950/5">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-amber-500/30">
                        <i class="fa-solid fa-bell text-lg"></i>
                    </div>
                    <div class="flex-1 text-sm font-medium">
                        <p class="font-bold text-amber-950">Perhatian</p>
                        <p class="text-amber-800">{{ session('warning') }}</p>
                    </div>
                    <button onclick="document.getElementById('flash-toast').remove()" class="text-amber-500 hover:text-amber-700 p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('flash-toast');
                if (toast) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-10px)';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        </script>
    @endif

    @yield('content')

    @stack('scripts')
</body>
</html>
