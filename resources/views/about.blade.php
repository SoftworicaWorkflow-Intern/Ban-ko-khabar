@extends('layouts.app')

@section('title', 'हाम्रो बारेमा | वनको खबर')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">About us</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">वनको खबरको कथा</h1>
        </div>

        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="rounded-[30px] bg-white p-8 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <p class="text-sm leading-8 text-[#4f5c4f] dark:text-[#dce8dd]">
                    वनको खबर नेपालमा जंगल, वन्यजन्तु, जलवायु परिवर्तन, र वातावरणीय विषयमा लक्षित तथ्यपरक समाचार पोर्टल हो। हामीले स्थानीय समुदायको अनुभव, वैज्ञानिक तथ्य, र राष्ट्रिय नीति बीचको सम्बन्धलाई सरल र प्रभावकारी रुपमा प्रस्तुत गर्ने लक्ष्य राख्यौं।
                </p>
                <p class="mt-6 text-sm leading-8 text-[#4f5c4f] dark:text-[#dce8dd]">
                    समुदाय, विद्यार्थी, पत्रकार, र प्रकृतिप्रेमीहरूको सहयोगबाट हामीले नेपाली समृद्धि र प्राकृतिक विविधतालाई उजागर गर्ने आवाज बन्ने प्रयास गर्छौं।
                </p>
            </div>
            <div class="rounded-[30px] bg-[linear-gradient(135deg,#163f21,#2E7D32,#1B5E20)] p-8 text-white">
                <div class="text-xs font-bold uppercase tracking-[0.28em] text-[#d9f7d6]">Vision</div>
                <h2 class="mt-4 font-display text-3xl font-bold">हरित नेपालको आवाज</h2>
                <p class="mt-4 text-sm leading-7 text-[#e3f9e5]">उच्च शैक्षिक मान्यताका साथ, तथ्यपरक रिपोर्टिङ र सार्वजनिक जागरूकता मार्फत हरित भविष्य निर्माण गर्नु।</p>
            </div>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach($stats as $stat)
                <div class="rounded-[24px] bg-white p-6 text-center shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                    <div class="text-3xl font-black text-[#2E7D32]">{{ $stat['value'] }}</div>
                    <div class="mt-3 text-sm text-[#4f5c4f] dark:text-[#dce8dd]">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-16">
            <div class="mb-8 text-center">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Team</p>
                <h2 class="mt-3 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">सम्पादकीय टोली</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach($team as $member)
                    <div class="overflow-hidden rounded-[28px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="h-72 w-full object-cover">
                        <div class="p-5">
                            <h3 class="font-display text-2xl font-bold text-[#1d2a1d] dark:text-[#edf5ee]">{{ $member['name'] }}</h3>
                            <p class="mt-2 text-sm text-[#4f5c4f] dark:text-[#dce8dd]">{{ $member['role'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
