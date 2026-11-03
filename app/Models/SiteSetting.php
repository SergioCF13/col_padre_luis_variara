<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'about_text', 'history', 'mission', 'vision', 'institutional_values', 'academic_text',
        'hero_image', 'about_image', 'address', 'phone', 'whatsapp', 'email',
        'office_hours', 'social_links',
    ];

    protected function casts(): array
    {
        return [
            'institutional_values' => 'array',
            'social_links' => 'array',
        ];
    }
}
