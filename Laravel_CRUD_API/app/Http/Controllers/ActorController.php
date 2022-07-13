<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;
use Mockery\Exception;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return response()->json(Actor::with(['movies'])->get(), 200);

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
            $actor = Actor::create($request->all());
            $actor->movies()->sync($request->movies);

            return response()->json($actor->load('movies'), 201);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\JsonResponse
     */

    public function show(Actor $actor)
    {
        try {

            return response()->json($actor->load('movies'), 200);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Actor $actor)
    {
        try {
            $actor->update($request->all());
            $actor->movies()->sync($request->movies);

            return response()->json($actor, 200);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Actor $actor)
    {
        $actor->movies()->sync([]);
        try {$actor->delete();

            return response()->json(['message' => 'Actor Deleted'], 205);

        } catch (Exception $exception) {

            return response()->json(['error' => $exception], 500);
        }
    }

    public function search(Request $request){

        $result = Actor::where('name', 'LIKE', '%' . $request->search . '%')->orwhere('id', 'LIKE', '%' . $request->search . '%')->get();

        if(count($result)){
            return response()->json($result);
        }
        else{
            return response()->json(['Result'=> 'Actor not Found'], 404);
        }
    }

}
