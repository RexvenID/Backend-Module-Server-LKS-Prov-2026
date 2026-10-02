<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    protected $fields = ['id', 'user_id', 'title', 'slug', 'summary', 'created_at', 'updated_at'];

    public function index()
    {
        $items = Itinerary::where('user_id', auth()->id())->get()
            ->map(fn($i) => $this->pick($i, $this->fields));

        return $this->ok('Get all itineraries successful', ['itineraries' => $items]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:itineraries,slug|alpha_dash',
            'summary' => 'nullable|string',
        ]);
        $data['user_id'] = auth()->id();

        $itinerary = Itinerary::create($data);
        return $this->ok('Itinerary created successful', $this->pick($itinerary, $this->fields), 201);
    }

    public function show(Itinerary $itinerary)
    {
        $this->own($itinerary);
        return $this->ok('Get itinerary successful', $this->pick($itinerary, [...$this->fields, 'blocks']));
    }

    public function update(Request $request, Itinerary $itinerary)
    {
        $this->own($itinerary);
        $data = $request->validate([
            'title' => 'string|max:255',
            'slug' => 'string|max:255|alpha_dash|unique:itineraries,slug,' . $itinerary->id . ',id',
            'summary' => 'nullable|string',
        ]);

        $itinerary->update($data);
        return $this->ok('Itinerary updated successful', $this->pick($itinerary, $this->fields));
    }

    public function destroy(Itinerary $itinerary)
    {
        $this->own($itinerary);

        foreach ($itinerary->itineraryBlocks as $block) {
            $block->fieldValues()->delete();
            $block->delete();
        }
        $itinerary->delete();

        return $this->ok('Itinerary deleted successful');
    }
}
