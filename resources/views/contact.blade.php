@extends('layouts.app')

@section('title', 'सम्पर्क | वनको खबर')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Contact</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">सम्पर्क गर्नुहोस्</h1>
        </div>

        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="space-y-5">
                <div class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                    <div class="text-sm font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Address</div>
                    <p class="mt-3 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">काठमाण्डौ, नेपाल<br>गणेशमान नजिक, वनको खबर</p>
                </div>
                <div class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                    <div class="text-sm font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Phone</div>
                    <p class="mt-3 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">+977-1-4567890</p>
                </div>
                <div class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                    <div class="text-sm font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Email</div>
                    <p class="mt-3 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">hello@vankokhabar.com</p>
                </div>
            </div>

            <div class="rounded-[30px] bg-white p-8 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <form class="space-y-5">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[#1B5E20] dark:text-[#edf5ee]">नाम</label>
                        <input type="text" class="h-12 w-full rounded-full border border-[#dfeae0] bg-[#f8faf8] px-4 text-sm outline-none focus:border-[#2E7D32] dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[#1B5E20] dark:text-[#edf5ee]">इमेल</label>
                        <input type="email" class="h-12 w-full rounded-full border border-[#dfeae0] bg-[#f8faf8] px-4 text-sm outline-none focus:border-[#2E7D32] dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[#1B5E20] dark:text-[#edf5ee]">सन्देश</label>
                        <textarea rows="5" class="w-full rounded-[24px] border border-[#dfeae0] bg-[#f8faf8] px-4 py-3 text-sm outline-none focus:border-[#2E7D32] dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]"></textarea>
                    </div>
                    <button type="submit" class="rounded-full bg-[#2E7D32] px-6 py-3 text-sm font-bold text-white hover:bg-[#1B5E20]">पठाउनुहोस्</button>
                </form>
            </div>
        </div>

        <div class="mt-12 overflow-hidden rounded-[30px] bg-white p-3 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
            <iframe src="https://www.google.com/maps?q=Kathmandu%20Nepal&output=embed" class="h-[350px] w-full rounded-[24px] border-0" loading="lazy"></iframe>
        </div>
    </section>
@endsection
