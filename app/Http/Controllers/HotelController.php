<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        try {
            $hotels = hotel::all();
            return response()->json($hotels, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch hotels. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',

            'price_per_day' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotels', 'public');
        }

        hotel::create([
            'name' => $request->name,

            'price_per_day' => $request->price_per_day,
            'location' => $request->location,


            'description' => $request->description,
            'phone' => $request->phone,
            'email' => $request->email,

            'image' => $imagePath,
            'language' => $request->language ?? 'en',
        ]);

        return response()->json(['message' => 'hotele created successfully']);
    }

    public function update(Request $request, $id)
    {
        try {
            $hotel = hotel::findOrFail($id);
            $hotel->update($request->all());
            return response()->json($hotel, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update hotel. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $hotel = hotel::findOrFail($id);
            return response()->json($hotel, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'hotel not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $hotel = hotel::findOrFail($id);
            $hotel->delete();
            return response()->json(['message' => 'hotel deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete hotel. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
