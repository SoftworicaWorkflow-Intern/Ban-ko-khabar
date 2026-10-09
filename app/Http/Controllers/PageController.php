<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\ArticleComment;
use App\Models\Category;
use App\Models\News;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Media types the gallery can store, filter, and group by.
     *
     * @var list<string>
     */
    private const MEDIA_TYPES = ['image', 'video', 'audio', 'document'];

    /**
     * @var array<string, list<string>>
     */
    private const MEDIA_EXTENSIONS = [
        'image' => ['png', 'jpg', 'jpeg', 'gif', 'webp', 'svg', 'avif', 'bmp', 'ico'],
        'video' => ['mp4', 'webm', 'mov', 'm4v', 'avi', 'mkv', 'ogv'],
        'audio' => ['mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac'],
        'document' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'zip'],
    ];

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
            [
                'id' => 9,
                'slug' => 'climate-lakes-risk',
                'title' => 'जलवायु परिवर्तनले हिमाली तालको जोखिम बढायो',
                'excerpt' => 'तापक्रम वृद्धि र अनियमित हिमपातले हिमाली तालको जलस्तरमा पार्ने असरबारे स्थानीय विज्ञहरूले अध्ययन गरिरहेका छन्।',
                'body' => 'तापक्रम वृद्धि र अनियमित हिमपातले हिमाली तालहरूको जलस्तरमा परिवर्तन ल्याइरहेको छ। जोखिम पहिचान र स्थानीय बस्तीको सुरक्षाका लागि अनुगमन तथा पूर्वसूचना प्रणालीलाई प्राथमिकता दिइएको छ।',
                'category' => 'जलवायु परिवर्तन',
                'category_slug' => 'climate-change',
                'category_icon' => '🌦️',
                'author' => 'सरिता भण्डारी',
                'published_at' => 'गत साता',
                'date' => '२०८१ मंसिर १०',
                'reading_time' => '५ मिनेट',
                'views' => 1860,
                'image' => 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'जलवायु',
            ],
            [
                'id' => 10,
                'slug' => 'monsoon-shift-agriculture',
                'title' => 'मनसुन चक्रमा परिवर्तनले खेतीपातीमा असर',
                'excerpt' => 'वर्षा सुरु हुने समय र यसको वितरणमा देखिएको फेरबदलले किसानको बाली लगाउने तालिका प्रभावित पारेको छ।',
                'body' => 'मनसुनको समय र वर्षाको वितरणमा आएको परिवर्तनले किसानको बाली लगाउने तालिका प्रभावित पारेको छ। मौसमसम्बन्धी सूचना र स्थानीय अनुकूलन योजनाले खेतीपातीको जोखिम घटाउन सहयोग गर्ने विज्ञहरूको भनाइ छ।',
                'category' => 'जलवायु परिवर्तन',
                'category_slug' => 'climate-change',
                'category_icon' => '🌦️',
                'author' => 'प्रकाश अधिकारी',
                'published_at' => 'गत साता',
                'date' => '२०८१ मंसिर ९',
                'reading_time' => '४ मिनेट',
                'views' => 1492,
                'image' => 'https://images.unsplash.com/photo-1501691223387-dd0500403074?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'जलवायु',
            ],
            [
                'id' => 11,
                'slug' => 'riverbank-waste-control',
                'title' => 'नदी किनारका बस्तीमा फोहोरमैला नियन्त्रण अभियान',
                'excerpt' => 'स्थानीय समूहहरूले नदी किनारमा फोहोर संकलन र व्यवस्थापन सुधार्न अभियान थालेका छन्।',
                'body' => 'नदी किनारका बस्तीमा फोहोरमैला व्यवस्थापन सुधार्न स्थानीय समूह र पालिकाले संयुक्त अभियान सुरु गरेका छन्। नियमित संकलन र जनचेतनामार्फत जलस्रोत प्रदूषण कम गर्ने लक्ष्य राखिएको छ।',
                'category' => 'वातावरण',
                'category_slug' => 'environment',
                'category_icon' => '🌍',
                'author' => 'सविता पौडेल',
                'published_at' => 'गत साता',
                'date' => '२०८१ मंसिर ८',
                'reading_time' => '४ मिनेट',
                'views' => 1240,
                'image' => 'https://images.unsplash.com/photo-1437482078695-73f5ca6c96e2?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'वातावरण',
            ],
            [
                'id' => 12,
                'slug' => 'urban-air-monitoring-centres',
                'title' => 'सहरी क्षेत्रमा वायु प्रदूषण मापन केन्द्र विस्तार',
                'excerpt' => 'वायु गुणस्तरबारे समयमै जानकारी दिन थप मापन केन्द्र स्थापना गरिँदैछ।',
                'body' => 'सहरी क्षेत्रमा वायुको गुणस्तर मापन गर्न थप केन्द्रहरू स्थापना हुँदैछन्। संकलित तथ्यांक सार्वजनिक गरेर प्रदूषण नियन्त्रणका योजनालाई प्रभावकारी बनाउने लक्ष्य छ।',
                'category' => 'वातावरण',
                'category_slug' => 'environment',
                'category_icon' => '🌍',
                'author' => 'निरज अधिकारी',
                'published_at' => 'गत साता',
                'date' => '२०८१ मंसिर ७',
                'reading_time' => '३ मिनेट',
                'views' => 980,
                'image' => 'https://images.unsplash.com/photo-1516937941344-00b4e0337589?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'वातावरण',
            ],
            [
                'id' => 13,
                'slug' => 'wildlife-camera-trap-network',
                'title' => 'वन्यजन्तुको बासस्थान जोगाउन क्यामेरा ट्र्याप विस्तार',
                'excerpt' => 'वन क्षेत्रमा क्यामेरा ट्र्याप थपेर वन्यजन्तुको आवागमन र बासस्थानको अवस्था अध्ययन गरिँदैछ।',
                'body' => 'वन्यजन्तुको आवागमन र बासस्थानबारे भरपर्दो जानकारी संकलन गर्न संरक्षणकर्मीहरूले क्यामेरा ट्र्याप विस्तार गरेका छन्। प्राप्त विवरणले जोखिमयुक्त क्षेत्र पहिचान र संरक्षण योजना बनाउन सहयोग गर्नेछ।',
                'category' => 'वन्यजन्तु',
                'category_slug' => 'wildlife',
                'category_icon' => '🦏',
                'author' => 'रमेश थापा',
                'published_at' => 'गत साता',
                'date' => '२०८१ मंसिर ८',
                'reading_time' => '५ मिनेट',
                'views' => 1730,
                'image' => 'https://images.unsplash.com/photo-1561731216-c3a4d99437d5?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'वन्यजन्तु',
            ],
            [
                'id' => 14,
                'slug' => 'chitwan-rhino-census',
                'title' => 'चितवन क्षेत्रमा गैँडाको गणना सुरु',
                'excerpt' => 'नयाँ गणनाले गैँडाको संख्या, बासस्थान र संरक्षण आवश्यकताबारे अद्यावधिक विवरण दिनेछ।',
                'body' => 'संरक्षणकर्मी र निकुञ्जका प्राविधिक टोलीले चितवन क्षेत्रमा गैँडाको गणना सुरु गरेका छन्। गणनाबाट प्राप्त तथ्यांकले बासस्थान व्यवस्थापन र संरक्षण कार्यक्रमको प्राथमिकता तय गर्न सहयोग गर्नेछ।',
                'category' => 'वन्यजन्तु',
                'category_slug' => 'wildlife',
                'category_icon' => '🦏',
                'author' => 'मिना गुरुङ',
                'published_at' => 'गत साता',
                'date' => '२०८१ मंसिर ६',
                'reading_time' => '४ मिनेट',
                'views' => 1560,
                'image' => 'https://images.unsplash.com/photo-1501706362039-c6e13d9c3a7c?auto=format&fit=crop&w=900&q=80',
                'featured' => false,
                'badge' => 'वन्यजन्तु',
            ],
        ];
    }

    private function categoryCards(): array
    {
        return [
            ['name' => 'वन संरक्षण', 'slug' => 'forest-conservation', 'icon' => '🌲', 'count' => 24, 'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'वन्यजन्तु', 'slug' => 'wildlife', 'icon' => '🦏', 'count' => 17, 'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'वातावरण', 'slug' => 'environment', 'icon' => '🌍', 'count' => 18, 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'जलवायु परिवर्तन', 'slug' => 'climate-change', 'icon' => '🌦️', 'count' => 12, 'image' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'सामुदायिक वन', 'slug' => 'community-forest', 'icon' => '🌱', 'count' => 14, 'image' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'राष्ट्रिय निकुञ्ज', 'slug' => 'national-park', 'icon' => '🏞️', 'count' => 9, 'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=80'],
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
            ['title' => 'वन निगरानी', 'slug' => 'forest-conservation', 'label' => 'Field Report', 'icon' => '🌲', 'image' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=600&q=80', 'description' => 'वन क्षेत्रको दृश्य स्थिति र नवाचार'],
            ['title' => 'प्रकृति पर्यटन', 'slug' => 'national-park', 'label' => 'Travel Guide', 'icon' => '🦌', 'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=600&q=80', 'description' => 'पर्यटन र संरक्षण बीचको संतुलन'],
            ['title' => 'जल संरक्षण', 'slug' => 'environment', 'label' => 'Water Watch', 'icon' => '💧', 'image' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=600&q=80', 'description' => 'नदी र जलाशयको स्थिरता'],
            ['title' => 'वन्यजन्तु', 'slug' => 'wildlife', 'label' => 'Wildlife', 'icon' => '🦏', 'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=600&q=80', 'description' => 'जीवविविधता र आवास संरक्षण'],
            ['title' => 'आग्लो फायर', 'slug' => 'forest-conservation', 'label' => 'Risk Monitor', 'icon' => '🔥', 'image' => 'https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=600&q=80', 'description' => 'द्वितीय श्रेणी वनमा जोखिम'],
            ['title' => 'ग्रामिण वन', 'slug' => 'community-forest', 'label' => 'Community', 'icon' => '🌱', 'image' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=600&q=80', 'description' => 'स्थानीय नेतृत्वमा संरक्षण'],
            ['title' => 'मौसम परिवर्तन', 'slug' => 'climate-change', 'label' => 'Climate', 'icon' => '🌦️', 'image' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=600&q=80', 'description' => 'पर्यावरणीय परिवर्तन र असर'],
            ['title' => 'शिक्षा अभियान', 'slug' => 'community-forest', 'label' => 'Youth', 'icon' => '🎓', 'image' => 'https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?auto=format&fit=crop&w=600&q=80', 'description' => 'विद्यार्थीलाई संरक्षण शिक्षा'],
            ['title' => 'निती अनुगमन', 'slug' => 'forest-conservation', 'label' => 'Policy', 'icon' => '📜', 'image' => 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?auto=format&fit=crop&w=600&q=80', 'description' => 'सरकारी नीति र प्रभाव'],
            ['title' => 'संकट व्यवस्थापन', 'slug' => 'wildlife', 'label' => 'Response', 'icon' => '🚑', 'image' => 'https://images.unsplash.com/photo-1561731216-c3a4d99437d5?auto=format&fit=crop&w=600&q=80', 'description' => 'जंगली घटनामा तत्काल सहयोग'],
            ['title' => 'पर्यावरण सर्वेक्षण', 'slug' => 'environment', 'label' => 'Survey', 'icon' => '📊', 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=600&q=80', 'description' => 'डाटा आधारित संरक्षण रिपोर्ट'],
            ['title' => 'स्थानीय आवाज', 'slug' => 'community-forest', 'label' => 'Voices', 'icon' => '🗣️', 'image' => 'https://images.unsplash.com/photo-1501691223387-dd0500403074?auto=format&fit=crop&w=600&q=80', 'description' => 'समुदायका कथाहरू र अनुभव'],
        ];
    }

    public function home()
    {
        $publishedStories = News::query()
            ->with('category')
            ->where('status', 'published')
            ->latest()
            ->get();

        $fallbackNews = collect($this->newsItems());

        if ($publishedStories->isNotEmpty()) {
            $dbCards = $publishedStories->map(fn (News $story): array => $this->newsCardData($story));
            $existingSlugs = $dbCards->pluck('slug')->all();
            $mergedStories = $dbCards->concat(
                $fallbackNews->reject(fn (array $item): bool => in_array($item['slug'], $existingSlugs, true))
            )->values();

            $featuredStory = $dbCards->firstWhere('featured', true)
                ?? $dbCards->sortByDesc('views')->first()
                ?? $fallbackNews->firstWhere('featured', true);
        } else {
            $mergedStories = $fallbackNews;
            $featuredStory = $fallbackNews->firstWhere('featured', true) ?? $fallbackNews->first();
        }

        $latestStories = $mergedStories
            ->reject(fn (array $story): bool => $featuredStory !== null && $story['slug'] === $featuredStory['slug'])
            ->values();

        $featured = $featuredStory;
        $sideFeatures = $latestStories->take(3)->all();
        $latestItems = $latestStories->take(6)->all();
        $trending = $mergedStories
            ->sortByDesc('views')
            ->take(5)
            ->values()
            ->all();
        $breakingNews = $mergedStories
            ->take(5)
            ->pluck('title')
            ->all();
        $currentTime = now();
        $homeAdvertisements = Advertisement::query()
            ->where('active', true)
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $currentTime);
            })
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $currentTime);
            })
            ->latest()
            ->get()
            ->groupBy('position');

        return view('home', [
            'featured' => $featured,
            'sideFeatures' => $sideFeatures,
            'latest' => $latestItems,
            'trending' => $trending,
            'categories' => $this->homeCategoryCards($publishedStories),
            'highlights' => $this->homeHighlights(),
            'breakingNews' => $breakingNews,
            'gallery' => array_slice($this->galleryItems(), 0, 6),
            'homeAdvertisements' => $homeAdvertisements,
            'showHomepageBikramSambatDate' => SiteSetting::homepageBikramSambatDateEnabled(),
        ]);
    }

    /**
     * Convert a published database story to the card structure used by public views.
     *
     * @return array<string, mixed>
     */
    private function newsCardData(News $story): array
    {
        $categorySlug = $story->category?->slug ?? '';

        return [
            'id' => $story->id,
            'slug' => $story->slug,
            'title' => $story->title,
            'excerpt' => $story->excerpt ?? '',
            'body' => $story->content ?? '',
            'category' => $story->category?->name ?? 'Uncategorized',
            'category_slug' => $categorySlug,
            'category_icon' => $this->categoryIcon($categorySlug),
            'author' => $story->author ?? 'Editorial team',
            'published_at' => $story->created_at?->format('M d, Y') ?? '',
            'date' => $story->created_at?->format('M d, Y') ?? '',
            'reading_time' => $story->readTime(),
            'views' => (int) $story->views,
            'image' => $this->resolveStoryImage($story->image_url, $categorySlug),
            'featured' => (bool) $story->featured,
            'badge' => $story->category?->name ?? 'News',
        ];
    }

    private function resolveStoryImage(?string $imageUrl, string $categorySlug): string
    {
        if ($imageUrl && ! str_contains($imageUrl, 'fev icon.png') && ! str_contains($imageUrl, '/image/samples/')) {
            return str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://')
                ? $imageUrl
                : asset(ltrim($imageUrl, '/'));
        }

        return $this->defaultStoryImage($categorySlug);
    }

    private function defaultStoryImage(string $categorySlug): string
    {
        return match ($categorySlug) {
            'wildlife' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=1200&q=80',
            'climate', 'climate-change' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=1200&q=80',
            'environment', 'conservation' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
            'community', 'community-forest' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=1200&q=80',
            'national-park', 'tourism' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80',
            default => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1200&q=80',
        };
    }

    /**
     * @return list<array{name: string, slug: string, icon: string, count: int, image: string}>
     */
    private function homeCategoryCards(Collection $publishedStories): array
    {
        $categories = Category::query()
            ->withCount(['news as published_news_count' => fn ($query) => $query->where('status', 'published')])
            ->orderBy('name')
            ->get();

        if ($categories->isEmpty()) {
            return $this->categoryCards();
        }

        $storiesByCategory = $publishedStories->groupBy('category_id');
        $icons = [
            'forest' => '🌲',
            'forest-conservation' => '🌲',
            'wildlife' => '🦏',
            'climate' => '🌦️',
            'climate-change' => '🌦️',
            'environment' => '🌍',
            'community' => '🌱',
            'community-forest' => '🌱',
            'national-park' => '🏞️',
            'tourism' => '🏞️',
            'conservation' => '🌍',
        ];

        $defaultImages = [
            'forest' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80',
            'forest-conservation' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80',
            'wildlife' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=900&q=80',
            'environment' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80',
            'conservation' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80',
            'climate' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=900&q=80',
            'climate-change' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=900&q=80',
            'community' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=900&q=80',
            'community-forest' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=900&q=80',
            'national-park' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=80',
            'tourism' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=80',
        ];

        return $categories->map(function (Category $category) use ($storiesByCategory, $icons, $defaultImages): array {
            $categoryStories = $storiesByCategory->get($category->id, collect());
            $representativeStory = $categoryStories->sortByDesc('views')->first();

            return [
                'name' => $category->name,
                'slug' => $category->slug,
                'icon' => $icons[$category->slug] ?? '🌿',
                'count' => (int) $category->published_news_count,
                'image' => $representativeStory ? $this->resolveStoryImage($representativeStory->image_url, $category->slug) : ($defaultImages[$category->slug] ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80'),
            ];
        })->all();
    }

    private function categoryIcon(string $slug): string
    {
        return match ($slug) {
            'forest', 'forest-conservation' => '🌲',
            'wildlife' => '🦏',
            'climate', 'climate-change' => '🌦️',
            'environment', 'conservation' => '🌍',
            'community', 'community-forest' => '🌱',
            'national-park', 'tourism' => '🏞️',
            default => '🌿',
        };
    }

    public function showNews(string $slug)
    {
        $story = News::query()
            ->with('category')
            ->where('status', 'published')
            ->where('slug', $slug)
            ->first();

        if ($story) {
            $article = $this->newsCardData($story);
            $related = News::query()
                ->with('category')
                ->where('status', 'published')
                ->where('category_id', $story->category_id)
                ->whereKeyNot($story->id)
                ->latest()
                ->take(3)
                ->get()
                ->map(fn (News $relatedStory): array => $this->newsCardData($relatedStory))
                ->all();
            $mostRead = News::query()
                ->with('category')
                ->where('status', 'published')
                ->whereKeyNot($story->id)
                ->orderByDesc('views')
                ->take(6)
                ->get()
                ->map(fn (News $popularStory): array => $this->newsCardData($popularStory))
                ->all();
        } else {
            $news = $this->newsItems();
            $article = collect($news)->firstWhere('slug', $slug) ?? $news[0];
            $related = collect($news)
                ->where('category', $article['category'])
                ->reject(fn ($item) => $item['id'] === $article['id'])
                ->take(3)
                ->values()
                ->all();
            $mostRead = collect($news)
                ->reject(fn (array $item): bool => $item['slug'] === $article['slug'])
                ->sortByDesc('views')
                ->take(6)
                ->values()
                ->all();
        }

        $currentTime = now();
        $articleSidebarAdvertisements = Advertisement::query()
            ->where('position', 'sidebar')
            ->where('active', true)
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $currentTime);
            })
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $currentTime);
            })
            ->latest()
            ->get();
        $articleCenterAdvertisements = Advertisement::query()
            ->where('position', 'article-center')
            ->where('active', true)
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $currentTime);
            })
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $currentTime);
            })
            ->latest()
            ->get();
        $comments = ArticleComment::query()
            ->where('article_slug', $article['slug'])
            ->latest()
            ->get();

        return view('news.show', [
            'article' => $article,
            'related' => $related,
            'mostRead' => $mostRead,
            'articleSidebarAdvertisements' => $articleSidebarAdvertisements,
            'articleCenterAdvertisements' => $articleCenterAdvertisements,
            'comments' => $comments,
        ]);
    }

    public function storeNewsComment(Request $request, string $slug)
    {
        $isPublishedArticle = News::query()
            ->where('status', 'published')
            ->where('slug', $slug)
            ->exists();
        $isFallbackArticle = collect($this->newsItems())
            ->contains(fn (array $article): bool => $article['slug'] === $slug);

        abort_unless($isPublishedArticle || $isFallbackArticle, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        ArticleComment::create([
            'article_slug' => $slug,
            ...$validated,
        ]);

        return redirect()->to(route('news.show', $slug).'#comments')->with('success', 'Your comment has been added.');
    }

    public function search(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $category = $request->input('category', 'all');
        $normalizedQuery = strtolower($query);

        // Build a merged pool: DB published articles + static fallback items
        $publishedStories = News::query()
            ->with('category')
            ->where('status', 'published')
            ->latest()
            ->get();

        $fallbackItems = collect($this->newsItems());

        if ($publishedStories->isNotEmpty()) {
            $dbItems = $publishedStories->map(fn (News $story): array => $this->newsCardData($story));
            $existingSlugs = $dbItems->pluck('slug')->all();
            $pool = $dbItems->concat(
                $fallbackItems->reject(fn (array $item): bool => in_array($item['slug'], $existingSlugs, true))
            )->values();
        } else {
            $pool = $fallbackItems;
        }

        // Apply keyword filter
        if ($normalizedQuery !== '') {
            $pool = $pool->filter(function (array $item) use ($normalizedQuery): bool {
                $searchableText = implode(' ', [
                    $item['title'],
                    $item['excerpt'],
                    $item['category'],
                    $item['category_slug'],
                    $item['author'],
                ]);

                return str_contains(strtolower($searchableText), $normalizedQuery);
            })->values();
        }

        // Apply category filter
        if ($category !== 'all' && $category !== '') {
            $pool = $pool->filter(function (array $item) use ($category): bool {
                return $item['category'] === $category
                    || $item['category_slug'] === $category;
            })->values();
        }

        return view('search', [
            'query' => $query,
            'category' => $category,
            'results' => $pool->all(),
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
            'forest' => [
                'title' => 'वन',
                'description' => 'वन नीति, वृक्षरोपण, र राष्ट्रिय वन व्यवस्थापनका समाचार र अनुसन्धानहरू।',
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
                'hero' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1200&q=80',
            ],
            'conservation' => [
                'title' => 'संरक्षण',
                'description' => 'प्राकृतिक वासस्थान, जैविक विविधता, र वातावरणीय संरक्षणका समाचारहरू।',
                'hero' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1200&q=80',
            ],
            'climate-change' => [
                'title' => 'जलवायु परिवर्तन',
                'description' => 'जलवायु परिवर्तन, ग्लेशियर घट्ने phenomena, र जनजीवनमा असर पार्ने विषयहरू।',
                'hero' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=1200&q=80',
            ],
            'climate' => [
                'title' => 'जलवायु',
                'description' => 'जलवायु परिवर्तन र वातावरणीय प्रभावसम्बन्धी अध्ययन तथा रिपोर्टहरू।',
                'hero' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=1200&q=80',
            ],
            'community-forest' => [
                'title' => 'सामुदायिक वन',
                'description' => 'स्थानीय समुदायले नेतृत्व गरेका वन संरक्षण, वृक्षरोपण, र दिगो व्यवस्थापनका समाचारहरू।',
                'hero' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=1200&q=80',
            ],
            'community' => [
                'title' => 'समुदाय',
                'description' => 'स्थानीय समुदायको सहभागिता, संरक्षण प्रयास र सामुदायिक वनका उपलब्धि।',
                'hero' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=1200&q=80',
            ],
            'national-park' => [
                'title' => 'राष्ट्रिय निकुञ्ज',
                'description' => 'राष्ट्रिय निकुञ्ज, जैविक विविधता, वन्यजन्तु संरक्षण, र प्रकृति पर्यटनसम्बन्धी रिपोर्टहरू।',
                'hero' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80',
            ],
            'tourism' => [
                'title' => 'पर्यटन',
                'description' => 'प्रकृति पर्यटन, पदमार्ग, र पर्यापर्यटन व्यवस्थापनका ताजा समाचारहरू।',
                'hero' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        $fallbackCategory = $categories[$slug] ?? $categories['forest-conservation'];
        $databaseCategory = Category::query()->where('slug', $slug)->first();

        if ($databaseCategory) {
            $databaseStories = $databaseCategory->news()
                ->with('category')
                ->where('status', 'published')
                ->latest()
                ->get();
            $heroImage = $this->resolveStoryImage($databaseStories->sortByDesc('views')->first()?->image_url, $databaseCategory->slug);
            $dbArticles = $databaseStories->map(fn (News $story): array => $this->newsCardData($story))->all();

            $categoryData = [
                'title' => $databaseCategory->name,
                'description' => $databaseCategory->description ?: ($fallbackCategory['description'] ?? 'Latest published stories in '.$databaseCategory->name.'.'),
                'hero' => $heroImage,
            ];

            $filteredFallback = array_values(array_filter($this->newsItems(), fn ($item) => ($item['category_slug'] ?? '') === $slug || $slug === 'forest-conservation' && $item['category_slug'] === 'forest-conservation'));
            if (empty($filteredFallback)) {
                $filteredFallback = array_values(array_filter($this->newsItems(), fn ($item) => ($item['category'] ?? '') === $databaseCategory->name));
            }

            $articles = ! empty($dbArticles) ? $dbArticles : (! empty($filteredFallback) ? $filteredFallback : $this->newsItems());

            return view('category', [
                'category' => $categoryData,
                'articles' => $articles,
            ]);
        }

        $filtered = array_values(array_filter($this->newsItems(), fn ($item) => ($item['category_slug'] ?? '') === $slug || $slug === 'forest-conservation' && $item['category_slug'] === 'forest-conservation'));

        if (empty($filtered) && $slug !== 'forest-conservation') {
            $filtered = array_values(array_filter($this->newsItems(), fn ($item) => $item['category'] === $fallbackCategory['title']));
        }

        if (empty($filtered)) {
            $filtered = $this->newsItems();
        }

        return view('category', [
            'category' => $fallbackCategory,
            'articles' => $filtered,
        ]);
    }

    public function adminDashboard()
    {
        $now = now();
        $from = $now->copy()->subMonths(11)->startOfMonth();
        $monthlyRows = News::query()
            ->whereBetween('created_at', [$from, $now])
            ->selectRaw("strftime('%Y-%m', created_at) AS month_key, COUNT(*) AS article_count, COALESCE(SUM(views), 0) AS total_views")
            ->groupBy('month_key')
            ->get()
            ->keyBy('month_key');
        $monthlyNews = collect(range(0, 11))->map(function (int $offset) use ($from, $monthlyRows): array {
            $month = $from->copy()->addMonths($offset);
            $row = $monthlyRows->get($month->format('Y-m'));

            return [
                'label' => $month->format('M'),
                'articles' => (int) ($row?->article_count ?? 0),
                'views' => (int) ($row?->total_views ?? 0),
            ];
        })->all();
        $publishedToday = News::query()->where('status', 'published')->whereDate('created_at', $now->toDateString());
        $totalViews = (int) News::query()->sum('views');
        $categoryStats = Category::query()
            ->withCount(['news as published_count' => fn ($query) => $query->where('status', 'published')])
            ->withSum(['news as total_views' => fn ($query) => $query->where('status', 'published')], 'views')
            ->orderByDesc('published_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'newsCount' => News::query()->count(),
            'publishedCount' => News::query()->where('status', 'published')->count(),
            'userCount' => User::query()->count(),
            'categoryCount' => Category::query()->count(),
            'viewCount' => $totalViews,
            'publishedToday' => $publishedToday->count(),
            'todayViews' => (int) News::query()->where('status', 'published')->whereDate('created_at', $now->toDateString())->sum('views'),
            'monthlyNews' => $monthlyNews,
            'categoryStats' => $categoryStats,
            'maxMonthlyNews' => max(1, max(array_column($monthlyNews, 'articles'))),
            'maxCategoryViews' => max(1, (int) $categoryStats->max('total_views')),
            'userName' => Auth::user()->name ?? 'Admin User',
            'lastLogin' => Auth::user()?->last_login_at?->format('M d, Y, h:i A') ?? 'No record yet',
        ]);
    }

    /**
     * Columns the articles table can be sorted by. `category` and `read_time`
     * are not plain news columns, so they are resolved separately below.
     *
     * @var list<string>
     */
    private const ARTICLE_SORT_COLUMNS = ['title', 'category', 'author', 'status', 'read_time', 'views'];

    public function adminArticles()
    {
        $search = trim((string) request('search', ''));
        $categoryId = request('category_id');
        $statusFilter = (string) request('status', '');
        $authorFilter = trim((string) request('author', ''));
        $perPage = (int) request('per_page', 10);

        if (! in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        $sortKey = (string) request('sort', '');
        $sortKey = in_array($sortKey, self::ARTICLE_SORT_COLUMNS, true) ? $sortKey : '';
        $sortDirection = request('dir') === 'asc' ? 'asc' : 'desc';

        $query = News::query()->with('category')->select('news.*');

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('news.title', 'like', '%'.$search.'%')
                    ->orWhere('news.slug', 'like', '%'.$search.'%')
                    ->orWhere('news.author', 'like', '%'.$search.'%');
            });
        }

        if ($categoryId !== null && $categoryId !== '') {
            $query->where('news.category_id', $categoryId);
        }

        if (in_array($statusFilter, ['draft', 'published', 'pending'], true)) {
            $query->where('news.status', $statusFilter);
        }

        if ($authorFilter !== '') {
            $query->where('news.author', $authorFilter);
        }

        if ($sortKey === 'category') {
            $query->leftJoin('categories', 'categories.id', '=', 'news.category_id')
                ->orderBy('categories.name', $sortDirection)
                ->orderBy('news.id', 'desc');
        } elseif ($sortKey === 'read_time') {
            // Read time is derived from text length at render time, so the same
            // length expression is used to keep the SQL order consistent.
            $query->orderByRaw(
                '(LENGTH(news.title) + LENGTH(COALESCE(news.excerpt, \'\')) + LENGTH(COALESCE(news.content, \'\'))) '.$sortDirection
            )->orderBy('news.id', 'desc');
        } elseif ($sortKey !== '') {
            $query->orderBy('news.'.$sortKey, $sortDirection)->orderBy('news.id', 'desc');
        } else {
            $query->latest();
        }

        $items = $query->paginate($perPage)->withQueryString();

        $sortLinks = [];
        foreach (self::ARTICLE_SORT_COLUMNS as $column) {
            $nextDirection = ($column === $sortKey && $sortDirection === 'asc') ? 'desc' : 'asc';
            $sortLinks[$column] = request()->fullUrlWithQuery([
                'sort' => $column,
                'dir' => $nextDirection,
                'page' => null,
            ]);
        }

        $authors = News::query()
            ->whereNotNull('author')
            ->where('author', '!=', '')
            ->distinct()
            ->orderBy('author')
            ->pluck('author');

        return $this->adminSection('Articles', 'Newsroom content and publishing pipeline', [
            ['label' => 'Total articles', 'value' => (string) News::query()->count(), 'meta' => 'all time'],
            ['label' => 'Drafts', 'value' => (string) News::query()->where('status', 'draft')->count(), 'meta' => 'awaiting review'],
        ], $items, 'articles', [
            'tableColumns' => ['Thumbnail', 'Title', 'Category', 'Author', 'Status', 'Read Time', 'Views', 'Actions'],
            'categories' => Category::query()->orderBy('name')->get(),
            'authors' => $authors,
            'filters' => [
                'search' => $search,
                'category_id' => (string) $categoryId,
                'status' => $statusFilter,
                'author' => $authorFilter,
            ],
            'activeFilters' => $search !== ''
                || ($categoryId !== null && $categoryId !== '')
                || in_array($statusFilter, ['draft', 'published', 'pending'], true)
                || $authorFilter !== '',
            'sortKey' => $sortKey,
            'sortDirection' => $sortDirection,
            'sortLinks' => $sortLinks,
            'perPage' => $perPage,
        ]);
    }

    public function editArticle(int $id)
    {
        return $this->adminSection('Edit article', 'Update the story details and publishing status', [], collect(), 'article-edit', [
            'article' => News::query()->with('category')->findOrFail($id),
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function adminCategories(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);
        $items = Category::query()->withCount('news')->latest()->paginate($perPage)->withQueryString();

        return $this->adminSection('Categories', 'Editorial sections and topic coverage', [], $items, 'categories', [
            'tableColumns' => ['Name', 'News count', 'Status', 'Actions'],
        ]);
    }

    public function editCategory(int $id)
    {
        return $this->adminSection('Edit category', 'Update the category name and description', [], collect(), 'category-edit', [
            'category' => Category::query()->findOrFail($id),
        ]);
    }

    public function adminGallery(Request $request)
    {
        $requestedType = (string) request('type', '');
        $typeFilter = in_array($requestedType, self::MEDIA_TYPES, true) ? $requestedType : '';
        $perPage = $this->resolveAdminPerPage($request, 6);

        $mediaCounts = News::query()
            ->whereNotNull('image_url')
            ->selectRaw('media_type, COUNT(*) AS total')
            ->groupBy('media_type')
            ->pluck('total', 'media_type');

        $items = News::query()
            ->whereNotNull('image_url')
            ->when($typeFilter !== '', fn ($query) => $query->where('media_type', $typeFilter))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $otherMedia = (int) ($mediaCounts['audio'] ?? 0) + (int) ($mediaCounts['document'] ?? 0);

        return $this->adminSection('Gallery', 'Upload, preview, filter, and delete media', [
            ['label' => 'Photos', 'value' => (string) ($mediaCounts['image'] ?? 0), 'meta' => 'image files'],
            ['label' => 'Videos', 'value' => (string) ($mediaCounts['video'] ?? 0), 'meta' => 'video files'],
            ['label' => 'Other media', 'value' => (string) $otherMedia, 'meta' => 'audio and documents'],
        ], $items, 'gallery', [
            'tableColumns' => ['Title', 'Category', 'Image', 'Status'],
            'categories' => Category::query()->orderBy('name')->get(),
            'mediaTypes' => self::MEDIA_TYPES,
            'mediaCounts' => $mediaCounts,
            'mediaTotal' => (int) array_sum($mediaCounts->all()),
            'typeFilter' => $typeFilter,
            'filters' => ['type' => $typeFilter],
            'activeFilters' => $typeFilter !== '',
        ]);
    }

    public function adminAdvertisements(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $perPage = (int) $request->query('per_page', 10);
        $editingAdvertisement = $request->filled('edit')
            ? Advertisement::findOrFail($request->integer('edit'))
            : null;

        if (! in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        $items = Advertisement::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%'.$search.'%')
                        ->orWhere('position', 'like', '%'.$search.'%');
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn (Advertisement $advertisement): array => [
                'id' => $advertisement->id,
                'title' => $advertisement->title,
                'position' => Advertisement::POSITIONS[$advertisement->position],
                'active' => $advertisement->active,
                'starts_at' => $advertisement->starts_at?->format('Y-m-d') ?? 'Immediately',
                'ends_at' => $advertisement->ends_at?->format('Y-m-d') ?? 'No end date',
                'banner' => '/storage/'.$advertisement->banner_path,
                'click_url' => $advertisement->click_url,
            ]);

        return $this->adminSection('Advertisement', 'Promote campaigns, featured stories, and sponsor placements across the newsroom.', [], $items, 'advertisements', [
            'filters' => ['search' => $search],
            'activeFilters' => $search !== '',
            'perPage' => $perPage,
            'editingAdvertisement' => $editingAdvertisement,
        ]);
    }

    public function storeAdvertisement(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'position' => ['required', 'in:'.implode(',', array_keys(Advertisement::POSITIONS))],
            'banner' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'click_url' => ['nullable', 'url', 'max:2048'],
            'active' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'save_behavior' => ['nullable', 'in:create,another'],
        ]);

        $bannerPath = $request->file('banner')->store('advertisements', 'public');

        Advertisement::create([
            'title' => $validated['title'],
            'position' => $validated['position'],
            'banner_path' => $bannerPath,
            'click_url' => $validated['click_url'] ?? null,
            'active' => $request->boolean('active'),
            'starts_at' => isset($validated['starts_at'])
                ? Carbon::parse($validated['starts_at'])->toDateTimeString()
                : null,
            'ends_at' => isset($validated['ends_at'])
                ? Carbon::parse($validated['ends_at'])->toDateTimeString()
                : null,
        ]);

        if (($validated['save_behavior'] ?? 'create') === 'another') {
            return redirect()->route('admin.advertisements', ['create' => 1])
                ->with('success', 'Advertisement saved. You can create another.');
        }

        return redirect()->route('admin.advertisements')->with('success', 'Advertisement created.');
    }

    public function updateAdvertisement(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'position' => ['required', 'in:'.implode(',', array_keys(Advertisement::POSITIONS))],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'click_url' => ['nullable', 'url', 'max:2048'],
            'active' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        if ($request->hasFile('banner')) {
            $oldBannerPath = $advertisement->banner_path;
            $validated['banner_path'] = $request->file('banner')->store('advertisements', 'public');
            Storage::disk('public')->delete($oldBannerPath);
        }

        $advertisement->update([
            'title' => $validated['title'],
            'position' => $validated['position'],
            'banner_path' => $validated['banner_path'] ?? $advertisement->banner_path,
            'click_url' => $validated['click_url'] ?? null,
            'active' => $request->boolean('active'),
            'starts_at' => isset($validated['starts_at'])
                ? Carbon::parse($validated['starts_at'])->toDateTimeString()
                : null,
            'ends_at' => isset($validated['ends_at'])
                ? Carbon::parse($validated['ends_at'])->toDateTimeString()
                : null,
        ]);

        return redirect()->route('admin.advertisements')->with('success', 'Advertisement updated.');
    }

    public function toggleAdvertisementStatus(Advertisement $advertisement)
    {
        $advertisement->update(['active' => ! $advertisement->active]);

        return redirect()->route('admin.advertisements')->with(
            'success',
            $advertisement->active ? 'Advertisement activated.' : 'Advertisement deactivated.'
        );
    }

    public function deleteAdvertisement(Advertisement $advertisement)
    {
        Storage::disk('public')->delete($advertisement->banner_path);
        $advertisement->delete();

        return redirect()->route('admin.advertisements')->with('success', 'Advertisement deleted.');
    }

    public function adminUsers(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);

        if (! in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        $users = User::query()->latest()->paginate($perPage)->withQueryString();

        return $this->adminSection('Users', 'Registered accounts, roles, and access records', [
            ['label' => 'Total users', 'value' => (string) User::query()->count(), 'meta' => '+9% this month'],
            ['label' => 'Admins', 'value' => (string) User::query()->where('role', 'admin')->count(), 'meta' => '2 active today'],
            ['label' => 'Editors', 'value' => (string) User::query()->whereIn('role', ['editor', 'reporter'])->count(), 'meta' => '7 online now'],
        ], $users, 'users', [
            'tableColumns' => ['Name', 'Email', 'Role', 'Registered', 'Last login'],
        ]);
    }

    public function adminReports(Request $request)
    {
        $now = now();
        $from = $now->copy()->subMonths(11)->startOfMonth();
        $monthlyRows = News::query()
            ->whereBetween('created_at', [$from, $now])
            ->selectRaw("strftime('%Y-%m', created_at) AS month_key, COUNT(*) AS article_count, COALESCE(SUM(views), 0) AS total_views")
            ->groupBy('month_key')
            ->get()
            ->keyBy('month_key');
        $monthlyReports = collect(range(0, 11))->map(function (int $offset) use ($from, $monthlyRows): array {
            $month = $from->copy()->addMonths($offset);
            $row = $monthlyRows->get($month->format('Y-m'));
            $articleCount = (int) ($row?->article_count ?? 0);

            return [
                'title' => $month->format('F Y').' newsroom summary',
                'status' => 'Generated',
                'meta' => number_format($articleCount).' articles · '.number_format((int) ($row?->total_views ?? 0)).' story views',
                'articles' => $articleCount,
                'views' => (int) ($row?->total_views ?? 0),
            ];
        })->all();
        $topStories = News::query()
            ->with('category')
            ->where('status', 'published')
            ->orderByDesc('views')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();
        $topCategories = Category::query()
            ->withCount(['news as published_articles' => fn ($query) => $query->where('status', 'published')])
            ->withSum(['news as published_story_views' => fn ($query) => $query->where('status', 'published')], 'views')
            ->orderByDesc('published_story_views')
            ->take(5)
            ->get();
        $totalViews = (int) News::query()->sum('views');
        $publishedCount = News::query()->where('status', 'published')->count();
        $reportSections = [
            ['label' => 'Total story views', 'value' => number_format($totalViews), 'meta' => 'all-time article view count'],
            ['label' => 'Published articles', 'value' => number_format($publishedCount), 'meta' => 'currently published'],
            ['label' => 'Registered users', 'value' => number_format(User::query()->count()), 'meta' => 'all account roles'],
            ['label' => 'Categories', 'value' => number_format(Category::query()->count()), 'meta' => 'editorial sections'],
        ];
        $businessGrowth = [
            ['label' => 'All articles', 'value' => number_format(News::query()->count()), 'meta' => 'stored in newsroom'],
            ['label' => 'Draft articles', 'value' => number_format(News::query()->where('status', 'draft')->count()), 'meta' => 'not yet published'],
            ['label' => 'Views on new stories', 'value' => number_format((int) News::query()->where('status', 'published')->whereBetween('created_at', [$now->copy()->startOfMonth(), $now])->sum('views')), 'meta' => 'for stories published this month'],
            ['label' => 'New accounts this month', 'value' => number_format(User::query()->whereBetween('created_at', [$now->copy()->startOfMonth(), $now])->count()), 'meta' => 'created this month'],
        ];
        $items = $this->paginateArray($monthlyReports, $this->resolveAdminPerPage($request, 4));

        return $this->adminSection('Reports', 'Analytics, engagement, and summaries', $reportSections, $items, 'reports', [
            'tableColumns' => ['Report', 'Status', 'Updated'],
            'businessGrowth' => $businessGrowth,
            'maxMonthlyNews' => max(1, max(array_column($monthlyReports, 'articles'))),
            'monthlyReports' => $monthlyReports,
            'topStories' => $topStories,
            'topCategories' => $topCategories,
            'maxCategoryViews' => max(1, (int) $topCategories->max('published_story_views')),
        ]);
    }

    public function adminPassword()
    {
        $user = Auth::user();

        return $this->adminSection('Change password', 'Protect your administrator account with a new password', [], collect(), 'password', [
            'lastPasswordChanged' => $user?->password_changed_at?->format('Y-m-d H:i') ?? 'Never',
        ]);
    }

    public function adminHomepageHeader()
    {
        abort_unless(Auth::user()?->isAdmin(), 403);

        return $this->adminSection('Homepage header', 'Choose whether the homepage header shows the Bikram Sambat date or header advertisements', [], collect(), 'homepage-header', [
            'homepageBikramSambatDateEnabled' => SiteSetting::homepageBikramSambatDateEnabled(),
        ]);
    }

    public function adminAdmins(Request $request)
    {
        $perPage = $this->resolveAdminPerPage($request, 5);
        $items = User::query()
            ->whereIn('role', ['admin', 'editor', 'reporter'])
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return $this->adminSection('Create admin', 'Add administrators and editorial team accounts', [
            ['label' => 'Admin accounts', 'value' => (string) User::query()->where('role', 'admin')->count(), 'meta' => 'current admin role records'],
            ['label' => 'Editorial accounts', 'value' => (string) User::query()->whereIn('role', ['editor', 'reporter'])->count(), 'meta' => 'editors and reporters'],
        ], $items, 'admins', [
            'tableColumns' => ['Account', 'Role', 'Created', 'Last login'],
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
            'featured' => ['nullable', 'boolean'],
        ]);

        News::create([
            ...$validated,
            'featured' => $request->boolean('featured'),
            'views' => 0,
        ]);

        return redirect()->route('admin.articles')->with('success', 'Article created successfully.');
    }

    public function updateArticle(Request $request, int $id)
    {
        $article = News::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:news,slug,'.$article->id],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status' => ['required', 'in:draft,published,pending'],
            'image_url' => ['nullable', 'url'],
            'author' => ['nullable', 'string', 'max:255'],
        ]);

        $article->update([
            ...$validated,
            'featured' => $request->boolean('featured'),
        ]);

        return redirect()->back()->with('success', 'Article updated successfully.');
    }

    public function toggleArticleStatus(int $id)
    {
        $article = News::findOrFail($id);

        $article->update([
            'status' => $article->status === 'published' ? 'draft' : 'published',
        ]);

        return redirect()->back()->with('success', 'Article marked as '.$article->status.'.');
    }

    public function toggleArticleFeatured(int $id)
    {
        $article = News::findOrFail($id);

        $article->update(['featured' => ! $article->featured]);

        return redirect()->back()->with('success', $article->featured ? 'Article featured on homepage.' : 'Article removed from featured.');
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
            'media' => ['nullable', 'file', 'max:20480'],
            'image_url' => ['nullable', 'string', 'max:2048', 'url'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status' => ['nullable', 'in:draft,published,pending'],
        ], [
            'image_url.url' => 'The media URL must be a valid URL.',
            'media.file' => 'The upload must be an image, video, audio, or document file.',
            'media.max' => 'Uploaded media may not be greater than 20 MB.',
        ]);

        $file = $request->file('media');
        $mediaUrl = $validated['image_url'] ?? null;

        if (! $file && ! $mediaUrl) {
            return back()->withErrors([
                'media' => 'Choose a file to upload or paste a media URL.',
            ])->withInput();
        }

        if ($file) {
            $path = $file->store('media', 'public');

            // Store a host-independent path so uploads resolve on any host, port, or tunnel.
            $mediaUrl = '/storage/'.$path;
            $mediaType = $this->mediaTypeFromMime($file->getMimeType());
        } else {
            $mediaType = $this->mediaTypeFromUrl($mediaUrl);
        }

        unset($validated['media']);

        News::create([
            ...$validated,
            'image_url' => $mediaUrl,
            'media_type' => $mediaType,
            'status' => $validated['status'] ?? 'published',
            'views' => 0,
            'author' => Auth::user()?->name ?? 'Admin',
        ]);

        return redirect()->route('admin.gallery')->with('success', 'Media uploaded to gallery.');
    }

    public function deleteGallery(int $id)
    {
        $photo = News::findOrFail($id);
        $photo->delete();

        return redirect()->route('admin.gallery')->with('success', 'Media deleted from gallery.');
    }

    /**
     * Resolve a stored media type from the uploaded file's MIME type.
     */
    private function mediaTypeFromMime(?string $mimeType): string
    {
        $prefix = strtolower(substr((string) $mimeType, 0, 6));

        return match ($prefix) {
            'image/' => 'image',
            'video/' => 'video',
            'audio/' => 'audio',
            default => 'document',
        };
    }

    /**
     * Resolve a media type from a remote URL. Extension-less CDN links are
     * overwhelmingly images, so that is the fallback rather than "document".
     */
    private function mediaTypeFromUrl(?string $url): string
    {
        $extension = strtolower(pathinfo((string) parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));

        foreach (self::MEDIA_EXTENSIONS as $type => $extensions) {
            if (in_array($extension, $extensions, true)) {
                return $type;
            }
        }

        return 'image';
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

        return redirect()->route('admin.settings.admins')->with('success', 'Account created.');
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

        return redirect()->route('admin.settings.password')->with('success', 'Password updated.');
    }

    public function updateAdminHomepageHeader(Request $request)
    {
        abort_unless(Auth::user()?->isAdmin(), 403);

        $validated = $request->validate([
            'show_bikram_sambat_date' => ['sometimes', 'boolean'],
        ]);

        SiteSetting::query()->updateOrCreate(
            ['key' => SiteSetting::HOMEPAGE_BIKRAM_SAMBAT_DATE],
            ['value' => ($validated['show_bikram_sambat_date'] ?? false) ? '1' : '0'],
        );

        return redirect()->route('admin.settings.homepage-header')->with('success', 'Homepage header settings updated.');
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

    private function resolveAdminPerPage(Request $request, int $default): int
    {
        $perPage = (int) $request->query('per_page', $default);

        return in_array($perPage, [2, 4, 5, 6, 10, 25, 50, 100], true) ? $perPage : $default;
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
            'lastPasswordChanged' => $meta['lastPasswordChanged'] ?? 'Never',
            'businessGrowth' => $meta['businessGrowth'] ?? [],
            'categories' => $meta['categories'] ?? [],
            'authors' => $meta['authors'] ?? collect(),
            'filters' => $meta['filters'] ?? [],
            'activeFilters' => $meta['activeFilters'] ?? false,
            'sortKey' => $meta['sortKey'] ?? '',
            'sortDirection' => $meta['sortDirection'] ?? 'desc',
            'sortLinks' => $meta['sortLinks'] ?? [],
            'perPage' => $meta['perPage'] ?? 10,
            'mediaTypes' => $meta['mediaTypes'] ?? [],
            'mediaCounts' => $meta['mediaCounts'] ?? [],
            'mediaTotal' => $meta['mediaTotal'] ?? 0,
            'typeFilter' => $meta['typeFilter'] ?? '',
            'editingAdvertisement' => $meta['editingAdvertisement'] ?? null,
            'article' => $meta['article'] ?? null,
            'category' => $meta['category'] ?? null,
            'maxMonthlyNews' => $meta['maxMonthlyNews'] ?? 1,
            'monthlyReports' => $meta['monthlyReports'] ?? [],
            'topStories' => $meta['topStories'] ?? collect(),
            'topCategories' => $meta['topCategories'] ?? collect(),
            'maxCategoryViews' => $meta['maxCategoryViews'] ?? 1,
            'homepageBikramSambatDateEnabled' => $meta['homepageBikramSambatDateEnabled'] ?? true,
            'cards' => $items,
        ]);
    }
}
