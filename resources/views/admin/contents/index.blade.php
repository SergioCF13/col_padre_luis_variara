@extends('admin.layout')

@section('title', 'Contenido del sitio')
@section('heading', 'Contenido del sitio')
@section('breadcrumb', 'Contenido')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title">Actividades, noticias y álbumes</h2>
            <a href="{{ route('admin.contents.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Nueva publicación</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Publicación</th><th>Tipo</th><th>Fecha</th><th>Estado</th><th>Destacada</th><th class="text-end">Acciones</th></tr></thead>
                    <tbody>
                    @forelse ($contents as $content)
                        <tr>
                            <td><strong>{{ $content->title }}</strong><div class="small text-body-secondary">{{ $content->category }}</div></td>
                            <td>{{ $types[$content->type] ?? $content->type }}</td>
                            <td>{{ $content->event_date?->format('d/m/Y') ?? $content->created_at->format('d/m/Y') }}</td>
                            <td><span class="badge {{ $content->status === 'published' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $content->status === 'published' ? 'Publicada' : 'Borrador' }}</span></td>
                            <td>{{ $content->featured ? 'Sí' : 'No' }}</td>
                            <td class="text-end text-nowrap">
                                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.contents.edit', $content) }}" aria-label="Editar {{ $content->title }}"><i class="fa-solid fa-pen"></i></a>
                                <form class="d-inline" method="POST" action="{{ route('admin.contents.destroy', $content) }}" onsubmit="return confirm('¿Eliminar esta publicación y sus fotografías?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" type="submit" aria-label="Eliminar {{ $content->title }}"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="py-5 text-center text-body-secondary" colspan="6">Todavía no hay contenido. Crea la primera publicación.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($contents->hasPages())<div class="card-footer">{{ $contents->links() }}</div>@endif
    </div>
@endsection