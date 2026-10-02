<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function fields()
    {
        return $this->hasMany(TemplateField::class);
    }

    public function itineraryBlocks()
    {
        return $this->hasMany(ItineraryBlock::class);
    }
}
