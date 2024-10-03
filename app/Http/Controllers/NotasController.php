<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotasController extends Controller
{
    // Muestra todas las notas
    public function index()
    {
        $notas = Notas::orderBy('created_at', 'desc')->get();
        return response()->json($notas);
    }

    // Muestra una nota específica
    public function show($id)
    {
        $nota = Notas::findOrFail($id);
        return response()->json($nota);
    }

    // Crear una nueva nota
    public function store(Request $request)
    {
        // Validar los datos de la solicitud, incluyendo la imagen
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'tags' => 'nullable|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048' // Asegúrate de que el campo de imagen sea una imagen válida
        ]);

        // Subir la imagen si existe en la solicitud
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Guardar la imagen en la carpeta 'public/images' dentro de 'storage/app/public'
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Crear la nueva nota con los datos y la ruta de la imagen
        $nota = Notas::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => $request->input('user_id'),
            'tags' => $request->input('tags'),
            'due_date' => $request->input('due_date'),
            'image' => $imagePath, // Guardar la ruta de la imagen en la base de datos
        ]);

        return response()->json($nota, 201); // Código 201 indica que el recurso se ha creado
    }

    // Actualizar una nota existente
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'tags' => 'nullable|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048' 
        ]);

        
        $nota = Notas::findOrFail($id);

        
        if ($request->hasFile('image')) {
            
            if ($nota->image) {
                Storage::disk('public')->delete($nota->image);
            }

            
            $imagePath = $request->file('image')->store('images', 'public');
            $nota->image = $imagePath; 
        }

       
        $nota->update([
            'title' => $request->input('title', $nota->title),
            'description' => $request->input('description', $nota->description),
            'tags' => $request->input('tags', $nota->tags),
            'due_date' => $request->input('due_date', $nota->due_date),
        ]);

        return response()->json($nota); 
    }


    public function destroy($id)
    {
        $nota = Notas::findOrFail($id);

       
        if ($nota->image) {
            Storage::disk('public')->delete($nota->image);
        }

        $nota->delete();

        return response()->json(null, 204);
    }
}
