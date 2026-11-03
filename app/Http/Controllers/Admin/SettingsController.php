<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $settings = SiteSetting::query()->first() ?? new SiteSetting([
            'institutional_values' => ['Respeto', 'Responsabilidad', 'Solidaridad', 'Honestidad', 'Compañerismo'],
            'social_links' => [],
        ]);

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'about_text' => ['nullable', 'string', 'max:20000'],
            'history' => ['nullable', 'string', 'max:20000'],
            'mission' => ['nullable', 'string', 'max:10000'],
            'vision' => ['nullable', 'string', 'max:10000'],
            'values_text' => ['nullable', 'string', 'max:3000'],
            'academic_text' => ['nullable', 'string', 'max:10000'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'whatsapp' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
            'office_hours' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $settings = SiteSetting::query()->firstOrNew();
        foreach (['hero_image', 'about_image'] as $imageField) {
            if ($request->hasFile($imageField)) {
                if ($settings->{$imageField}) {
                    Storage::disk('public')->delete($settings->{$imageField});
                }
                $data[$imageField] = $request->file($imageField)->store('school/settings', 'public');
            } else {
                unset($data[$imageField]);
            }
        }

        $data['institutional_values'] = collect(explode("\n", $data['values_text'] ?? ''))
            ->map(fn (string $value) => trim($value))
            ->filter()
            ->values()
            ->all();
        $data['social_links'] = array_filter([
            'facebook' => $data['facebook'] ?? null,
            'instagram' => $data['instagram'] ?? null,
            'youtube' => $data['youtube'] ?? null,
        ]);
        unset($data['values_text'], $data['facebook'], $data['instagram'], $data['youtube']);

        $settings->fill($data)->save();

        return back()->with('status', 'Información institucional actualizada.');
    }
}
