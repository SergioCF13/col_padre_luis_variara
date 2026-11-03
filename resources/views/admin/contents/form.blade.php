@extends('admin.layout')

@php($editing = $content->exists)

@section('title', $editing ? 'Editar publicación' : 'Nueva publicación')
@section('heading', $editing ? 'Editar publicación' : 'Nueva publicación')
@section('breadcrumb', $editing ? 'Editar' : 'Crear')

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('admin.contents.update', $content) : route('admin.contents.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card card-primary card-outline">
                    <div class="card-header"><h2 class="card-title">Información</h2></div>
                    <div class="card-body">
                        <div class="mb-3"><label class="form-label required" for="type">Tipo de contenido</label><select class="form-select" id="type" name="type" required>@foreach ($types as $value => $label)<option value="{{ $value }}" @selected(old('type', $content->type) === $value)>{{ $label }}</option>@endforeach</select></div>
                        <div class="mb-3"><label class="form-label required" for="title">Título</label><input class="form-control" id="title" name="title" value="{{ old('title', $content->title) }}" maxlength="255" required></div>
                        <div class="mb-3"><label class="form-label" for="category">Categoría</label><input class="form-control" id="category" name="category" value="{{ old('category', $content->category) }}" maxlength="100" placeholder="Deportes, comunicado, aniversario..."></div>
                        <div class="mb-3"><label class="form-label" for="summary">Descripción corta</label><textarea class="form-control" id="summary" name="summary" rows="2" maxlength="500">{{ old('summary', $content->summary) }}</textarea></div>
                        <div class="mb-3"><label class="form-label" for="body">Descripción completa</label><textarea class="form-control" id="body" name="body" rows="6">{{ old('body', $content->body) }}</textarea></div>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label" for="event_date">Fecha <span class="text-body-secondary">(obligatoria para hitos)</span></label><input class="form-control" type="date" id="event_date" name="event_date" value="{{ old('event_date', $content->event_date?->format('Y-m-d')) }}"></div>
                            <div class="col-md-4"><label class="form-label" for="event_time">Hora</label><input class="form-control" type="time" id="event_time" name="event_time" value="{{ old('event_time', $content->event_time ? substr($content->event_time, 0, 5) : '') }}"></div>
                            <div class="col-md-4"><label class="form-label" for="place">Lugar</label><input class="form-control" id="place" name="place" value="{{ old('place', $content->place) }}" maxlength="255"></div>
                        </div>
                        <div class="mt-3"><label class="form-label" for="author">Autor</label><input class="form-control" id="author" name="author" value="{{ old('author', $content->author) }}" maxlength="120" placeholder="Por defecto, tu nombre"></div>
                    </div>
                </div>
                <div class="card card-secondary card-outline">
                    <div class="card-header"><h2 class="card-title">Fotografías</h2></div>
                    <div class="card-body">
                        <div class="mb-3"><label class="form-label" for="image">Imagen principal</label><input class="form-control" type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"><div class="form-text">JPG, PNG o WebP. Máximo 5 MB.</div>@if ($content->image_path)<img class="mt-3 rounded" src="{{ Storage::disk('public')->url($content->image_path) }}" alt="Imagen actual" style="max-width:240px;max-height:150px;object-fit:cover">@endif</div>
                        <div class="mb-3"><label class="form-label" for="photos">Fotografías del álbum</label><input class="form-control" type="file" id="photos" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple><div class="form-text">Hasta 20 archivos por envío, máximo 5 MB cada uno.</div></div>
                        @if ($content->photos)
                            <div class="row g-2">@foreach ($content->photos as $photo)<div class="col-6 col-md-4"><img class="rounded w-100" src="{{ Storage::disk('public')->url($photo) }}" alt="Fotografía del álbum" style="height:115px;object-fit:cover"><label class="form-check mt-1"><input class="form-check-input" type="checkbox" name="remove_photos[]" value="{{ $photo }}"><span class="form-check-label">Eliminar</span></label></div>@endforeach</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header"><h2 class="card-title">Publicación</h2></div>
                    <div class="card-body">
                        <label class="form-label required" for="status">Estado</label>
                        <select class="form-select mb-3" id="status" name="status" required><option value="draft" @selected(old('status', $content->status ?: 'draft') === 'draft')>Borrador</option><option value="published" @selected(old('status', $content->status) === 'published')>Publicada</option></select>
                        <label class="form-check"><input class="form-check-input" type="checkbox" name="featured" value="1" @checked(old('featured', $content->featured))><span class="form-check-label">Destacar en el sitio</span></label>
                    </div>
                    <div class="card-footer d-flex justify-content-between"><a class="btn btn-outline-secondary" href="{{ route('admin.contents.index') }}">Cancelar</a><button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk me-1"></i> Guardar</button></div>
                </div>
            </div>
        </div>
    </form>
@endsection