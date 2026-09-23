@extends('layouts.app')

@section('title', 'Login | वनको खबर')

@section('content')
    <section class="mx-auto max-w-md px-4 py-20 sm:px-6 lg:px-8">
        <div class="rounded-[30px] bg-white p-8 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
            <div class="mb-8 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#2E7D32] to-[#1B5E20] text-2xl text-white">🌿</div>
                <h1 class="mt-5 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Welcome back</h1>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#1B5E20] dark:text-[#edf5ee]">Email</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-[#1B5E20] dark:text-[#edf5ee]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M4 7.5A2.5 2.5 0 0 1 6.5 5h11A2.5 2.5 0 0 1 20 7.5v9A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-9Z"></path>
                                <path d="m4.5 7 7.5 6 7.5-6"></path>
                            </svg>
                        </span>
                        <input name="email" type="email" class="h-12 w-full rounded-full border border-[#dfeae0] bg-[#f8faf8] pl-11 pr-4 text-sm dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]" placeholder="name@example.com">
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#1B5E20] dark:text-[#edf5ee]">Password</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-[#1B5E20] dark:text-[#edf5ee]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="5" y="11" width="14" height="9" rx="2"></rect>
                                <path d="M8 11V8a4 4 0 1 1 8 0v3"></path>
                            </svg>
                        </span>
                        <input name="password" type="password" autocomplete="current-password" class="h-12 w-full rounded-full border border-[#dfeae0] bg-[#f8faf8] pl-11 pr-4 text-sm dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]" placeholder="••••••••">
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-[#4e5b51] dark:text-[#d3e3d5]">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-[#dfeae0] text-[#2E7D32] focus:ring-[#2E7D32]">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="font-medium text-[#2E7D32] hover:text-[#1B5E20]">Forgot password?</a>
                </div>
                <button type="submit" class="h-12 w-full rounded-full bg-[#2E7D32] text-sm font-bold text-white hover:bg-[#1B5E20]">Login</button>
            </form>
        </div>
    </section>
@endsection
