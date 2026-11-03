<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\SiteSetting;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $content = Schema::hasTable('contents')
            ? Content::published()->orderByDesc('featured')->latest()->get()->groupBy('type')
            : collect();
        $albums = $content['album'] ?? collect();
        /** @var FilesystemAdapter $publicDisk */
        $publicDisk = Storage::disk('public');
        $galleryImages = $albums->flatMap(fn (Content $album) => collect(array_filter([
            $album->image_path,
            ...($album->photos ?? []),
        ]))->map(fn (string $path) => [
            'src' => $publicDisk->url($path),
            'alt' => $album->title,
        ]))->take(4)->values();
        $settings = Schema::hasTable('site_settings')
            ? SiteSetting::query()->first() ?? new SiteSetting(['values' => []])
            : new SiteSetting(['values' => []]);

        return view('home', [
            'activities' => ($content['activity'] ?? collect())->take(3),
            'news' => ($content['news'] ?? collect())->take(3),
            'galleryImages' => $galleryImages,
            'milestones' => ($content['milestone'] ?? collect())
                ->filter(fn (Content $milestone) => $milestone->event_date !== null)
                ->sortBy('event_date')
                ->values(),
            'spaces' => ($content['space'] ?? collect())->take(4),
            'settings' => $settings,
        ]);
    }
}
