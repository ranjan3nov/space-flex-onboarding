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
        $property = Property::find($id);
        $regions = Region::all();
        return view('property.create', compact('property', 'regions'));
    }

    public function store(Request $request)
    {

        $id = $request->input('id');
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string',
            'region_id' => 'required|exists:regions,id',
            'status' => 'required|string|max:255',
        ];

        if ($id) {
            $rules['featured_image'] = 'nullable|image';
        } else {
            $rules['featured_image'] = 'required|image';
        }
        $validated = $request->validate($rules);

        if ($id) {
            $property = Property::findOrFail($id);
            $property->fill($validated);
            if ($request->hasFile('featured_image')) {
                $property->featured_image = ImageHelper::upload($request->file('featured_image'), 'images/properties');
            }
            $property->save();
            $msg = 'Property updated successfully.';
        } else {
            $data = $validated;
            $data['featured_image'] = ImageHelper::upload($request->file('featured_image'), 'images/properties');
            Property::create($data);
            $msg = 'Property created successfully.';
        }

        return redirect()->route('property.index')->with('success', $msg);
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
