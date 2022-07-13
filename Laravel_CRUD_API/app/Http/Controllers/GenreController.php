<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Genre;
use Illuminate\Http\Request;
use Mockery\Exception;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return response()->json(Genre::with(['movies'])->get(), 200);

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
            $genre = Genre::create($request->all());
            $genre->movies()->sync($request->movies);

            return response()->json($genre, 201);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Genre $genre)
    {
        try {

            return response()->json($genre->load('movies'), 200);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Genre $genre)
    {
        try {
            $genre->update($request->all());
            $genre->movies()->sync($request->movies);

            return response()->json($genre, 200);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Genre $genre)
    {
        $genre->movies()->sync([]);
        try {$genre->delete();

            return response()->json(['message' => 'Genre Deleted'], 205);

        } catch (Exception $exception) {

            return response()->json(['error' => $exception], 500);
        }
    }

    public function search(Request $request){

        $result = Genre::where('description', 'LIKE', '%' . $request->search . '%')->orwhere('id', 'LIKE', '%' . $request->search . '%')->get();

        if(count($result)){
            return response()->json($result);
        }
        else{
            return response()->json(['Result'=> 'Genre not Found'], 404);
        }
    }


}
