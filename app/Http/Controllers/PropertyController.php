<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Region;
use App\Helpers\ImageHelper;
use App\Filters\PropertyFilter;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['region']);
        PropertyFilter::apply($query, $request);
        $properties = $query->get();
        return view('property.index', [
            'properties' => $properties,
            'regions' => Region::all(),
        ]);
    }

    public function create()
    {
        $regions = Region::all();
        return view('property.create', compact('regions'));
    }
    
    public function edit($id) {
        $property = Property::findOrFail($id);
        $regions = Region::all();
        return view('property.create', compact('property', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'region_id' => 'required|exists:regions,id',
        ]);

        Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'region_id' => $request->region_id,
        ]);

        return redirect()->route('property.index')->with('success', 'Property created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $property = Property::findOrFail($id);
        $property->title = $request->title;
        $property->description = $request->description;
        $property->price = $request->price;
        $property->save();

        return redirect()->route('property.index')->with('success', 'Property updated successfully.');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->back()->with('success', 'Property deleted successfully.');
    }

    public function restore($id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        $property->restore();

        return redirect()->back()->with('success', 'Property restored successfully.');
    }
}
