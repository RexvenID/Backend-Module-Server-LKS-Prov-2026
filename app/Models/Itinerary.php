<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $guarded = [];
    protected $appends = ['blocks'];

    public function getBlocksAttribute()
    {
        return $this->itineraryBlocks()->with('fieldValues', 'template.fields')->get()
            ->map(fn($b) => [
                ...$b->only('id', 'position'),
                'template' => $b->template->only('id', 'name', 'slug'),
                'fields' => $b->fields,
            ]);
    }

    public function itineraryBlocks()
    {
        return $this->hasMany(ItineraryBlock::class)->orderBy('position');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
