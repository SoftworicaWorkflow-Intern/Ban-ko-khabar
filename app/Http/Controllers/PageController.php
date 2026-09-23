<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    private function newsItems(): array
    {
        return [
            [
                'id' => 1,
                'slug' => 'ratuwamai-ban-ko-samrachyan',
                'title' => 'रातुमाईमा वन संरक्षणका लागि नयाँ राष्ट्रिय अभियान सुरु',
                'excerpt' => 'वन्यजन्तु संरक्षण र वातावरणीय लचिलोपनलाई मजबूती दिने उद्देश्यले सरकारी र स्थानीय समुदायले साझा कार्यक्रममा सहभागी भएको छ।',
                'body' => '...',
                'category' => 'वन संरक्षण',
                'category_slug' => 'forest-conservation',
                'category_icon' => '🌲',
                'author' => 'प्रभा घिमिरे',
                'published_at' => 'आज ७:१५ बजे',
                'date' => '२०८१ मंसिर १८',
                'reading_time' => '५ मिनेट',
                'views' => 2450,
                'image' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1200&q=80',
                'featured' => true,
                'badge' => 'मुख्य समाचार',
            ],
            [
                'id' => 2,
                'slug' => 'chitwan-royal-bengal-tiger',
                'title' => 'चितवनमा कोसी नदा क्षेत्रमा बाघको बसाइँ बढ्यो',
                'excerpt' => 'पर्यावरणविद्हरूका अनुसार जलवायु परिवर्तनले वन्यजन्तुको आवास क्षेत्रलाई असर गरिरहेको बताइएपछि संरक्षणमा जोड दिइरहेको छ।',
                'category' => 'वन्यजन्तु',
                'category_slug' => 'wildlife',
                'category_icon' => '🦏',
                'author' => 'सूर्य थापा',
                'published_at' => 'आज ६:३० बजे',
                'date' => '२०८१ मंसिर १७',
                'reading_time' => '४ मिनेट',
                'views' => 1890,
                'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'वन्यजन्तु',
            ],
            [
                'id' => 3,
                'slug' => 'himalayan-glacier-retreat',
                'title' => 'हिमाली ग्लेशियर घट्दै जाँदा नदी प्रवाहमा परिवर्तन',
                'excerpt' => 'पुर्वी नेपालका नदी स्रोत क्षेत्रमा ग्लेशियर घट्नाले कृषि र जलस्रोतमा पर्ने प्रभाव माथि अध्ययन जारी छ।',
                'category' => 'जलवायु परिवर्तन',
                'category_slug' => 'climate-change',
                'category_icon' => '🌦️',
                'author' => 'अमृता राणा',
                'published_at' => 'आज ५:५० बजे',
                'date' => '२०८१ मंसिर १६',
                'reading_time' => '७ मिनेट',
                'views' => 3320,
                'image' => 'https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'जलवायु',
            ],
            [
                'id' => 4,
                'slug' => 'community-forest-initiative',
                'title' => 'सामुदायिक वनमा महिला समूहले वृक्षरोपण र संरक्षण जोड्दै',
                'excerpt' => 'ग्रामिण क्षेत्रमा महिला समुहका प्रयासले स्थानीय वातावरणीय स्थिरता र वनको सुरक्षा क्षेत्रमा सकारात्मक परिणाम देखाइरहेको छ।',
                'category' => 'सामुदायिक वन',
                'category_slug' => 'community-forest',
                'category_icon' => '🌱',
                'author' => 'नारायण खत्री',
                'published_at' => 'आज ४:२० बजे',
                'date' => '२०८१ मंसिर १५',
                'reading_time' => '३ मिनेट',
                'views' => 1645,
                'image' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'सामुदायिक वन',
            ],
            [
                'id' => 5,
                'slug' => 'suklaphanta-national-park',
                'title' => 'सुक्लाफाँटा राष्ट्रिय निकुञ्जमा शिकार प्रतिरोध अभियान',
                'excerpt' => 'राष्ट्रिय निकुञ्जका प्रहरी र स्थानीय युवाहरूले संयुक्त रुपमा शिकार रोकथाम अभियानलाई गति दिए।',
                'category' => 'राष्ट्रिय निकुञ्ज',
                'category_slug' => 'national-park',
                'category_icon' => '🏞️',
                'author' => 'दीपक बस्नेत',
                'published_at' => 'आज ११:०० बजे',
                'date' => '२०८१ मंसिर १४',
                'reading_time' => '६ मिनेट',
                'views' => 2205,
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'निकुञ्ज',
            ],
            [
                'id' => 6,
                'slug' => 'forest-fire-prevention',
                'title' => 'द्वितीय श्रेणी वनोंमा आगलागी रोकथामका लागि आधुनिक उपाय',
                'excerpt' => 'घामिलो मौसम र वायुमा चर्को熱को कारण आगलागी घटना बढ्दै गएकोले स्थानीय विकिरण निगरानीको प्रविधि अपनाइयो।',
                'category' => 'वन संरक्षण',
                'category_slug' => 'forest-conservation',
                'category_icon' => '🌲',
                'author' => 'रक्षमाया अधिकारी',
                'published_at' => 'हिजो',
                'date' => '२०८१ मंसिर १३',
                'reading_time' => '४ मिनेट',
                'views' => 2760,
                'image' => 'https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'रोकथाम',
            ],
            [
                'id' => 7,
                'slug' => 'nepal-rivers-water-quality',
                'title' => 'नेपालका प्रमुख नदीहरूमा पानीको गुणस्तर परीक्षण बढ्यो',
                'excerpt' => 'मौसमीय परिवर्तन, जलवायु र मानवप्रयोगको प्रभावलाई हेर्दै नदीको पानीको विश्लेषणलाई जोड दिइएको छ।',
                'category' => 'वातावरण',
                'category_slug' => 'environment',
                'category_icon' => '🌍',
                'author' => 'मुक्ति शर्मा',
                'published_at' => 'हिजो',
                'date' => '२०८१ मंसिर १२',
                'reading_time' => '५ मिनेट',
                'views' => 2012,
                'image' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'पानी',
            ],
            [
                'id' => 8,
                'slug' => 'forest-education-program',
                'title' => 'विद्यालयहरूमा वन शिक्षा कार्यक्रम विस्तार',
                'excerpt' => 'नयाँ पुस्तिकाहरू र व्यावहारिक कार्यक्रमका माध्यमले विद्यार्थीहरूमा वन संरक्षणको भावना जगाइयो।',
                'category' => 'वन संरक्षण',
                'category_slug' => 'forest-conservation',
                'category_icon' => '🌲',
                'author' => 'रीतिका झा',
                'published_at' => 'पछिल्लो',
                'date' => '२०८१ मंसिर ११',
                'reading_time' => '३ मिनेट',
                'views' => 1338,
                'image' => 'https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'शिक्षा',
            ],
        ];
    }

    private function categoryCards(): array
    {
        return [
            ['name' => 'वन संरक्षण', 'icon' => '🌲', 'count' => '२४ समाचार', 'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'वन्यजन्तु', 'icon' => '🦏', 'count' => '१७ समाचार', 'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'वातावरण', 'icon' => '🌍', 'count' => '१८ समाचार', 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'जलवायु परिवर्तन', 'icon' => '🌦️', 'count' => '१२ समाचार', 'image' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'सामुदायिक वन', 'icon' => '🌱', 'count' => '१४ समाचार', 'image' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'राष्ट्रिय निकुञ्ज', 'icon' => '🏞️', 'count' => '९ समाचार', 'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=80'],
        ];
    }

    private function galleryItems(): array
    {
        return [
            ['title' => 'हिमाली वन', 'category' => 'वन संरक्षण', 'image' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=900&q=80'],
            ['title' => 'फूलपाङ्ग्रा', 'category' => 'वन्यजन्तु', 'image' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=900&q=80'],
            ['title' => 'नदीको किनार', 'category' => 'वातावरण', 'image' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=900&q=80'],
            ['title' => 'जंगलको रंग', 'category' => 'राष्ट्रिय निकुञ्ज', 'image' => 'https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=900&q=80'],
            ['title' => 'वन्य जीवन', 'category' => 'वन्यजन्तु', 'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=900&q=80'],
            ['title' => 'सामुदायिक वृक्षारोपण', 'category' => 'सामुदायिक वन', 'image' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=900&q=80'],
            ['title' => 'पनासको विदाई', 'category' => 'वन संरक्षण', 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80'],
            ['title' => 'मौसम परिवर्तन', 'category' => 'जलवायु परिवर्तन', 'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=80'],
        ];
    }

    private function teamMembers(): array
    {
        return [
            ['name' => 'दिपक राणा', 'role' => 'कार्यकारी निर्देशक', 'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=500&q=80'],
            ['name' => 'सरस्वती पौडेल', 'role' => 'पर्यावरण रिपोर्टर', 'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=500&q=80'],
            ['name' => 'अनिल श्रेष्ठ', 'role' => 'वन संरक्षण सहयोगी', 'image' => 'https://images.unsplash.com/photo-1504593811423-6dd665756598?auto=format&fit=crop&w=500&q=80'],
        ];
    }

    public function home()
    {
        $news = $this->newsItems();
        $featured = $news[0];
        $sideFeatures = array_slice($news, 1, 3);
        $latest = array_slice($news, 2, 6);
        $trending = array_slice($news, 0, 5);

        return view('home', [
            'featured' => $featured,
            'sideFeatures' => $sideFeatures,
            'latest' => $latest,
            'trending' => $trending,
            'categories' => $this->categoryCards(),
            'breakingNews' => ['अलगै नेपालको जंगलमा जलवायु अनुकूलन योजना लागू हुँदै', 'सामुदायिक वनमा २,५०० बिरुवा रोपण सम्पन्न', 'हिमालपारका नदीहरूमा शुद्ध पानी संरक्षणमा नयाँ नीति'],
            'gallery' => array_slice($this->galleryItems(), 0, 6),
        ]);
    }

    public function showNews(string $slug)
    {
        $news = $this->newsItems();
        $article = collect($news)->firstWhere('slug', $slug) ?? $news[0];
        $related = collect($news)
            ->where('category', $article['category'])
            ->reject(fn ($item) => $item['id'] === $article['id'])
            ->take(3)
            ->values()
            ->all();

        return view('news.show', [
            'article' => $article,
            'related' => $related,
        ]);
    }

    public function search(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        $category = $request->get('category');
        $results = $this->newsItems();

        if ($query !== '') {
            $results = array_values(array_filter($results, fn ($item) => str_contains(strtolower($item['title']), strtolower($query)) || str_contains(strtolower($item['excerpt']), strtolower($query))));
        }

        if ($category && $category !== 'all') {
            $results = array_values(array_filter($results, fn ($item) => $item['category'] === $category));
        }

        return view('search', [
            'query' => $query,
            'category' => $category ?? 'all',
            'results' => $results,
            'categories' => collect($this->categoryCards())->pluck('name')->all(),
        ]);
    }

    public function about()
    {
        return view('about', [
            'team' => $this->teamMembers(),
            'stats' => [
                ['label' => 'सहयोगितामूलक वन क्षेत्र', 'value' => '१.२ मिलियन हेक्टर'],
                ['label' => 'वर्षिय समाचार', 'value' => '१०,०००+'],
                ['label' => 'सक्रिय साझेदार', 'value' => '१२५'],
                ['label' => 'प्रमुख अभियान', 'value' => '१८'],
            ],
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function gallery()
    {
        return view('gallery', [
            'galleryItems' => $this->galleryItems(),
            'categories' => collect($this->categoryCards())->pluck('name')->all(),
        ]);
    }

    public function adminDashboard()
    {
        return view('admin.dashboard', [
            'newsCount' => count($this->newsItems()),
            'userCount' => 1284,
            'commentCount' => 436,
            'viewCount' => 82460,
            'subscriberCount' => 3074,
            'monthlyNews' => [45, 52, 38, 60, 68, 72, 66, 84, 91, 77, 89, 96],
            'categoryStats' => [
                ['label' => 'वन संरक्षण', 'value' => 32],
                ['label' => 'वन्यजन्तु', 'value' => 24],
                ['label' => 'वातावरण', 'value' => 18],
                ['label' => 'जलवायु परिवर्तन', 'value' => 15],
            ],
        ]);
    }
}
