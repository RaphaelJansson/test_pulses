<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\Question;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question();
        $question->text = $request->text;
        $question->dimension_id = $request->dimension_id;
        $question->save();

        return response()->json($question, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        return response()->json($question, 201);
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
        $question = Question::find($id);
        $question->text = $request->text;
        $question->dimension_id = $request->dimension_id;
        $question->show = $request->show;
        $question->update();
        return response()->json($question, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Question::where('id', $id)->exists()) {
            $question = Question::where('id', $id)->withTrashed()->first();
            $question->delete();

            return response()->json(["message" => "deletado"], 202);
          }
    }
}
