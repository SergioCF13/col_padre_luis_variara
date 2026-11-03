<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContentController extends Controller
{
    private const TYPES = [
        'activity' => 'Actividad',
        'news' => 'Noticia o comunicado',
        'album' => 'Álbum fotográfico',
        'milestone' => 'Hito histórico',
        'space' => 'Infraestructura',
    ];

    public function index(): View
    {
        return view('admin.contents.index', [
            'contents' => Content::query()->latest()->paginate(15),
            'types' => self::TYPES,
        ]);
    }

    public function create(): View
    {
        return view('admin.contents.form', [
            'content' => new Content,
            'types' => self::TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()->id;
        $data['author'] = ($data['author'] ?? null) ?: $request->user()->name;
        $data['featured'] = $request->boolean('featured');
        $data['image_path'] = $request->file('image')?->store('school/content', 'public');
        $data['photos'] = collect($request->file('photos', []))
            ->map(fn ($photo) => $photo->store('school/gallery', 'public'))
            ->all();

        unset($data['image']);

        Content::create($data);

        return redirect()->route('admin.contents.index')->with('status', 'Contenido creado.');
    }

    public function edit(Content $content): View
    {
        return view('admin.contents.form', [
            'content' => $content,
            'types' => self::TYPES,
        ]);
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        $data = $this->validated($request, $content);
        $data['featured'] = $request->boolean('featured');
        $data['author'] = ($data['author'] ?? null) ?: $request->user()->name;

        if ($request->hasFile('image')) {
            if ($content->image_path) {
                Storage::disk('public')->delete($content->image_path);
            }
            $data['image_path'] = $request->file('image')->store('school/content', 'public');
        }

        $photos = $content->photos ?? [];
        $removed = array_intersect($request->input('remove_photos', []), $photos);
        Storage::disk('public')->delete($removed);
        $photos = array_values(array_diff($photos, $removed));
        foreach ($request->file('photos', []) as $photo) {
            $photos[] = $photo->store('school/gallery', 'public');
        }
        $data['photos'] = $photos;

        unset($data['image']);

        $content->update($data);

        return redirect()->route('admin.contents.index')->with('status', 'Contenido actualizado.');
    }

    public function destroy(Content $content): RedirectResponse
    {
        Storage::disk('public')->delete(array_filter([$content->image_path, ...($content->photos ?? [])]));
        $content->delete();

        return redirect()->route('admin.contents.index')->with('status', 'Contenido eliminado.');
    }

    private function validated(Request $request, ?Content $content = null): array
    {
        return $request->validate([
            'type' => ['required', 'in:'.implode(',', array_keys(self::TYPES))],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string', 'max:50000'],
            'event_date' => ['required_if:type,milestone', 'nullable', 'date'],
            'event_time' => ['nullable', 'date_format:H:i'],
            'place' => ['nullable', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:120'],
            'status' => ['required', 'in:draft,published'],
            'featured' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'photos' => ['nullable', 'array', 'max:20'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_photos' => ['nullable', 'array'],
            'remove_photos.*' => ['string', 'max:255'],
        ]);
    }
}
