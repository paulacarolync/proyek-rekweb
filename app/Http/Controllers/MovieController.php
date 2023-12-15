<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index(){
        $data = Movie::get()->map(function ($movie) {
            $movie->formatted_duration = $movie->formattedDuration;
        return $movie;
        });
        
        return Inertia::render('CRUD/Index', compact('data'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'directors' => 'required',
            'genre' => 'required',
            'agerate' => 'required',
            'duration' => 'integer|required',
            'year' => 'integer|required',
        ]);
        
        Movie::create($validated);

        return redirect()->route('index');
    }

    public function update(Request $request, Movie $movie){
        $validated = $request->validate([
            'title' => 'required',
            'directors' => 'required',
            'genre' => 'required',
            'agerate' => 'required',
            'duration' => 'integer|required',
            'year' => 'integer|required',
        ]);
        
        $movie->update($validated);

        return redirect()->route('index');
    }

    public function destroy(Movie $movie){
        $movie->delete();
        
        return redirect()->route('index');
    }
}
