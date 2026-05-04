<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Lên lịch cào 20 bài 1 ngày, chia đều cho các chuyên mục và rải rác các khung giờ để web luôn có tin mới
Schedule::command('crawl:news --source=https://www.si.com/soccer/premier-league --category="Premier League" --limit=5')->dailyAt('06:00');
Schedule::command('crawl:news --source=https://www.si.com/soccer/transfers --category="Chuyển Nhượng" --limit=5')->dailyAt('12:00');
Schedule::command('crawl:news --source=https://www.si.com/soccer/champions-league --category="Champions League" --limit=5')->dailyAt('18:00');
Schedule::command('crawl:news --source=https://www.si.com/soccer --category="Bóng đá Quốc tế" --limit=5')->dailyAt('22:00');
