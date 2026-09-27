<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/news/{slug}', [PageController::class, 'showNews'])->name('news.show');
Route::get('/search', [PageController::class, 'search'])->name('search');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/support', [PageController::class, 'support'])->name('support');
Route::get('/category/{slug}', [PageController::class, 'category'])->name('category.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function () {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, request()->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid login credentials.',
            ])->withInput();
        }

        request()->session()->regenerate();

        return redirect()->route('home');
    });

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function () {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('home');
    });

    Route::get('/admin/login', function () {
        return view('admin.login');
    })->name('admin.login');

    Route::post('/admin/login', function () {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid admin credentials.',
            ]);
        }

        Auth::login($user);

        return redirect($user->isAdmin() ? route('admin.dashboard') : route('home'));
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [PageController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/articles', [PageController::class, 'adminArticles'])->name('admin.articles');
    Route::post('/admin/articles', [PageController::class, 'storeArticle'])->name('admin.articles.store');
    Route::post('/admin/articles/{id}/delete', [PageController::class, 'deleteArticle'])->name('admin.articles.delete');
    Route::get('/admin/categories', [PageController::class, 'adminCategories'])->name('admin.categories');
    Route::post('/admin/categories', [PageController::class, 'storeCategory'])->name('admin.categories.store');
    Route::post('/admin/categories/{id}/delete', [PageController::class, 'deleteCategory'])->name('admin.categories.delete');
    Route::get('/admin/gallery', [PageController::class, 'adminGallery'])->name('admin.gallery');
    Route::get('/admin/users', [PageController::class, 'adminUsers'])->name('admin.users');
    Route::get('/admin/reports', [PageController::class, 'adminReports'])->name('admin.reports');
    Route::get('/admin/settings', [PageController::class, 'adminSettings'])->name('admin.settings');
    Route::post('/admin/settings/password', [PageController::class, 'updatePassword'])->name('admin.settings.password');
    Route::post('/admin/logout', function () {
        Auth::logout();

        return redirect()->route('admin.login');
    })->name('admin.logout');
});
