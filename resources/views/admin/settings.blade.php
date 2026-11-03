@extends('admin.layout')

@section('title', 'Información institucional')
@section('heading', 'Información institucional')
@section('breadcrumb', 'Información institucional')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card card-primary card-outline">
                    <div class="card-header"><h2 class="card-title">Identidad y formación</h2></div>
                    <div class="card-body">
                        <div class="mb-3"><label class="form-label" for="about_text">Reseña institucional</label><textarea class="form-control" id="about_text" name="about_text" rows="4">{{ old('about_text', $settings->about_text) }}</textarea></div>
                        <div class="mb-3"><label class="form-label" for="history">Historia del colegio</label><textarea class="form-control" id="history" name="history" rows="6">{{ old('history', $settings->history) }}</textarea></div>
                        <div class="row g-3 mb-3"><div class="col-md-6"><label class="form-label" for="mission">Misión</label><textarea class="form-control" id="mission" name="mission" rows="4">{{ old('mission', $settings->mission) }}</textarea></div><div class="col-md-6"><label class="form-label" for="vision">Visión</label><textarea class="form-control" id="vision" name="vision" rows="4">{{ old('vision', $settings->vision) }}</textarea></div></div>
                        <div class="mb-3"><label class="form-label" for="values_text">Valores institucionales</label><textarea class="form-control" id="values_text" name="values_text" rows="5">{{ old('values_text', implode("\n", $settings->institutional_values ?? [])) }}</textarea><div class="form-text">Escribe un valor por línea.</div></div>
                        <div><label class="form-label" for="academic_text">Información académica</label><textarea class="form-control" id="academic_text" name="academic_text" rows="4">{{ old('academic_text', $settings->academic_text) }}</textarea></div>
                    </div>
                </div>
                <div class="card card-secondary card-outline">
                    <div class="card-header"><h2 class="card-title">Contacto y redes</h2></div>
                    <div class="card-body">
                        <div class="mb-3"><label class="form-label" for="address">Dirección</label><input class="form-control" id="address" name="address" value="{{ old('address', $settings->address) }}" maxlength="255"></div>
                        <div class="row g-3 mb-3"><div class="col-md-6"><label class="form-label" for="phone">Teléfono</label><input class="form-control" id="phone" name="phone" value="{{ old('phone', $settings->phone) }}" maxlength="40"></div><div class="col-md-6"><label class="form-label" for="whatsapp">WhatsApp</label><input class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $settings->whatsapp) }}" maxlength="40" placeholder="Código de país y número"></div></div>
                        <div class="row g-3 mb-3"><div class="col-md-6"><label class="form-label" for="email">Correo electrónico</label><input class="form-control" type="email" id="email" name="email" value="{{ old('email', $settings->email) }}" maxlength="255"></div><div class="col-md-6"><label class="form-label" for="office_hours">Horario de atención</label><input class="form-control" id="office_hours" name="office_hours" value="{{ old('office_hours', $settings->office_hours) }}" maxlength="255"></div></div>
                        <div class="row g-3"><div class="col-md-4"><label class="form-label" for="facebook">Facebook</label><input class="form-control" type="url" id="facebook" name="facebook" value="{{ old('facebook', $settings->social_links['facebook'] ?? '') }}"></div><div class="col-md-4"><label class="form-label" for="instagram">Instagram</label><input class="form-control" type="url" id="instagram" name="instagram" value="{{ old('instagram', $settings->social_links['instagram'] ?? '') }}"></div><div class="col-md-4"><label class="form-label" for="youtube">YouTube</label><input class="form-control" type="url" id="youtube" name="youtube" value="{{ old('youtube', $settings->social_links['youtube'] ?? '') }}"></div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header"><h2 class="card-title">Fotografías</h2></div>
                    <div class="card-body">
                        <div class="mb-4"><label class="form-label" for="hero_image">Fotografía principal</label><input class="form-control" type="file" id="hero_image" name="hero_image" accept="image/jpeg,image/png,image/webp"><div class="form-text">JPG, PNG o WebP. Máximo 5 MB.</div>@if ($settings->hero_image)<img class="mt-3 w-100 rounded" src="{{ Storage::disk('public')->url($settings->hero_image) }}" alt="Fotografía principal actual">@endif</div>
                        <div><label class="form-label" for="about_image">Fotografía institucional</label><input class="form-control" type="file" id="about_image" name="about_image" accept="image/jpeg,image/png,image/webp"><div class="form-text">JPG, PNG o WebP. Máximo 5 MB.</div>@if ($settings->about_image)<img class="mt-3 w-100 rounded" src="{{ Storage::disk('public')->url($settings->about_image) }}" alt="Fotografía institucional actual">@endif</div>
                    </div>
                    <div class="card-footer"><button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk me-1"></i> Guardar cambios</button></div>
                </div>
            </div>
        </div>
    </form>
@endsection