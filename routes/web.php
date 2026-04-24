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

Route::get('/news', function () {
    return view('news');
});

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    // TODO: Actually send the email if needed in the future
    return back()->with('success', 'Thank you ' . $request->name . '! Your message has been sent successfully.');
});
