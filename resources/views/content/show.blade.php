<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $content->title }} | Colegio Padre Luis Variara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite('resources/js/app.js')
    @endif
</head>
<body>
    <header class="site-header"><nav class="container navbar"><a class="brand" href="{{ route('home') }}"><span class="brand-mark"><i class="fa-solid fa-book-open"></i></span><span class="brand-copy"><strong>COLEGIO</strong><span>PADRE LUIS VARIARA</span></span></a><a class="text-link" href="{{ route('home') }}#{{ $content->type === 'news' ? 'noticias' : 'actividades' }}"><i class="fa-solid fa-arrow-left"></i> Volver al inicio</a></nav></header>
    <main class="content-detail">
        <article class="container content-detail-wrap">
            <p class="eyebrow"><span></span> {{ $content->category ?: match ($content->type) { 'news' => 'Comunicado', 'milestone' => 'Historia del colegio', 'album' => 'Galería fotográfica', default => 'Actividad' } }}</p>
            <h1>{{ $content->title }}</h1>
            <div class="content-meta">@if ($content->event_date)<span><i class="fa-regular fa-calendar"></i> {{ $content->event_date->translatedFormat('d \de F \de Y') }}</span>@endif @if ($content->event_time)<span><i class="fa-regular fa-clock"></i> {{ substr($content->event_time, 0, 5) }}</span>@endif @if ($content->place)<span><i class="fa-solid fa-location-dot"></i> {{ $content->place }}</span>@endif @if ($content->author)<span><i class="fa-regular fa-user"></i> {{ $content->author }}</span>@endif</div>
            @if ($content->image_path)<img class="content-detail-cover" src="{{ Storage::disk('public')->url($content->image_path) }}" alt="{{ $content->title }}">@endif
            @if ($content->summary)<p class="content-detail-summary">{{ $content->summary }}</p>@endif
            @if ($content->body)<div class="content-detail-body">{!! nl2br(e($content->body)) !!}</div>@endif
            @if ($content->photos)<div class="content-detail-gallery">@foreach ($content->photos as $photo)<img src="{{ Storage::disk('public')->url($photo) }}" alt="{{ $content->title }}" loading="lazy">@endforeach</div>@endif
        </article>
    </main>
    <footer class="site-footer"><div class="container footer-bottom"><span>© {{ date('Y') }} Colegio Padre Luis Variara</span><a href="{{ route('home') }}">Volver al inicio</a></div></footer>
</body>
</html>