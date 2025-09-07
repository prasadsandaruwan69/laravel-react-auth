<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
       public function GetAllHotel()
    {
        try {
            $hotels = Hotel::all();
            return response()->json($hotels, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch cars. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function index()
    {
        try {
            $hotels = Hotel::all();
            return response()->json($hotels, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch hotels. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created hotel in storage.
     */
    public function create(Request $request)
    {
        try {
            $request->validate([
             
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'price_per_day' => 'required|numeric|min:0',
                'location' => 'nullable|string|max:255',
                'number_of_rooms' => 'nullable|integer|min:1',
                'room_type' => 'nullable|string|in:Single,Double,Suite',
                'description' => 'nullable|string|max:255',
                'company' => 'nullable|string|max:255',
                                
                'amenities'=>'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'status' => 'nullable|string|in:Available,Booked,Maintenance',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'rating' => 'nullable|numeric|min:0|max:5',
                'bookings' => 'nullable|integer|min:0',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('hotels', 'public');
            }

            $hotel = Hotel::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'type' => $request->type,
                'price_per_day' => $request->price_per_day,
                'location' => $request->location,
                'number_of_rooms' => $request->number_of_rooms,
                'room_type' => $request->room_type ?? 'Single',
                'description' => $request->description,
                'amenities' => $request->amenities,
                'company' => $request->company,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => $request->status ?? 'Available',
                'image' => $imagePath,
              
              
            ]);

            return response()->json([
                'message' => 'Hotel created successfully',
                'hotel' => $hotel
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create hotel. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified hotel in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
               
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'price_per_day' => 'required|numeric|min:0',
                'location' => 'nullable|string|max:255',
                'number_of_rooms' => 'nullable|integer|min:1',
                'room_type' => 'nullable|string|in:Single,Double,Suite',
                'description' => 'nullable|string|max:255',
                'company' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'status' => 'nullable|string|in:Available,Booked,Maintenance',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'rating' => 'nullable|numeric|min:0|max:5',
                'bookings' => 'nullable|integer|min:0',
            ]);

            $hotel = Hotel::findOrFail($id);

            $imagePath = $hotel->image;
            if ($request->hasFile('image')) {
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image')->store('hotels', 'public');
            }

            $hotel->update([
                
                'name' => $request->name,
                'type' => $request->type,
                'price_per_day' => $request->price_per_day,
                'location' => $request->location,
                'number_of_rooms' => $request->number_of_rooms,
                'room_type' => $request->room_type ?? $hotel->room_type,
                'description' => $request->description,
                'company' => $request->company,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => $request->status ?? $hotel->status,
                'image' => $imagePath,
          
            ]);

            return response()->json([
                'message' => 'Hotel updated successfully',
                'hotel' => $hotel
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update hotel. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified hotel.
     */
    public function show($id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            return response()->json($hotel, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hotel not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove the specified hotel from storage.
     */
    public function destroy($id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            if ($hotel->image && Storage::disk('public')->exists($hotel->image)) {
                Storage::disk('public')->delete($hotel->image);
            }
            $hotel->delete();
            return response()->json(['message' => 'Hotel deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete hotel. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}