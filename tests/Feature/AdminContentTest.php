<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_administration_requires_an_authenticated_user(): void
    {
        $this->get(route('admin.contents.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_seeded_administrator_can_log_in(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->post(route('admin.login.store'), [
            'email' => 'admin@colegio.test',
            'password' => 'Variara2026!',
        ])->assertRedirect(route('admin.contents.index'));

        $this->assertAuthenticated();
        $this->assertTrue(Auth::user()->is_admin);
    }

    public function test_regular_users_cannot_open_the_admin_panel(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => false]))
            ->get(route('admin.contents.index'))
            ->assertForbidden();
    }

    public function test_only_published_content_is_shown_on_the_public_homepage(): void
    {
        Storage::fake('public');
        $jpgPath = 'school/content/aviso.jpg';
        $pngPath = 'school/content/actividad.png';
        Storage::disk('public')->put($jpgPath, 'jpg image fixture');
        Storage::disk('public')->put($pngPath, 'png image fixture');

        Content::create(['type' => 'news', 'title' => 'Aviso público de prueba', 'image_path' => $jpgPath, 'status' => 'published']);
        Content::create(['type' => 'news', 'title' => 'Borrador privado de prueba', 'status' => 'draft']);
        Content::create(['type' => 'activity', 'title' => 'Actividad con PNG', 'image_path' => $pngPath, 'status' => 'published']);
        Content::create(['type' => 'album', 'title' => 'Álbum con JPG y PNG', 'image_path' => $jpgPath, 'photos' => [$pngPath], 'status' => 'published']);
        Content::create(['type' => 'milestone', 'title' => 'Fundación del colegio', 'event_date' => '2001-01-01', 'status' => 'published']);
        Content::create(['type' => 'space', 'title' => 'Laboratorio de ciencias', 'image_path' => $jpgPath, 'status' => 'published']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Aviso público de prueba')
            ->assertSee($jpgPath)
            ->assertSee($pngPath)
            ->assertSee('Fundación del colegio')
            ->assertSee('Laboratorio de ciencias')
            ->assertSee('Álbum con JPG y PNG')
            ->assertDontSee('Borrador privado de prueba');
    }

    public function test_admin_can_publish_content_with_a_storage_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $image = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/RZsAAAAASUVORK5CYII=');

        $this->actingAs($admin)->post(route('admin.contents.store'), [
            'type' => 'activity',
            'title' => 'Feria científica',
            'category' => 'Académica',
            'summary' => 'Proyectos de estudiantes.',
            'status' => 'published',
            'featured' => '1',
            'image' => UploadedFile::fake()->createWithContent('feria.png', $image),
            'photos' => [UploadedFile::fake()->createWithContent('proyecto.png', $image)],
        ])->assertRedirect(route('admin.contents.index'));

        $content = Content::query()->where('title', 'Feria científica')->firstOrFail();

        $this->assertSame('published', $content->status);
        $this->assertTrue($content->featured);
        $this->assertTrue(Storage::disk('public')->exists($content->image_path));
        $this->assertTrue(Storage::disk('public')->exists($content->photos[0]));
    }

    public function test_admin_can_open_content_and_settings_screens(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.contents.index'))
            ->assertOk()
            ->assertSee('Actividades, noticias y álbumes');

        $this->get(route('admin.contents.create'))
            ->assertOk()
            ->assertSee('Fotografías del álbum');

        $this->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertSee('Historia del colegio');
    }

    public function test_admin_can_update_institutional_settings_and_hero_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $image = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/RZsAAAAASUVORK5CYII=');

        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'about_text' => 'Comunidad educativa de prueba.',
            'history' => 'Historia institucional de prueba.',
            'mission' => 'Misión actualizada.',
            'vision' => 'Visión actualizada.',
            'values_text' => "Respeto\nServicio\nSolidaridad",
            'academic_text' => 'Niveles educativos de prueba.',
            'address' => 'Calle de prueba 123',
            'phone' => '5551234',
            'whatsapp' => '59170000000',
            'email' => 'contacto@example.edu',
            'office_hours' => 'Lunes a viernes',
            'facebook' => 'https://facebook.com/colegio',
            'hero_image' => UploadedFile::fake()->createWithContent('hero.png', $image),
        ])->assertRedirect();

        $settings = SiteSetting::query()->firstOrFail();
        $this->assertSame(['Respeto', 'Servicio', 'Solidaridad'], $settings->institutional_values);
        $this->assertSame('https://facebook.com/colegio', $settings->social_links['facebook']);
        $this->assertTrue(Storage::disk('public')->exists($settings->hero_image));

        $this->get('/')->assertSee('Misión actualizada.')->assertSee('contacto@example.edu');
    }

    public function test_unpublished_content_detail_returns_not_found(): void
    {
        $draft = Content::create(['type' => 'news', 'title' => 'Borrador', 'status' => 'draft']);

        $this->get(route('content.show', $draft))->assertNotFound();
    }
}
