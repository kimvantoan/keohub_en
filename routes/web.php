<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/match', [\App\Http\Controllers\FixturesController::class, 'index'])->name('fixtures');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/disclaimer', function () {
    return view('disclaimer');
});

Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/category/{id}/load-more', [\App\Http\Controllers\NewsController::class, 'loadMoreCategory'])->name('news.category.load_more');
Route::get('/news/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    // TODO: Actually send the email if needed in the future
    return back()->with('success', 'Thank you ' . $request->name . '! Your message has been sent successfully.');
});

// Auth Routes
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.articles.index');
    });
    Route::post('upload-image', [\App\Http\Controllers\Admin\ArticleController::class, 'uploadImage'])->name('upload_image');
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
});

// Utility Routes cho Shared Hosting (cPanel không có Terminal)
Route::get('/run-cmd/crawl', function () {
    // URL: domain.com/run-cmd/crawl?secret=lichdabong123&source=https://www.si.com/soccer/premier-league&category=Premier%20League&limit=2
    if (request('secret') !== 'lichdabong123') {
        return 'Truy cập bị từ chối!';
    }

    try {
        $source = request('source', 'https://www.si.com/soccer');
        $category = request('category', 'Bóng đá Quốc tế');
        $limit = request('limit', 2);

        \Illuminate\Support\Facades\Artisan::call('crawl:news', [
            '--source' => $source,
            '--category' => $category,
            '--limit' => $limit
        ]);

        return "Cào thành công mục {$category}! Kết quả:<br>" . nl2br(\Illuminate\Support\Facades\Artisan::output());
    } catch (\Exception $e) {
        return "Lỗi: " . $e->getMessage();
    }
});

Route::get('/run-cmd/storage-link', function () {
    if (request('secret') !== 'lichdabong123') {
        return 'Truy cập bị từ chối!';
    }

    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return "Tạo Storage Link thành công!<br>" . nl2br(\Illuminate\Support\Facades\Artisan::output());
    } catch (\Exception $e) {
        return "Lỗi: " . $e->getMessage();
    }
});
