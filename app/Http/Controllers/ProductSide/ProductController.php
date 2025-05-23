<?php

namespace App\Http\Controllers\ProductSide;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Application\Product\ProductRegister;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{

    protected ProductRegister $productRegister;

    public function __construct(ProductRegister $productRegister)
    {
        $this->productRegister = $productRegister;
    }

    public function addProduct(Request $request)
{
    // Validate the request with trimmed data
    $validator = Validator::make($request->all(), [
        'productName' => 'required|string|max:255|unique:products,productName',
        'category' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'description' => 'required|string',
        'image' => 'required|image'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        // Generate a unique product ID
        $productId = $this->GetTheGenerateProductId();

        // Handle image upload
        $data = [];

        if ($request->file(key: 'image')) {
            $image = $request->file(key: 'image');
            $destinationPath = 'images';

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        // Insert the new product with trimmed data
        DB::table('products')->insert([
            'productId' => $productId,
            'productName' => trim($request->productName),
            'category' => trim($request->category),
            'price' => floatval($request->price),
            'stock' => intval($request->stock),
            'description' => trim($request->description),
            'image' => $data['image'],
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    } catch (\Exception $e) {
        Log::error('Product insertion failed: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Failed to add product: ' . $e->getMessage())
            ->withInput();
    }
}

    public function updateProduct(Request $request, $product_id)
    {
        $product = DB::table('products')->where('productId', $product_id)->first();
        if (!$product) {
            return redirect('/AdminLogin')->with('error', 'Product not found');
        }

       
        $validator = Validator::make($request->all(), [
            'productName' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'productName' => $request->productName,
            'category' => $request->category,
            'price' => floatval($request->price),
            'stock' => intval($request->stock),
            'description' => $request->description,
        ];

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = 'images';
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        } else {
            // Keep the existing image if no new image is uploaded
            $data['image'] = $product->image ?? 'default.jpg';
        }

        // Update the product in the database
        DB::table('products')->where('productId', $product_id)->update($data);

        return redirect()->route('dashboard')->with('success', 'Product updated successfully');
    }

    public function archiveEachProduct($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (! $product) {
            return redirect('/AdminLogin')->with('error', 'Product not found');
        }

        DB::table('products')->where('id', $id)->delete();

        DB::table('archive_products')->insert([
            'productId' => $product->productId,
            'productName' => $product->productName,
            'category' => $product->category,
            'price' => $product->price,
            'stock' => $product->stock,
            'description' => $product->description,
            'image' => $product->image,
            'created_at' => $product->created_at,
            'updated_at' => Carbon::now()->toDateString(),
        ]);

        return redirect('/dashboard')->with('success', 'Product archive successfully');
    }

    public function RestoringSpecialProduct($id)
    {
        $product = DB::table('archive_products')->where('id', $id)->first();

        if (! $product) {
            return redirect('/Archive')->with('error', 'Product not found');
        }

        DB::table('archive_products')->where('id', $id)->delete();

        DB::table('products')->insert([
           'productId' => $product->productId,
            'productName' => $product->productName,
            'category' => $product->category,
            'price' => $product->price,
            'stock' => $product->stock,
            'description' => $product->description,
            'image' => $product->image,
            'created_at' => $product->created_at,
            'updated_at' => Carbon::now()->toDateString(),
        ]);

        return redirect('/Archive')->with('success', 'Product restore successfully');
    }

    public function DeleteEachProduct($id)
    {
        $product = DB::table('archive_products')->where('id', $id)->first();

        if (! $product) {
            return redirect('/Archive')->with('error', 'Product not found');
        }

        DB::table('archive_products')->where('id', $id)->delete();

        return redirect('/Archive')->with('success', 'Product restore successfully');
    }

    public function GetTheGenerateProductId(): string
    {
        do {
            $id = $this->GenerateProductID(6);
            // Check if the generated ID already exists
            $exists = DB::table('products')->where('productId', $id)->first();
        } while ($exists !== null); // Ensure the ID is unique

        return $id;
    }

    public function GenerateProductID(int $length = 0): string
    {
        $result = substr(bin2hex(random_bytes(ceil($length / 2))), 0, $length);

        return $result;
    }

   
}