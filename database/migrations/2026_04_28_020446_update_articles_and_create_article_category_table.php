<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Bỏ qua lỗi xóa khóa ngoại nếu máy chủ cPanel (MyISAM) không hỗ trợ
        try {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE articles DROP FOREIGN KEY articles_category_id_foreign');
        } catch (\Exception $e) {
            // Bỏ qua
        }

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });

        Schema::create('article_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_category');

        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        });
    }
};
