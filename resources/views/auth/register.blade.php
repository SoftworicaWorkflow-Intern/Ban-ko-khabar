@extends('layouts.app')

@section('title', 'Register | वनको खबर')

@section('content')
    <section class="mx-auto max-w-md px-4 py-20 sm:px-6 lg:px-8">
        <div class="rounded-[30px] bg-white p-8 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
            <div class="mb-8 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#2E7D32] to-[#1B5E20] text-2xl text-white">🌿</div>
                <h1 class="mt-5 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Create account</h1>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#1B5E20] dark:text-[#edf5ee]">Full name</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-[#1B5E20] dark:text-[#edf5ee]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M20 21a8 8 0 1 0-16 0"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <input name="name" type="text" class="h-12 w-full rounded-full border border-[#dfeae0] bg-[#f8faf8] pl-11 pr-4 text-sm dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]" placeholder="Your full name">
                    </div>
                </div>
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
                        <input name="password" type="password" autocomplete="new-password" class="h-12 w-full rounded-full border border-[#dfeae0] bg-[#f8faf8] pl-11 pr-4 text-sm dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]" placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="h-12 w-full rounded-full bg-[#2E7D32] text-sm font-bold text-white hover:bg-[#1B5E20]">Register</button>
            </form>
        </div>
    </section>
@endsection
