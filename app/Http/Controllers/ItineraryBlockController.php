<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\ItineraryBlock;
use Illuminate\Http\Request;

class ItineraryBlockController extends Controller
{
    public function store(Request $request, Itinerary $itinerary)
    {
        $this->own($itinerary);
        $data = $request->validate([
            'template_id' => 'required|exists:templates,id',
            'position' => 'required|integer',
        ]);

        $block = $itinerary->itineraryBlocks()->create($data);
        return $this->ok('Block added successful', [
            ...$block->only('id', 'itinerary_id', 'template_id', 'position'),
            'template' => $block->template->only('id', 'name', 'slug'),
            'fields' => $block->fields,
            ...$block->only('created_at', 'updated_at'),
        ], 201);
    }

    public function destroy(Itinerary $itinerary, ItineraryBlock $block)
    {
        $this->own($itinerary);
        $block->fieldValues()->delete();
        $block->delete();
        return $this->ok('Block removed successful');
    }

    public function reorder(Request $request, Itinerary $itinerary)
    {
        $this->own($itinerary);
        $request->validate([
            'blocks' => 'required|array',
            'blocks.*' => 'required|exists:itinerary_blocks,id',
        ]);

        foreach ($request->blocks as $i => $id) {
            $itinerary->itineraryBlocks()->findOrFail($id)->update(['position' => $i]);
        }

        return $this->ok('Blocks reordered successful');
    }
}
