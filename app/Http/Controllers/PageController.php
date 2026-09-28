<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    private function homeHighlights(): array
    {
        return [
            ['title' => 'वन निगरानी', 'label' => 'Field Report', 'icon' => '🌲', 'description' => 'वन क्षेत्रको दृश्य स्थिति र नवाचार'],
            ['title' => 'प्रकृति पर्यटन', 'label' => 'Travel Guide', 'icon' => '🦌', 'description' => 'पर्यटन र संरक्षण बीचको संतुलन'],
            ['title' => 'जल संरक्षण', 'label' => 'Water Watch', 'icon' => '💧', 'description' => 'नदी र जलाशयको स्थिरता'],
            ['title' => 'वन्यजन्तु', 'label' => 'Wildlife', 'icon' => '🦏', 'description' => 'जीवविविधता र आवास संरक्षण'],
            ['title' => 'आग्लो फायर', 'label' => 'Risk Monitor', 'icon' => '🔥', 'description' => 'द्वितीय श्रेणी वनमा जोखिम'],
            ['title' => 'ग्रामिण वन', 'label' => 'Community', 'icon' => '🌱', 'description' => 'स्थानीय नेतृत्वमा संरक्षण'],
            ['title' => 'मौसम परिवर्तन', 'label' => 'Climate', 'icon' => '🌦️', 'description' => 'पर्यावरणीय परिवर्तन र असर'],
            ['title' => 'शिक्षा अभियान', 'label' => 'Youth', 'icon' => '🎓', 'description' => 'विद्यार्थीलाई संरक्षण शिक्षा'],
            ['title' => 'निती अनुगमन', 'label' => 'Policy', 'icon' => '📜', 'description' => 'सरकारी नीति र प्रभाव'],
            ['title' => 'संकट व्यवस्थापन', 'label' => 'Response', 'icon' => '🚑', 'description' => 'जंगली घटनामा तत्काल सहयोग'],
            ['title' => 'पर्यावरण सर्वेक्षण', 'label' => 'Survey', 'icon' => '📊', 'description' => 'डाटा आधारित संरक्षण रिपोर्ट'],
            ['title' => 'स्थानीय आवाज', 'label' => 'Voices', 'icon' => '🗣️', 'description' => 'समुदायका कथाहरू र अनुभव'],
        ];
    }

    public function home(Request $request)
    {
        $news = $this->newsItems();
        $featured = $news[0];
        $sideFeatures = array_slice($news, 1, 3);

        $perPage = 4;
        $page = max(1, (int) $request->query('page', 1));
        $latestItems = array_slice($news, 2);
        $paginatedLatest = new LengthAwarePaginator(
            array_slice($latestItems, ($page - 1) * $perPage, $perPage),
            count($latestItems),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $trending = array_slice($news, 0, 5);

        return view('home', [
            'featured' => $featured,
            'sideFeatures' => $sideFeatures,
            'latest' => $paginatedLatest->items(),
            'pagination' => $paginatedLatest,
            'trending' => $trending,
            'categories' => $this->categoryCards(),
            'highlights' => $this->homeHighlights(),
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

    public function privacy()
    {
        return view('privacy');
    }

    public function terms()
    {
        return view('terms');
    }

    public function support()
    {
        return view('support');
    }

    public function gallery()
    {
        return view('gallery', [
            'galleryItems' => $this->galleryItems(),
            'categories' => collect($this->categoryCards())->pluck('name')->all(),
        ]);
    }

    public function category(string $slug)
    {
        $categories = [
            'forest-conservation' => [
                'title' => 'वन संरक्षण',
                'description' => 'वन संरक्षण, सामुदायिक वन, र वातावरणीय लचिलोपनका विषयमा तथ्यपरक समाचार र रिपोर्टहरू।',
                'hero' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1200&q=80',
            ],
            'wildlife' => [
                'title' => 'वन्यजन्तु',
                'description' => 'वन्यजन्तु संरक्षण, आवासको सुरक्षा, र प्राकृतिक विविधताको संरक्षणसँग सम्बन्धित खबरहरू।',
                'hero' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=1200&q=80',
            ],
            'environment' => [
                'title' => 'वातावरण',
                'description' => 'भौतिक वातावरण, जलस्रोत, र संधै सुरुचिरा विषयवस्तुमा आधारित रिपोर्टिङ।',
                'hero' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
            ],
            'climate-change' => [
                'title' => 'जलवायु परिवर्तन',
                'description' => 'जलवायु परिवर्तन, ग्लेशियर घट्ने phenomena, र जनजीवनमा असर पार्ने विषयहरू।',
                'hero' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        $category = $categories[$slug] ?? $categories['forest-conservation'];
        $filtered = array_values(array_filter($this->newsItems(), fn ($item) => ($item['category_slug'] ?? '') === $slug || $slug === 'forest-conservation' && $item['category_slug'] === 'forest-conservation'));

        if (empty($filtered) && $slug !== 'forest-conservation') {
            $filtered = array_values(array_filter($this->newsItems(), fn ($item) => $item['category'] === $category['title']));
        }

        if (empty($filtered)) {
            $filtered = $this->newsItems();
        }

        return view('category', [
            'category' => $category,
            'articles' => $filtered,
        ]);
    }

    public function adminDashboard()
    {
        $newsCount = News::count();
        $userCount = User::count();

        return view('admin.dashboard', [
            'newsCount' => $newsCount,
            'userCount' => $userCount,
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
            'userName' => Auth::user()->name ?? 'Admin User',
            'lastLogin' => 'Today, 10:42 AM',
        ]);
    }

    public function adminArticles()
    {
        $items = News::query()->with('category')->latest()->paginate(6)->withQueryString();

        return $this->adminSection('Articles', 'Newsroom content and publishing pipeline', [
            ['label' => 'Published', 'value' => (string) News::query()->where('status', 'published')->count(), 'meta' => '+12% this month'],
            ['label' => 'Drafts', 'value' => (string) News::query()->where('status', 'draft')->count(), 'meta' => '3 need review'],
            ['label' => 'Pending', 'value' => (string) News::query()->where('status', 'pending')->count(), 'meta' => '2 urgent'],
        ], $items, 'articles', [
            'tableColumns' => ['Title', 'Category', 'Date', 'Views', 'Actions'],
        ]);
    }

    public function adminCategories()
    {
        $items = Category::query()->withCount('news')->latest()->paginate(6)->withQueryString();

        return $this->adminSection('Categories', 'Editorial sections and topic coverage', [
            ['label' => 'Total categories', 'value' => (string) Category::query()->count(), 'meta' => '2 new this quarter'],
            ['label' => 'Top category', 'value' => 'Forest', 'meta' => '32% of traffic'],
            ['label' => 'Avg. engagement', 'value' => '78%', 'meta' => '+6 pts'],
        ], $items, 'categories', [
            'tableColumns' => ['Name', 'News count', 'Status', 'Actions'],
        ]);
    }

    public function adminGallery()
    {
        $items = News::query()->whereNotNull('image_url')->latest()->paginate(6)->withQueryString();

        return $this->adminSection('Gallery', 'Uploaded photos, media, and visual stories', [
            ['label' => 'Photos', 'value' => (string) News::query()->whereNotNull('image_url')->count(), 'meta' => '+84 this week'],
            ['label' => 'Videos', 'value' => '63', 'meta' => '5 in review'],
            ['label' => 'Approved', 'value' => '94%', 'meta' => 'quality checks passed'],
        ], $items, 'gallery', [
            'tableColumns' => ['Title', 'Category', 'Image', 'Status'],
        ]);
    }

    public function adminUsers()
    {
        $users = User::query()->latest()->paginate(8)->withQueryString();

        return $this->adminSection('Users', 'Registered accounts, roles, and access records', [
            ['label' => 'Total users', 'value' => (string) User::query()->count(), 'meta' => '+9% this month'],
            ['label' => 'Admins', 'value' => (string) User::query()->where('role', 'admin')->count(), 'meta' => '2 active today'],
            ['label' => 'Editors', 'value' => (string) User::query()->whereIn('role', ['editor', 'reporter'])->count(), 'meta' => '7 online now'],
        ], $users, 'users', [
            'tableColumns' => ['Name', 'Email', 'Role', 'Registered', 'Last login'],
        ]);
    }

    public function adminReports()
    {
        $reportSections = [
            ['label' => 'Traffic', 'value' => '84.6K', 'meta' => '+18% vs last month'],
            ['label' => 'Bounce rate', 'value' => '28%', 'meta' => 'down from 35%'],
            ['label' => 'Avg. time', 'value' => '4m 12s', 'meta' => '+28 sec'],
            ['label' => 'Sessions', 'value' => '62.1K', 'meta' => '+9% this week'],
            ['label' => 'Page views', 'value' => '214K', 'meta' => '+12% this week'],
            ['label' => 'Subscribers', 'value' => '3,074', 'meta' => '+214 this month'],
            ['label' => 'New stories', 'value' => '96', 'meta' => 'this month'],
            ['label' => 'Ad revenue', 'value' => 'रू 48.2K', 'meta' => '+16% vs last month'],
        ];

        $businessGrowth = [
            ['label' => 'New sponsors', 'value' => '6', 'meta' => '2 signed this week'],
            ['label' => 'Renewed deals', 'value' => '11', 'meta' => '89% renewal rate'],
            ['label' => 'Monthly growth', 'value' => '+22%', 'meta' => 'revenue vs last month'],
            ['label' => 'Pipeline value', 'value' => 'रू 1.2M', 'meta' => 'open opportunities'],
        ];

        $items = $this->paginateArray([
            ['title' => 'Weekly traffic report', 'status' => 'Ready', 'meta' => 'Auto-generated Monday'],
            ['title' => 'Engagement summary', 'status' => 'Updated', 'meta' => 'After yesterday drop'],
            ['title' => 'Revenue / sponsor overview', 'status' => 'Draft', 'meta' => 'Awaiting final numbers'],
            ['title' => 'Audience retention report', 'status' => 'Ready', 'meta' => 'Generated Tuesday'],
            ['title' => 'Search performance', 'status' => 'Ready', 'meta' => 'Top 20 keywords tracked'],
            ['title' => 'Newsletter performance', 'status' => 'Updated', 'meta' => 'Open rate 41%'],
            ['title' => 'Category-wise readership', 'status' => 'Draft', 'meta' => 'Awaiting final numbers'],
            ['title' => 'Sponsor impressions', 'status' => 'Ready', 'meta' => 'Generated Wednesday'],
        ], 4);

        return $this->adminSection('Reports', 'Analytics, engagement, and summaries', $reportSections, $items, 'reports', [
            'tableColumns' => ['Report', 'Status', 'Updated'],
            'businessGrowth' => $businessGrowth,
        ]);
    }

    public function adminSettings()
    {
        $user = Auth::user();

        $items = $this->paginateArray([
            ['title' => 'Site configuration', 'status' => 'Active', 'meta' => 'Updated yesterday'],
            ['title' => 'Publishing rules', 'status' => 'Enabled', 'meta' => 'Quality gates active'],
            ['title' => 'Notifications', 'status' => 'Monitoring', 'meta' => 'Slack + email active'],
            ['title' => 'Theme & branding', 'status' => 'Active', 'meta' => 'Updated last week'],
            ['title' => 'Comment moderation', 'status' => 'Enabled', 'meta' => 'Auto-hold flagged'],
            ['title' => 'Backup schedule', 'status' => 'Daily', 'meta' => '03:00 AM NPT'],
        ], 3);

        return $this->adminSection('Settings', 'Site preferences, publishing rules, and controls', [
            ['label' => 'Themes', 'value' => '2', 'meta' => 'Default + dark mode'],
            ['label' => 'Automation', 'value' => '5', 'meta' => 'Rules enabled'],
            ['label' => 'Alerts', 'value' => '12', 'meta' => '2 critical'],
        ], $items, 'settings', [
            'tableColumns' => ['Setting', 'Value', 'Last update'],
            'lastPasswordChanged' => $user?->password_changed_at ? $user->password_changed_at->format('Y-m-d H:i') : '2026-09-10 09:12',
            'lastLogin' => $user?->last_login_at ? $user->last_login_at->format('M d, Y, h:i A') : 'No record yet',
        ]);
    }

    public function storeArticle(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:news'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status' => ['required', 'in:draft,published,pending'],
            'image_url' => ['nullable', 'url'],
            'author' => ['nullable', 'string', 'max:255'],
        ]);

        News::create([
            ...$validated,
            'views' => 0,
        ]);

        return redirect()->route('admin.articles')->with('success', 'Article created successfully.');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function deleteArticle(int $id)
    {
        $article = News::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.articles')->with('success', 'Article deleted.');
    }

    public function updateCategory(Request $request, int $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,'.$category->id],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories')->with('success', 'Category updated.');
    }

    public function deleteCategory(int $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted.');
    }

    public function storeGallery(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:news'],
            'image_url' => ['required', 'url'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status' => ['nullable', 'in:draft,published,pending'],
        ]);

        News::create([
            ...$validated,
            'status' => $validated['status'] ?? 'published',
            'views' => 0,
            'author' => Auth::user()?->name ?? 'Admin',
        ]);

        return redirect()->route('admin.gallery')->with('success', 'Photo added to gallery.');
    }

    public function deleteGallery(int $id)
    {
        $photo = News::findOrFail($id);
        $photo->delete();

        return redirect()->route('admin.gallery')->with('success', 'Photo removed from gallery.');
    }

    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,editor,reporter'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.settings')->with('success', 'Account created.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (! $user || ! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->password_changed_at = now();
        $user->save();

        return redirect()->route('admin.settings')->with('success', 'Password updated.');
    }

    /**
     * Paginate a plain array of rows so array-backed pages support ?page= links.
     *
     * @param  array<int, array<string, mixed>>  $rows
     * @return LengthAwarePaginator<int, array<string, mixed>>
     */
    private function paginateArray(array $rows, int $perPage): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $total = count($rows);

        return new LengthAwarePaginator(
            array_slice($rows, ($page - 1) * $perPage, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }

    private function adminSection(string $title, string $subtitle, array $stats, $items, string $pageType = 'dashboard', array $meta = [])
    {
        return view('admin.page', [
            'pageTitle' => $title,
            'subtitle' => $subtitle,
            'stats' => $stats,
            'items' => $items,
            'pageType' => $pageType,
            'tableColumns' => $meta['tableColumns'] ?? [],
            'userName' => Auth::user()->name ?? 'Admin User',
            'lastLogin' => $meta['lastLogin'] ?? (Auth::user()?->last_login_at?->format('M d, Y, h:i A') ?? 'No record yet'),
            'lastPasswordChanged' => $meta['lastPasswordChanged'] ?? '2026-09-10 09:12',
            'businessGrowth' => $meta['businessGrowth'] ?? [],
            'cards' => $items,
        ]);
    }
}
