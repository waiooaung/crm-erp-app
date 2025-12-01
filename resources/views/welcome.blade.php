<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AssetManager.AI') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'media',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1', // Indigo
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Subtle Grid Background */
        .bg-grid {
            background-size: 40px 40px;
            background-image: radial-gradient(circle, #e0e7ff 1px, transparent 1px);
        }
        @media (prefers-color-scheme: dark) {
            .bg-grid {
                background-image: radial-gradient(circle, #312e81 1px, transparent 1px);
            }
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        @media (prefers-color-scheme: dark) {
            .glass-card {
                background: rgba(30, 41, 59, 0.7);
            }
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 min-h-screen flex flex-col relative overflow-x-hidden font-sans selection:bg-primary-500 selection:text-white">

    <div class="absolute inset-0 bg-grid opacity-[0.4] pointer-events-none"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-primary-500/20 blur-[120px] rounded-full pointer-events-none"></div>

    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center relative z-10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg shadow-primary-500/30">
                AI
            </div>
            <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">AssetManager</span>
        </div>

        @if (Route::has('login'))
            <nav class="flex gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition shadow-lg shadow-primary-500/20 text-sm">
                        Go to Dashboard &rarr;
                    </a>
                @else
                    <a href="{{ route('filament.admin.auth.login') }}" class="px-4 py-2 text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition text-sm">
                        Log in
                    </a>
                @endauth
            </nav>
        @endif
    </header>

    <main class="grow flex items-center justify-center relative z-10 px-6 py-12">
        <div class="max-w-7xl w-full grid lg:grid-cols-2 gap-16 items-center">

            <div class="space-y-8 max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-50 dark:bg-primary-900/30 border border-primary-100 dark:border-primary-800 text-primary-700 dark:text-primary-300 text-xs font-semibold uppercase tracking-wide">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                    </span>
                    Now with GPT-4 Integration
                </div>

                <h1 class="text-5xl lg:text-6xl font-bold tracking-tight text-slate-900 dark:text-white leading-[1.1]">
                    Intelligent <br>
                    <span class="text-transparent bg-clip-text bg-linear-to-r from-primary-600 to-violet-600">Asset Tracking</span>
                </h1>

                <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                    Stop guessing. Start tracking. Use our AI-powered assistant to categorize assets, extract data from receipts, and classify maintenance issues in seconds.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('filament.admin.auth.login') }}" class="px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl shadow-xl shadow-primary-500/20 transition transform hover:-translate-y-1 text-center">
                        Get Started Free
                    </a>
                    <a href="#" class="px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-semibold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition text-center flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        View Demo
                    </a>
                </div>

                <div class="pt-8 border-t border-slate-200 dark:border-slate-800 grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="font-medium text-slate-700 dark:text-slate-300">AI Receipt Scan</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="font-medium text-slate-700 dark:text-slate-300">Issue Classifier</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="font-medium text-slate-700 dark:text-slate-300">Audit Logs</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="font-medium text-slate-700 dark:text-slate-300">Global Search</span>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -top-10 -right-10 w-72 h-72 bg-purple-500/30 rounded-full blur-[60px] pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-blue-500/30 rounded-full blur-[60px] pointer-events-none"></div>

                <div class="glass-card relative border border-white/20 dark:border-slate-700 rounded-2xl p-6 shadow-2xl transform rotate-2 hover:rotate-0 transition duration-500">

                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="h-2 w-20 bg-slate-200 dark:bg-slate-700 rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Total Assets</div>
                            <div class="text-2xl font-bold text-slate-900 dark:text-white">1,248</div>
                            <div class="text-xs text-green-500 mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                +12% this month
                            </div>
                        </div>
                        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Active Issues</div>
                            <div class="text-2xl font-bold text-slate-900 dark:text-white">5</div>
                            <div class="text-xs text-red-500 mt-2 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                2 Critical
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-800 rounded-lg border border-slate-100 dark:border-slate-700">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-800 dark:text-slate-200">MacBook Pro M2</div>
                                    <div class="text-xs text-slate-500">Assigned to: John Doe</div>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-medium">In Stock</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-800 rounded-lg border border-slate-100 dark:border-slate-700">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-orange-100 dark:bg-orange-900/50 flex items-center justify-center text-orange-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-800 dark:text-slate-200">Office Printer</div>
                                    <div class="text-xs text-slate-500">Network Error</div>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full font-medium">Critical</span>
                        </div>
                    </div>

                    <div class="absolute -right-6 bottom-8 bg-white dark:bg-slate-800 p-4 rounded-xl shadow-xl border border-primary-100 dark:border-slate-600 w-48 animate-bounce delay-700">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-lg">✨</span>
                            <span class="text-xs font-bold text-slate-900 dark:text-white">AI Insight</span>
                        </div>
                        <p class="text-[10px] text-slate-500 leading-tight">
                            "Warranty for Dell XPS expires in 3 days. Initiate renewal?"
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer class="w-full max-w-7xl mx-auto px-6 py-6 text-center text-slate-500 dark:text-slate-500 text-sm relative z-10">
        &copy; {{ date('Y') }} AssetManager.AI. All rights reserved. Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>
</body>
</html>
