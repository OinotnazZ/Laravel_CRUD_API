<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Movie;
use Illuminate\Http\Request;
use Mockery\Exception;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {

            return response()->json(Movie::with(['actors', 'genres'])->get(), 200);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $movie = Movie::create($request->all());
            $movie->genres()->sync($request->genres);
            $movie->actors()->sync($request->actors);

            return response()->json($movie, 201);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Movie $movie)
    {
        try {
            return response()->json($movie->load(['actors','genres']), 200);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Movie $movie)
    {
        try {
            $movie->update($request->all());
            $movie->genres()->sync($request->genres);
            $movie->actors()->sync($request->actors);

            return response()->json($movie, 200);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Movie $movie)
    {
        $movie->genres()->sync([]);
        $movie->actors()->sync([]);
        try {$movie->delete();

            return response()->json(['message' => 'Movie Deleted'], 205);

        } catch (Exception $exception) {

            return response()->json(['error' => $exception], 500);
        }
    }

    public function search(Request $request){

        $result = Movie::where('title', 'LIKE', '%' . $request->search . '%')->orwhere('id', 'LIKE', '%' . $request->search . '%')->get();

        if(count($result)){
            return response()->json($result);
        }
        else{
            return response()->json(['Result'=> 'Movie not Found'], 404);
        }
    }
}
