<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#142c36">
    <meta name="description" content="Colegio Padre Luis Variara: educación, valores y comunidad para construir un mejor futuro.">
    <title>Colegio Padre Luis Variara | Educación con propósito</title>
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
<body class="no-js">
    <div class="utility-bar">
        <div class="container utility-inner">
            <span><i class="fa-regular fa-envelope"></i> Comunidad educativa Padre Luis Variara</span>
            <a href="{{ $settings->whatsapp ? 'https://wa.me/'.preg_replace('/\D+/', '', $settings->whatsapp) : '#contacto' }}" @if ($settings->whatsapp) target="_blank" rel="noopener" @endif><i class="fa-brands fa-whatsapp"></i> Escríbenos</a>
        </div>
    </div>
    <header class="site-header">
        <nav class="container navbar navbar-expand-lg" aria-label="Navegación principal">
            <a class="brand" href="#inicio" aria-label="Colegio Padre Luis Variara, inicio">
                <span class="brand-mark"><i class="fa-solid fa-book-open"></i></span>
                <span class="brand-copy"><strong>COLEGIO</strong><span>PADRE LUIS VARIARA</span></span>
            </a>
            <button class="nav-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" data-nav-toggle>
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="nav-links" data-nav-menu>
                <a href="#inicio">Inicio</a>
                <a href="#nosotros">Sobre nosotros</a>
                <a href="#actividades">Actividades</a>
                <a href="#noticias">Noticias</a>
                <a href="#galeria">Galería</a>
                <a href="#contacto">Contacto</a>
                <a class="nav-whatsapp" href="{{ $settings->whatsapp ? 'https://wa.me/'.preg_replace('/\D+/', '', $settings->whatsapp) : '#contacto' }}" @if ($settings->whatsapp) target="_blank" rel="noopener" @endif><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero" id="inicio">
            <img class="hero-photo" src="{{ $settings->hero_image ? Storage::disk('public')->url($settings->hero_image) : 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=2200&q=85' }}" alt="Estudiantes aprendiendo juntos en el aula">
            <div class="hero-shade"></div>
            <div class="container hero-content">
                <p class="eyebrow hero-eyebrow"><span></span> Educación que inspira</p>
                <h1>Colegio<br>Padre Luis <em>Variara</em></h1>
                <p class="hero-lead">Formando estudiantes con valores, conocimientos y compromiso para construir un mejor futuro.</p>
                <div class="hero-actions">
                    <a class="button button-lime" href="#nosotros">Conócenos <i class="fa-solid fa-arrow-right"></i></a>
                    <a class="button button-outline" href="#actividades">Ver actividades</a>
                </div>
            </div>
            <div class="hero-caption"><span>Aprender</span><span class="caption-line"></span><span>Crecer</span><span class="caption-line"></span><span>Servir</span></div>
            <a class="hero-scroll" href="#nosotros" aria-label="Desplazarse a Sobre nosotros"><i class="fa-solid fa-arrow-down"></i></a>
        </section>

        <section class="intro-section section-pad" id="nosotros">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 reveal">
                        <div class="photo-stack">
                            <img class="intro-photo" src="{{ $settings->about_image ? Storage::disk('public')->url($settings->about_image) : 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=1100&q=85' }}" alt="Docente acompaña a sus estudiantes en el aula" loading="lazy">
                            <div class="photo-note"><span class="note-icon"><i class="fa-solid fa-seedling"></i></span><span><b>Crecer juntos</b><small>Una comunidad que acompaña</small></span></div>
                            <span class="photo-index">01 / 04</span>
                        </div>
                    </div>
                    <div class="col-lg-6 reveal">
                        <p class="eyebrow"><span></span> Nuestra comunidad</p>
                        <h2 class="section-title">Aprender para<br><em>transformar.</em></h2>
                        <p class="intro-copy">{{ $settings->about_text ?: 'En el Colegio Padre Luis Variara, cada estudiante encuentra un espacio para descubrir sus capacidades, aprender con curiosidad y crecer junto a los demás.' }}</p>
                        <p class="muted-copy">Acompañamos la formación académica y humana con una educación cercana, comprometida con los valores y abierta a los desafíos del futuro.</p>
                        <a class="text-link" href="#historia">Conoce nuestra historia <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="history-section" id="historia">
            <div class="container history-wrap reveal">
                <p class="eyebrow"><span></span> Nuestra historia</p>
                <h2 class="section-title">Un camino que<br><em>seguimos construyendo.</em></h2>
                <p>{{ $settings->history ?: 'La historia y los acontecimientos importantes del colegio estarán disponibles próximamente.' }}</p>
                @if ($milestones->isNotEmpty())
                    <div class="history-timeline">
                        @foreach ($milestones as $milestone)
                            <article class="history-milestone"><time datetime="{{ $milestone->event_date?->format('Y-m-d') }}">{{ $milestone->event_date?->format('Y') }}</time><div><h3>{{ $milestone->title }}</h3><p>{{ $milestone->summary ?: $milestone->body }}</p></div></article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="values-section" id="principios">
            <div class="container values-wrap">
                <div class="values-heading reveal">
                    <p class="eyebrow eyebrow-light"><span></span> Lo que nos guía</p>
                    <h2>Una educación<br>con <em>sentido.</em></h2>
                    <p>Conocimiento, valores y servicio se encuentran en cada paso de nuestro camino educativo.</p>
                </div>
                <div class="values-grid">
                    <article class="value-item reveal"><span class="value-number">01</span><i class="fa-solid fa-compass"></i><h3>Misión</h3><p>{{ $settings->mission ?: 'Formar personas íntegras, con pensamiento crítico y vocación de servicio.' }}</p></article>
                    <article class="value-item reveal"><span class="value-number">02</span><i class="fa-solid fa-binoculars"></i><h3>Visión</h3><p>{{ $settings->vision ?: 'Ser una comunidad educativa que inspira y abre caminos para el futuro.' }}</p></article>
                    <article class="value-item reveal"><span class="value-number">03</span><i class="fa-solid fa-hand-holding-heart"></i><h3>Valores</h3><p>{{ implode(' · ', $settings->institutional_values ?: ['Respeto', 'Responsabilidad', 'Solidaridad', 'Honestidad', 'Compañerismo']) }}</p></article>
                </div>
            </div>
        </section>

        <section class="activities-section section-pad" id="actividades">
            <div class="container">
                <div class="section-heading reveal">
                    <div><p class="eyebrow"><span></span> Vida escolar</p><h2 class="section-title">Aprendemos <em>haciendo.</em></h2></div>
                    <a class="text-link" href="#contacto">Todas las actividades <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="activity-grid">
                    @forelse ($activities as $activity)
                        <article class="activity-card {{ $loop->first ? 'activity-feature' : '' }} reveal">
                            @if ($activity->image_path)<img src="{{ Storage::disk('public')->url($activity->image_path) }}" alt="{{ $activity->title }}" loading="lazy">@endif
                            <div class="activity-overlay"><span class="tag">{{ $activity->category ?: 'Actividad' }}</span><h3>{{ $activity->title }}</h3><p>@if ($activity->event_date){{ $activity->event_date->format('d/m/Y') }}@endif @if ($activity->event_time)· {{ substr($activity->event_time, 0, 5) }}@endif @if ($activity->place)· {{ $activity->place }}@endif</p><p>{{ $activity->summary }}</p><a class="activity-more" href="{{ route('content.show', $activity) }}">Ver más <i class="fa-solid fa-arrow-right"></i></a></div>
                        </article>
                    @empty
                        <p class="content-empty">Pronto compartiremos aquí las próximas actividades del colegio.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="news-section" id="noticias">
            <div class="container news-wrap">
                <div class="news-intro reveal"><p class="eyebrow eyebrow-light"><span></span> Al día</p><h2>Lo que pasa<br>en nuestro <em>colegio.</em></h2><p>Noticias, avisos y momentos importantes de nuestra comunidad educativa.</p><a class="button button-outline" href="#contacto">Ver comunicados <i class="fa-solid fa-arrow-right"></i></a></div>
                <div class="news-list">
                    @forelse ($news as $item)
                        <article class="news-item {{ $item->image_path ? 'has-image' : '' }} reveal"><span class="news-date"><b>{{ $item->event_date?->format('d') ?? $item->created_at->format('d') }}</b><small>{{ $item->event_date?->translatedFormat('M Y') ?? $item->created_at->translatedFormat('M Y') }}</small></span>@if ($item->image_path)<img class="news-thumb" src="{{ Storage::disk('public')->url($item->image_path) }}" alt="{{ $item->title }}" loading="lazy">@endif<div><span class="news-type">{{ $item->category ?: 'Comunicado' }}</span><h3><a href="{{ route('content.show', $item) }}">{{ $item->title }}</a></h3><p>{{ $item->summary }}</p><a class="news-more" href="{{ route('content.show', $item) }}">Leer comunicado <i class="fa-solid fa-arrow-right"></i></a></div><i class="fa-solid fa-arrow-up-right-from-square"></i></article>
                    @empty
                        <p class="content-empty content-empty-light">Próximamente compartiremos noticias y comunicados del colegio.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="gallery-section section-pad" id="galeria">
            <div class="container">
                <div class="section-heading reveal"><div><p class="eyebrow"><span></span> Recuerdos compartidos</p><h2 class="section-title">Así se vive <em>Variara.</em></h2></div><span class="gallery-caption">Una comunidad, muchas historias.</span></div>
                <div class="gallery-grid">
                    @forelse ($galleryImages as $photo)
                        <button class="gallery-image {{ $loop->first ? 'gallery-tall' : '' }} {{ $loop->last && $loop->count > 2 ? 'gallery-wide' : '' }} reveal" type="button" data-lightbox="{{ $photo['src'] }}" aria-label="Ampliar fotografía: {{ $photo['alt'] }}"><img src="{{ $photo['src'] }}" alt="{{ $photo['alt'] }}" loading="lazy"><span><i class="fa-solid fa-plus"></i></span></button>
                    @empty
                        <p class="content-empty">La galería se actualizará con fotografías de nuestras actividades.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="academic-section" id="academica">
            <div class="container academic-wrap reveal">
                <div><p class="eyebrow eyebrow-light"><span></span> Formación integral</p><h2>Preparados para<br>lo que <em>viene.</em></h2></div>
                <p>{{ $settings->academic_text ?: 'Una experiencia educativa que une conocimientos, creatividad y valores. Muy pronto encontrarás aquí información sobre nuestros niveles, áreas de formación y proyectos educativos.' }}</p>
                <a class="round-link" href="#contacto" aria-label="Consultar información académica"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
        </section>

        <section class="infrastructure-section section-pad" id="infraestructura">
            <div class="container">
                <div class="section-heading reveal"><div><p class="eyebrow"><span></span> Nuestros espacios</p><h2 class="section-title">Lugares para <em>crecer.</em></h2></div></div>
                <div class="infrastructure-grid">
                    @forelse ($spaces as $space)
                        <article class="infrastructure-item reveal">
                            @if ($space->image_path)<img src="{{ Storage::disk('public')->url($space->image_path) }}" alt="{{ $space->title }}" loading="lazy">@endif
                            <div><span class="news-type">{{ $space->category ?: 'Infraestructura' }}</span><h3>{{ $space->title }}</h3><p>{{ $space->summary ?: $space->body }}</p></div>
                        </article>
                    @empty
                        <p class="content-empty">La información y fotografías de nuestros espacios se publicarán próximamente.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="contact-section section-pad" id="contacto">
            <div class="container contact-wrap">
                <div class="contact-copy reveal"><p class="eyebrow"><span></span> Estamos para escucharte</p><h2 class="section-title">Hablemos de<br><em>tu futuro.</em></h2><p>Para consultas sobre admisiones, actividades o información institucional, ponte en contacto con nuestra comunidad educativa.</p><a class="button button-dark" href="{{ $settings->whatsapp ? 'https://wa.me/'.preg_replace('/\D+/', '', $settings->whatsapp) : '#contacto' }}" @if ($settings->whatsapp) target="_blank" rel="noopener" @endif><i class="fa-brands fa-whatsapp"></i> Contáctanos por WhatsApp</a></div>
                <div class="contact-details reveal"><div class="contact-detail"><span><i class="fa-solid fa-location-dot"></i></span><div><small>VISÍTANOS</small><p>{{ $settings->address ?: 'Dirección próximamente' }}</p></div></div><div class="contact-detail"><span><i class="fa-regular fa-clock"></i></span><div><small>ATENCIÓN</small><p>{{ $settings->office_hours ?: 'Horario de atención próximamente' }}</p></div></div><div class="contact-detail"><span><i class="fa-regular fa-envelope"></i></span><div><small>CONTÁCTANOS</small><p>@if ($settings->email)<a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>@elseif ($settings->phone){{ $settings->phone }}@else Información de contacto próximamente @endif</p></div></div></div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-main"><a class="brand footer-brand" href="#inicio"><span class="brand-mark"><i class="fa-solid fa-book-open"></i></span><span class="brand-copy"><strong>COLEGIO</strong><span>PADRE LUIS VARIARA</span></span></a><p>Formación con valores. Comunidad para toda la vida.</p><div class="footer-social"><a href="{{ $settings->whatsapp ? 'https://wa.me/'.preg_replace('/\D+/', '', $settings->whatsapp) : '#contacto' }}" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>@foreach (['facebook' => 'facebook-f', 'instagram' => 'instagram', 'youtube' => 'youtube'] as $network => $icon)@if (!empty($settings->social_links[$network]))<a href="{{ $settings->social_links[$network] }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($network) }}"><i class="fa-brands fa-{{ $icon }}"></i></a>@endif @endforeach</div></div>
        <div class="container footer-bottom"><span>© {{ date('Y') }} Colegio Padre Luis Variara</span><a href="#inicio">Volver arriba <i class="fa-solid fa-arrow-up"></i></a></div>
    </footer>

    <div class="lightbox" data-lightbox-dialog role="dialog" aria-modal="true" aria-label="Vista ampliada de fotografía" hidden><button type="button" class="lightbox-close" data-lightbox-close aria-label="Cerrar fotografía"><i class="fa-solid fa-xmark"></i></button><img src="" alt="" data-lightbox-image></div>
</body>
</html>