<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockFieldValue extends Model
{
    protected $guarded = [];

    public function itineraryBlock()
    {
        return $this->belongsTo(ItineraryBlock::class);
    }

    public function templateField()
    {
        return $this->belongsTo(TemplateField::class);
    }
}
