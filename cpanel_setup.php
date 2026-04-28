<?php
// HIỂN THỊ LỖI NẾU CÓ
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>KeoHub cPanel Setup</h1>";

// KHỞI ĐỘNG LARAVEL
require __DIR__ . '/../../lichdabong/vendor/autoload.php';
$app = require_once __DIR__ . '/../../lichdabong/bootstrap/app.php';

// BÁO CHO LARAVEL BIẾT THƯ MỤC PUBLIC MỚI
$app->usePublicPath(__DIR__);

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h3>1. Running Migrations...</h3>";
try {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
} catch (\Exception $e) {
    echo "<p style='color:red;'>Lỗi Migrate: " . $e->getMessage() . "</p>";
}

echo "<h3>2. Creating Storage Link...</h3>";
try {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
} catch (\Exception $e) {
    echo "<p style='color:red;'>Lỗi Storage Link: " . $e->getMessage() . "</p>";
}

echo "<h3>3. Clearing Caches...</h3>";
try {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
} catch (\Exception $e) {
    echo "<p style='color:red;'>Lỗi Xóa Cache: " . $e->getMessage() . "</p>";
}

echo "<hr><h2 style='color:green;'>XONG! HÃY XÓA FILE NÀY ĐI ĐỂ BẢO MẬT!</h2>";
