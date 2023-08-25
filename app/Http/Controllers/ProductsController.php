<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return response()->json(['status' => '200', 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ProductSeriesName' => 'required',
            'ProductModel' => 'required',
            'Stock' => 'required',
            'Price' => 'required',
            'ImageUrl' => 'required|image',
            'Cpu' => 'required',
            'Memory' => 'required',
            'IntegratedGfx' => 'required',
            'Storage' => 'required',
            'ScreenSize' => 'required',
            'Resolution' => 'required',
            'RefreshRate' => 'required',
            'Color' => 'required',
            'Battery' => 'required',
            'OperatingSystem' => 'required',
            'Package' => 'required',
            'product_category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $imagePath = Str::random() . '.' . $request->ImageUrl->getClientOriginalExtension();

            Storage::putFileAs("/public/products/images", $request->ImageUrl, $imagePath, 'public');

            try {
                Products::create(
                    [
                        'ProductSeriesName' => $request->ProductSeriesName,
                        'ProductModel' => $request->ProductModel,
                        'Stock' => $request->Stock,
                        'Price' => $request->Price,
                        'Cpu' => $request->Cpu,
                        'Memory' => $request->Memory,
                        'IntegratedGfx' => $request->IntegratedGfx,
                        'Storage' => $request->Storage,
                        'ScreenSize' => $request->ScreenSize,
                        'Resolution' => $request->Resolution,
                        'RefreshRate' => $request->RefreshRate,
                        'Color' => $request->Color,
                        'Battery' => $request->Battery,
                        'OperatingSystem' => $request->OperatingSystem,
                        'Package' => $request->Package,
                        'product_category_id' => $request->product_category_id,
                    ]
                        +
                    [
                        "ImageUrl" => $imagePath
                    ]
                );
                return response()->json(
                    [
                        "Message" => "Successfully created a new product!"
                    ]
                );
            } catch (Exception $e) {
                Log::error($e->getMessage());
    
                return response()->json(
                    [
                        "Message" => $e->getMessage()
                    ]
                );
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                "Message" => "Error while creating a product!"
            ]);
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}