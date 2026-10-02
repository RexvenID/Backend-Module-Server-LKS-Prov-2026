<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\ItineraryBlock;
use Illuminate\Http\Request;

class BlockFieldValueController extends Controller
{
    public function store(Request $request, Itinerary $itinerary, ItineraryBlock $itineraryBlock)
    {
        $this->own($itinerary);
        $request->validate([
            'fields' => 'required|array',
            'fields.*.field_id' => 'integer|exists:template_fields,id',
            'fields.*.value' => 'string|nullable',
        ]);

        foreach ($request->fields as $f) {
            $itineraryBlock->fieldValues()->updateOrCreate(
                ['template_field_id' => $f['field_id']],
                ['value' => $f['value']]
            );
        }

        return $this->ok('Block fields updated successful', [
            ...$itineraryBlock->only('id', 'itinerary_id', 'template_id', 'position'),
            'fields' => $itineraryBlock->fresh()->fields,
        ]);
    }
}
