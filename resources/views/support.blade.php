@extends('layouts.app')

@section('title', 'Support | वनको खबर')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Support</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Support Center</h1>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <div class="text-sm font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Email</div>
                <p class="mt-4 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">support@vankokhabar.com</p>
            </div>
            <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <div class="text-sm font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Phone</div>
                <p class="mt-4 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">+977-1-4567890</p>
            </div>
            <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <div class="text-sm font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Hours</div>
                <p class="mt-4 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">Sun - Fri<br>9:00 AM - 6:00 PM</p>
            </div>
        </div>

        <div class="mt-8 rounded-[30px] bg-white p-8 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b] dark:text-[#edf5ee]">
            <h2 class="font-display text-2xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Need help?</h2>
            <p class="mt-4 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">
                यदि तपाईलाई साइटमा समस्या, सामग्री सम्वन्धी प्रश्न, वा सहयोगको आवश्यकता छ भने हामीलाई इमेल वा फोन मार्फत सम्पर्क गर्नुहोस्। हामीले तपाईको पत्रमा समयमै उत्तर दिने प्रयास गर्छौं।
            </p>
        </div>
    </section>
@endsection
