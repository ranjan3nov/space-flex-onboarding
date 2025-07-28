<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Http\Resources\PropertyResource;
use App\Filters\PropertyFilter;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['region']);
        PropertyFilter::apply($query, $request);
        $properties = $query->get();
        return PropertyResource::collection($properties);
    }
}
