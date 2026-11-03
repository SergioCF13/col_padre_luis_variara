<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\View\View;

class PublicContentController extends Controller
{
    public function show(Content $content): View
    {
        abort_unless($content->status === 'published', 404);

        return view('content.show', compact('content'));
    }
}
