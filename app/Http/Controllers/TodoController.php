<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('cors');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all();
        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'completed' => 'boolean',
        ]);
        $todo = Todo::create($request->all());

        return response()->json($todo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response('Not found', 422);
        }

        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = 0)
    {
        $this->validate($request, ['completed' => 'required|boolean']);
        $todo = Todo::find($id);
        if (!$todo) {
            return response('Not found', 422);
        }

        $todo->completed = $request->get('completed');
        $todo->save();
        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = 0)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response('Not found', 422);
        }

        $todo->delete();
        return response('Deleted');
    }
}
