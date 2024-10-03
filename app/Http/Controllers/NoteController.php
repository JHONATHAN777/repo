<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image',
            'tags' => 'nullable|string',
        ]);

        $note = new Note($request->all());
        $note->user_id = Auth::id(); 
        $note->save();

        return response()->json($note, 201);
    }


    public function index()
    {
        $notes = Note::all(); 
        return response()->json($notes);
    }

  
    public function show($id)
    {
        $note = Note::findOrFail($id);
        if ($note->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        return response()->json($note);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image',
            'tags' => 'nullable|string',
        ]);

        $note = Note::findOrFail($id);
        if ($note->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $note->update($request->all());
        return response()->json($note);
    }


    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        if ($note->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $note->delete();
        return response()->json(null, 204);
    }
}
