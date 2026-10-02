<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryBlock extends Model
{
    protected $guarded = [];
    protected $appends = ['fields'];

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function fieldValues()
    {
        return $this->hasMany(BlockFieldValue::class);
    }

    public function getFieldsAttribute()
    {
        return $this->template->fields->map(fn($f) => [
            ...$f->only('id', 'name', 'slug', 'type'),
            'value' => $this->fieldValues->firstWhere('template_field_id', $f->id)?->value,
        ]);
    }
}
