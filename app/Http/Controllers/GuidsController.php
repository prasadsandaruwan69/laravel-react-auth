<?php

namespace App\Http\Controllers;
use App\Models\Guid; // Ensure the model is correctly imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuidsController extends Controller
{
      public function index()
    {
        try {
            $guids = guid::all();
            return response()->json($guids, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch guids. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
public function create(Request $request)
{
 $request->validate([
        'name' => 'required',
        'language' => 'required',
        'price_per_day' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('guides', 'public');
    }

    Guid::create([
        'name' => $request->name,
        'language' => $request->language,
        'price_per_day' => $request->price_per_day,
        'location' => $request->location,
        'experience' => $request->experience,
        'specialties' => $request->specialties,
        'description' => $request->description,
        'phone' => $request->phone,
        'email' => $request->email,
        'workhours' => $request->workhours,
        'image' => $imagePath,
        
    ]);

    return response()->json(['message' => 'Guide created successfully']);
}

   public function update(Request $request, $id)
    {
        try {
            $guid = guid::findOrFail($id);
            $guid->update($request->all());
            return response()->json($guid, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update guid. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $guid = guid::findOrFail($id);
            return response()->json($guid, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'guid not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $guid = guid::findOrFail($id);
            $guid->delete();
            return response()->json(['message' => 'guid deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete guid. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
