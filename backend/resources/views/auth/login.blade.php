<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(-12px) translateX(6px); }
        }
        @keyframes floatBg {
            0%, 100% { transform: translateY(0px) translateX(0px) scale(1); }
            50% { transform: translateY(-25px) translateX(15px) scale(1.05); }
        }
        .float-slow { animation: float 7s ease-in-out infinite; }
        .float-slower { animation: float 9s ease-in-out infinite; animation-delay: 1.5s; }
        .float-bg-1 { animation: floatBg 10s ease-in-out infinite; }
        .float-bg-2 { animation: floatBg 13s ease-in-out infinite; animation-delay: 2s; }
        .float-bg-3 { animation: floatBg 11s ease-in-out infinite; animation-delay: 4s; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden" style="background-color: #050505;">

    <!-- Garis bendera Jerman - JELAS & TEGAS -->
    <div class="absolute inset-0 flex flex-col">
        <div class="flex-1" style="background: #000000;"></div>
        <div class="flex-1" style="background: #DD0000;"></div>
        <div class="flex-1" style="background: #FFCE00;"></div>
    </div>

    <!-- Overlay gelap CUMA di tengah, biar bendera di pinggir tetap keliatan jelas -->
    <div class="absolute inset-0" style="background: radial-gradient(ellipse 900px 600px at center, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.35) 60%, rgba(0,0,0,0) 100%);"></div>

    <!-- Bola-bola blur mengambang -->
    <div class="absolute top-10 left-10 w-72 h-72 rounded-full blur-3xl float-bg-1" style="background: #ffffff; opacity: 0.1;"></div>
    <div class="absolute bottom-10 right-16 w-96 h-96 rounded-full blur-3xl float-bg-2" style="background: #ffffff; opacity: 0.08;"></div>
    <div class="absolute top-1/2 right-1/4 w-56 h-56 rounded-full blur-3xl float-bg-3" style="background: #ffffff; opacity: 0.05;"></div>

    <!-- Strip tebal bendera di ujung atas & bawah layar sebagai frame -->
    <div class="absolute top-0 left-0 w-full flex h-3 z-20">
        <div class="flex-1" style="background: #000000;"></div>
        <div class="flex-1" style="background: #DD0000;"></div>
        <div class="flex-1" style="background: #FFCE00;"></div>
    </div>
    <div class="absolute bottom-0 left-0 w-full flex h-3 z-20">
        <div class="flex-1" style="background: #000000;"></div>
        <div class="flex-1" style="background: #DD0000;"></div>
        <div class="flex-1" style="background: #FFCE00;"></div>
    </div>

    <!-- CARD LOGIN -->
    <div class="flex w-full max-w-4xl mx-4 rounded-3xl overflow-hidden shadow-2xl relative z-10" style="box-shadow: 0 25px 60px -10px rgba(221,0,0,0.4), 0 25px 60px -10px rgba(0,0,0,0.7);">

        <!-- PANEL KIRI: Welcome + Dekorasi -->
        <div class="hidden md:flex flex-col justify-between w-1/2 p-10 relative overflow-hidden"
             style="background: linear-gradient(160deg, #000000 0%, #8b0000 55%, #DD0000 100%);">

            <div class="absolute -top-10 -left-10 w-40 h-40 rounded-full float-slow"
                 style="background: radial-gradient(circle at 30% 30%, #FFCE00, #b38f00); opacity: 0.85;"></div>
            <div class="absolute bottom-16 -left-6 w-28 h-28 rounded-full float-slower"
                 style="background: radial-gradient(circle at 30% 30%, #ffffff, #d1d1d1); opacity: 0.15;"></div>
            <div class="absolute bottom-0 left-20 w-56 h-56 rounded-full float-slow"
                 style="background: radial-gradient(circle at 35% 35%, #FFCE00, #7a5f00); opacity: 0.9; transform: translateY(30%);"></div>
            <div class="absolute top-1/3 -right-10 w-24 h-24 rounded-full float-slower"
                 style="background: #000000; opacity: 0.4;"></div>

            <div class="relative z-10">
                <div class="flex w-20 h-1.5 rounded-full overflow-hidden mb-6">
                    <div class="flex-1" style="background: #000000;"></div>
                    <div class="flex-1" style="background: #DD0000;"></div>
                    <div class="flex-1" style="background: #FFCE00;"></div>
                </div>
                <h1 class="text-4xl font-black text-white tracking-tight mb-2">WILLKOMMEN</h1>
                <p class="text-sm font-semibold tracking-widest" style="color: #FFCE00;">SISTEM PEMINJAMAN ALAT</p>
            </div>

            <div class="relative z-10">
                <p class="text-gray-300 text-sm leading-relaxed max-w-xs">
                    Kelola peminjaman, pengembalian, dan inventaris alat laboratorium dengan mudah, cepat, dan terintegrasi.
                </p>
            </div>
        </div>

        <!-- PANEL KANAN: Form Login -->
        <div class="w-full md:w-1/2 bg-white p-10 flex flex-col justify-center">

            <h2 class="text-3xl font-black text-gray-900 mb-1">Masuk</h2>
            <p class="text-gray-400 text-sm mb-8">Silakan login untuk melanjutkan</p>

            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg text-sm font-medium flex items-center gap-2"
                     style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 rounded-lg text-sm font-medium"
                     style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;">
                    <ul class="list-disc pl-5 mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400
                                   focus:outline-none transition-all duration-300"
                            onfocus="this.style.borderColor='#DD0000'" onblur="this.style.borderColor='#e5e7eb'">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500">Password</label>
                    </div>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password" id="passwordInput" required
                            class="w-full pl-10 pr-16 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-800
                                   focus:outline-none transition-all duration-300"
                            onfocus="this.style.borderColor='#DD0000'" onblur="this.style.borderColor='#e5e7eb'">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold" style="color: #DD0000;">
                            <span id="toggleText">SHOW</span>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-2xl hover:scale-[1.02] active:scale-[0.98] tracking-wide"
                    style="background: linear-gradient(135deg, #DD0000 0%, #8b0000 100%); box-shadow: 0 10px 25px -5px rgba(221,0,0,0.4);">
                    MASUK
                </button>
            </form>

            <div class="flex items-center gap-3 mt-8">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400">🇩🇪</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>
            <p class="text-center text-xs text-gray-400 mt-3 font-medium tracking-wide">Deutsche Qualität System</p>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const label = document.getElementById('toggleText');
            if (input.type === 'password') {
                input.type = 'text';
                label.innerText = 'HIDE';
            } else {
                input.type = 'password';
                label.innerText = 'SHOW';
            }
        }
    </script>

</body>
</html>