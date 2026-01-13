<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'MediCare PMS') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License */
                @layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif;}}
                /* ... (Assuming the standard Tailwind Reset and Classes are loaded via the previous style block or Vite) ... */
                /* For this demo, I will use standard Tailwind utility classes which work with the setup you provided */
                body { font-family: 'Instrument Sans', sans-serif; }
            </style>
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: { sans: ['Instrument Sans', 'sans-serif'] },
                            colors: {
                                teal: { 50: '#f0fdfa', 100: '#ccfbf1', 600: '#0d9488', 700: '#0f766e', 800: '#115e59', 900: '#134e4a' },
                                slate: { 850: '#1e293b' }
                            }
                        }
                    }
                }
            </script>
        @endif
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased selection:bg-teal-500 selection:text-white">

        <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <div class="bg-teal-600 text-white p-1.5 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-slate-900">MediCare<span class="text-teal-600">Plus</span></span>
                    </div>

                    <div class="hidden md:flex items-center space-x-6">
                        @if (Route::has('login'))
                            @auth
                                <span class="text-sm text-slate-500">Welcome, <strong>{{ Auth::user()->name }}</strong></span>
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-slate-900 text-white text-sm font-medium rounded-full hover:bg-slate-800 transition shadow-lg shadow-slate-200">
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-teal-600 transition">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-teal-600 text-white text-sm font-medium rounded-full hover:bg-teal-700 transition shadow-lg shadow-teal-100">
                                        New Patient? Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-teal-50 rounded-full blur-3xl opacity-50 -z-10"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] bg-blue-50 rounded-full blur-3xl opacity-50 -z-10"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-100 text-teal-700 text-xs font-semibold mb-6 animate-fade-in-up">
                    <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                    Live Queue System Active
                </div>
                
                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 tracking-tight mb-6 leading-tight">
                    Healthcare Management <br class="hidden md:block" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-emerald-600">Reimagined for You.</span>
                </h1>
                
                <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-500 mb-10">
                    Experience seamless hospital care. Book appointments instantly, track live queues, and access your medical history securely from anywhere.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-slate-900 text-white font-semibold rounded-2xl hover:bg-slate-800 transition shadow-xl shadow-slate-200 flex items-center justify-center gap-2">
                            Enter Portal
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('patient.book') }}" class="px-8 py-4 bg-teal-600 text-white font-semibold rounded-2xl hover:bg-teal-700 transition shadow-xl shadow-teal-200 flex items-center justify-center gap-2">
                            Book Appointment
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-slate-700 border border-slate-200 font-semibold rounded-2xl hover:bg-slate-50 transition flex items-center justify-center gap-2">
                            Doctor Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="py-16 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="group p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-slate-200/50 border border-slate-100 transition-all duration-300">
                        <div class="w-12 h-12 bg-teal-100 text-teal-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Instant Scheduling</h3>
                        <p class="text-slate-500 leading-relaxed">
                            Book appointments with top specialists in seconds. View doctor availability in real-time and secure your token.
                        </p>
                    </div>

                    <div class="group p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-slate-200/50 border border-slate-100 transition-all duration-300 relative overflow-hidden">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Live Queue Tracking</h3>
                        <p class="text-slate-500 leading-relaxed">
                            Avoid the waiting room. Track your queue status live from your dashboard and arrive exactly when the doctor is ready.
                        </p>
                    </div>

                    <div class="group p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-slate-200/50 border border-slate-100 transition-all duration-300">
                        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">E-Prescriptions</h3>
                        <p class="text-slate-500 leading-relaxed">
                            Never lose a prescription again. Access your medical history, diagnosis, and medicine details digitally anytime.
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <footer class="bg-slate-900 text-slate-400 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <span class="font-bold text-xl text-white tracking-tight">Smart<span class="text-teal-500">Hospital</span></span>
                        <p class="text-sm mt-2">© {{ date('Y') }} Hospital Management System. All rights reserved.</p>
                    </div>
                    
                    <div class="flex gap-8">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-white">24/7</span>
                            <span class="text-xs uppercase tracking-wider">Support</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-white">15+</span>
                            <span class="text-xs uppercase tracking-wider">Specialists</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>