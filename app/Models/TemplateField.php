<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TemplateField extends Model
{
    protected $guarded = [];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function getSlugAttribute()
    {
        return $this->attributes['name'];
    }

    public function getNameAttribute($value)
    {
        return Str::of($value)->replace(['_', '-'], ' ')->title();
    }
}
