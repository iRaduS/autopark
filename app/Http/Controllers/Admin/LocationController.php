<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Monitor;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index() {
        $filters = request()->all('search');
        $locations = Location::filter(request()->only('search'))->paginate();

        return Inertia::render('Admin/Locations/Locations', compact('locations', 'filters'));
    }

    public function store(Request $request) {
        try {
            Location::create($request->only('name'));
            Monitor::createLog(auth()->id(), 'a adaugat o locatie noua: ' . $request->name, $request->ip(), 4);
        } catch (\Exception $e) {
            Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Ai introdus cu succes această locație'),
        ]);
    }

    public function delete(Location $location, Request $request) {
        try {
            $location->delete();
            Monitor::createLog(auth()->id(), 'a sters o locatie din baza de date', $request->ip(), 4);
        } catch (\Exception $e) {
            Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Ai șters cu succes această locație')
        ]);
    }
}