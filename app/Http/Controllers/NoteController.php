<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return  $notes = Note::all();
        return response()->json($notes);
    }

    public function store(Request $request)
    {
        $note = Note::create($request->input());
        return $note;
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $note->update($request->input());// = $request->get('title');
        $note->save();
        return $note;
    }

    public function destroy($id)
    {
        Note::destroy($id);
        return 'success';
    }

    //
}
