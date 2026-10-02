<?php

namespace App\Http\Controllers;

use App\Models\Template;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::with('fields')->get()->map(fn($t) => $this->serialize($t));
        return $this->ok('Get all templates successful', ['templates' => $templates]);
    }

    public function show(Template $template)
    {
        return $this->ok('Get template successful', $this->serialize($template));
    }

    protected function serialize(Template $t)
    {
        return [
            ...$t->only('id', 'name', 'slug'),
            'fields' => $t->fields->map(fn($f) => $f->only('id', 'template_id', 'name', 'slug', 'type')),
        ];
    }
}
