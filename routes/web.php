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

        return redirect()->route('admin.dashboard');
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

        return redirect()->route('admin.dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [PageController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', function () {
        Auth::logout();

        return redirect()->route('admin.login');
    })->name('admin.logout');
});
