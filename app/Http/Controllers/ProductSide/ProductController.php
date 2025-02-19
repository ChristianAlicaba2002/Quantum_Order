<?php

namespace App\Http\Controllers\ProductSide;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Application\Product\ProductRegister;


class ProductController extends Controller
{

    protected ProductRegister $productRegister;
    public function __construct(ProductRegister $productRegister)
    {
        $this->productRegister = $productRegister;
    }

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productName' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [];

        if ($request->file('image')) {
            $image = $request->file('image');
            $destinationPath = 'images';

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        $price = floatval($request->price);
        $stock = intval($request->stock);

        $id = $this->GetTheGenerateProductId();
        

        $this->productRegister->create(
            $id,
            $request->productName,
            $request->category,
            $price,
            $stock,
            $request->description,
            $data['image'],
        );

        return redirect('/AdminLogin')->with('success', 'Product added successfully');

    }
    public function UpdateProduct(Request $request, $id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return redirect('/AdminLogin')->with('error', 'Product not found');
        }

        Validator::make(
            $request->all(),
            [
                'productName' => 'required|string',
                'category' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'image ' => 'required|nullable',
            ]
        );

        $data = [];

        if ($request->file(key: 'image')) {
            $image = $request->file(key: 'image');
            $destinationPath = 'images';

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName; // Store the image name in the data array
        } else {
            $data['image'] = $product->image ?? 'default.jpg';
            $imageName = $data['image'];
        }

        $this->productRegister->update(
            $product->productId,
            $request->productName,
            $request->category,
            $request->description,
            $request->price,
            $request->stock,
            $imageName
        );

        return redirect('/AdminLogin')->with('success', 'Product updated successfully');
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
            'updated_at' => Carbon::now()->toDateTimeLocalString(),
        ]);

        return redirect('/AdminLogin')->with('success', 'Product archive successfully');
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
            'updated_at' => Carbon::now()->toDateTimeLocalString(),
        ]);

        return redirect('/Archive')->with('success', 'Product restore successfully');
    }

    public function GetTheGenerateProductId(): string
    {
        do {
            $id = $this->GenerateProductID(6);
            // Check if the generated ID already exists
            $exists = $this->productRegister->findByID($id);
        } while ($exists !== null); // Ensure the ID is unique

        return $id;
    }

    public function GenerateProductID(int $length = 0): string
    {
        $result = substr(bin2hex(random_bytes(ceil($length / 2))), 0, $length);

        return $result;
    }
}