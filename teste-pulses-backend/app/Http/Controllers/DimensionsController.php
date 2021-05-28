<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\Dimension;
use App\Models\Models\Question;

class DimensionsController extends Controller
{
    public function index(){

        $dimensions = Dimension::with('questions')->get();
        return response()->json($dimensions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dimension = new Dimension();
        $dimension->name = $request->name;
        $dimension->save();

        $dimensions = Dimension::all();
        return response()->json($dimensions, 201);
    }

    public function show($id)
    {
        $dimensions = Dimension::with('questions')->get()->find($id);
        return response()->json($dimensions, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dimension = Dimension::find($id);
        $dimension->name = $request->name;
        $dimension->update();
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Question::where('dimension_id', $id)->exists()) {
            return response()->json(["message" => "Existem perguntas atreladas"], 200);
        }else{
            $dimension = Dimension::where('id', $id)->withTrashed()->first();
            $dimension->delete();

            return response()->json(["message" => "deletado"], 202);
        }
    }
}