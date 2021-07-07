<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //rest api convention
        $response = [
            'success' => true,
            'message' => 'All Products',
            'data' => Product::all()
        ];
        return response()->json($response, 200);

        //return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);
        //return Product::create($request->all());

        //rest api convention
        $response = [
            'success' => true,
            'message' => 'Product Stored',
            'data' => Product::create($request->all())
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return Product::find($id);

        //rest api convention
        $response = [
            'success' => true,
            'message' => 'Single Product Information',
            'data' => Product::find($id)
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());

        //return $product;

        //rest api convention
        $response = [
            'success' => true,
            'message' => 'Product Updated',
            'data' => $product
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return Product::destroy($id);

        //rest api convention
        $response = [
            'success' => true,
            'message' => 'Product Deleted',
            'data' => Product::destroy($id)
        ];
        return response()->json($response, 200);
    }
    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $product = Product::where('name', 'like', '%' . $name . '%')->get();

        //rest api convention
        $response = [
            'success' => true,
            'message' => (!empty($product)) ? 'Product Found' : 'Product Not found',
            'data' => Product::where('name', 'like', '%' . $name . '%')->get()
        ];
        return response()->json($response, 200);
    }
}