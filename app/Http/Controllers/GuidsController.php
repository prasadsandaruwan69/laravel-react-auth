<?php

namespace App\Http\Controllers;

use App\Models\Guid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuidsController extends Controller
{
    // public function index()
    // {
    //     try {
    //         $guids = Guid::all();
    //         return response()->json($guids, 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Failed to fetch guides. Please try again.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
public function index(Request $request)
{
    try {
        $user = $request->user();

        if ($user->role === 'admin') {
            // Admin → see all guides
            $guids = Guid::all();
        } else {
            // Normal user → see only own guides
            $guids = Guid::where('user_id', $user->id)->get();
        }

        return response()->json($guids, 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to fetch guides. Please try again.',
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function create(Request $request)
    {
        try {
            $request->validate([
               
                'name' => 'required|string|max:255',
                'language' => 'required|string|max:255',
                'price_per_day' => 'required|numeric',
                'location' => 'nullable|string|max:255',
                'experience' => 'nullable|numeric',
                'specialties' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'workhours' => 'nullable|string|in:Available,Rented,Maintenance',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'rating' => 'nullable|numeric|min:0|max:5',
                'bookings' => 'nullable|integer|min:0',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('guides', 'public');
            }

            $guid = Guid::create([
                'user_id' => $request->user()->id,
                'name' => $request->name,
                'language' => $request->language,
                'price_per_day' => $request->price_per_day,
                'location' => $request->location,
                'experience' => $request->experience,
                'specialties' => $request->specialties,
                'description' => $request->description,
                'phone' => $request->phone,
                'email' => $request->email,
                'workhours' => $request->workhours ?? 'Available',
                'image' => $imagePath,
                'rating' => $request->rating ?? 4.5,
                'bookings' => $request->bookings ?? 0,
            ]);

            return response()->json([
                'message' => 'Guide created successfully',
                'guid' => $guid
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create guide. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
              
                'name' => 'required|string|max:255',
                'language' => 'required|string|max:255',
                'price_per_day' => 'required|numeric',
                'location' => 'nullable|string|max:255',
                'experience' => 'nullable|numeric',
                'specialties' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'workhours' => 'nullable|string|in:Available,Rented,Maintenance',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'rating' => 'nullable|numeric|min:0|max:5',
                'bookings' => 'nullable|integer|min:0',
            ]);

            $guid = Guid::findOrFail($id);

            $imagePath = $guid->image;
            if ($request->hasFile('image')) {
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image')->store('guides', 'public');
            }

            $guid->update([
              
                'name' => $request->name,
                'language' => $request->language,
                'price_per_day' => $request->price_per_day,
                'location' => $request->location,
                'experience' => $request->experience,
                'specialties' => $request->specialties,
                'description' => $request->description,
                'phone' => $request->phone,
                'email' => $request->email,
                'workhours' => $request->workhours ?? $guid->workhours,
                'image' => $imagePath,
               
            ]);

            return response()->json([
                'message' => 'Guide updated successfully!',
                'guid' => $guid
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update guide. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $guid = Guid::findOrFail($id);
            return response()->json($guid, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Guide not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $guid = Guid::findOrFail($id);
            if ($guid->image && Storage::disk('public')->exists($guid->image)) {
                Storage::disk('public')->delete($guid->image);
            }
            $guid->delete();
            return response()->json(['message' => 'Guide deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete guide. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}