<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::orderBy('name')->paginate(10);
        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:locations,name']);
        Location::create($request->all());
        return redirect()->route('locations.index')->with('success', 'Location created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate(['name' => 'required|string|unique:locations,name,'.$location->id]);
        $location->update($request->all());
        return redirect()->route('locations.index')->with('success', 'Location updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        // need to be careful with the location destroy here. some measures
        // need to be put in place to prevent this when associated with logs
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location deleted.');
    }
}
