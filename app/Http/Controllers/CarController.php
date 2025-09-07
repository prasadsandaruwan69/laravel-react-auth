<?php

namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class CarController extends Controller
{

        public function GetAll()
    {
        try {
            $cars = Car::all();
            return response()->json($cars, 200);
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
            $cars = Car::all();
            return response()->json($cars, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch cars. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

 public function create(Request $request){
    $request->validate([
        'name' => 'required',
      
        'price_per_day' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('cars', 'public');
    }
       Car::create([
        'user_id'=> $request->user_id,
        'name' => $request->name,
        'type' => $request->type,
        'price_per_day' => $request->price_per_day
,
        'location' => $request->location,
        'seats' => $request->seats,
        'fuel_type' => $request->fuelType
,
        'transmission' => $request->transmission,
        'company' => $request->company,
        'phone' => $request->phone,
        'email' => $request->email,
        'status' => $request->status,
        'image' => $imagePath,
            'rating'       => $request->rating,

       ]);



 }

public function update(Request $request, $id)
{
    try {
        $car = Car::findOrFail($id);

        // Handle image update if exists
        $imagePath = $car->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
        }

        $car->update([
            'user_id'      => $request->user_id,
            'name'         => $request->name,
            'type'         => $request->type,
            'price_per_day'=> $request->price_per_day,
            'location'     => $request->location,
            'seats'        => $request->seats,
            'fuel_type'    => $request->fuelType,  // ✅ map correctly
            'transmission' => $request->transmission,
            'company'      => $request->company,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'status'       => $request->status,
            'image'        => $imagePath,
            'rating'       => $request->rating,
           
        ]);

        return response()->json([
            'message' => 'Car updated successfully!',
            'car' => $car
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to update car. Please try again.',
            'error'   => $e->getMessage()
        ], 500);
    }
}


    public function show($id)
    {
        try {
            $car = Car::findOrFail($id);
            return response()->json($car, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Car not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->delete();
            return response()->json(['message' => 'Car deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete car. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}

