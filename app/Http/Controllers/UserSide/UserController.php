<?php

namespace App\Http\Controllers\UserSide;

use App\Models\CheckOut;
use App\Models\AddtoCart;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Application\User\RegisterUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\Products;

class UserController extends Controller
{
    
    protected RegisterUser  $registerUser;
    protected ImageService $imageService;

    public function __construct(
        RegisterUser $registerUser,
        ImageService $imageService
    )
    {
        $this->registerUser = $registerUser;
        $this->imageService = $imageService;
    }


    protected $signature = 'app:ensure-default-image';
    protected $description = 'Ensures default.jpg exists in the public images directory';


    public function userRegister(UserRegistrationRequest $request)
    {
        try {
            $trimmedData = array_map('trim', $request->all());

             $Validator = Validator::make($trimmedData, [
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'gender' => 'required|string|in:Male,Female,Other',
                'address' => 'required|string|max:255',
                'phoneNumber' => 'required|string|regex:/^[0-9]{10,11}$/',  
                'username' => 'required|string|min:4|unique:users,username',
                'password' => 'required|min:8|string',
                'confirmPassword' => 'required|same:password',
            ]);

            if(DB::table('users')->where('username', $request->username)->exists())
            {
                return redirect('/Register')->with('error', 'username already exists');
            }

            $this->imageService->ensureDefaultImageExists();
            
            $imageName = $this->imageService->storeUserImage($request->file('image'));
            $userId = $this->getGenerateUserID();

            $this->registerUser->create(
                $userId,
                $trimmedData['firstName'],
                $trimmedData['lastName'],
                $trimmedData['gender'],
                $trimmedData['address'],
                $trimmedData['phoneNumber'],
                $trimmedData['username'],
                Hash::make($trimmedData['password']),
                $imageName
            );        

            return redirect('/')->with('success', 'Registration successful!');

        } catch (\Exception $e) {
            Log::error('User registration failed: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }

    private function getGenerateUserID(): string
    {
        do {
            $userId = $this->generateRandomUserID(6);
            $exists = $this->registerUser->findById( $userId);
        } while ($exists);

        return $userId;
    }

    private function generateRandomUserID(int $length = 10): string
    {
        $result = substr(bin2hex(random_bytes(ceil($length / 2))), 0, $length);

        return $result;
    }

    public function userLogin(Request $request): \Illuminate\Http\RedirectResponse
    {
        Validator::make($request->all(), [    
            'username' => 'required|string',
            'password' => 'required|string',
        ]);


        if(empty($request->username) && empty($request->password)  )
        {
            return redirect('/')->with('isEmpty','All fields are required');
        }
        
        if(empty($request->username))
        {
            return redirect('/')->with('isUsernameEmpty','Username is missing');
        }

        if(empty($request->password))
        {
            return redirect('/')->with('isPasswordEmpty','Password is missing');
        }

        if (Auth::attempt($request->only(['username', 'password']))) 
        {
            $request->session()->regenerate();
            return redirect()->route('HomePage')->with('success', 'Login successful');
        }

        return redirect('/')
            ->withInput($request->only('username'))
            ->with('error', 'Invalid credentials');
    }

    public function UserLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login');
    }

    public function UpdateInformationUser(Request $request, string $userId): \Illuminate\Http\RedirectResponse
    {
        // $user = DB::table('users')->where('userId', $userId)->first();
        $user = DB::table('users')->where('userId', $userId)->first();

        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:255',
            'phoneNumber' => 'required|string',
            'image' => 'nullable|image'
        ]);

        // dd($request->file('image'));


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $imageName = $user->image; // Default to current image

            if ($request->hasFile('image')) {
                // Handle image upload
                $imageName = $this->handleImageUpload($request->file('image'), $user->image);
                if (is_null($imageName)) {
                    return redirect()
                        ->back()
                        ->with('error', 'Failed to upload image. Please try again.')
                        ->withInput();
                }
            }


            // Update user information
            $this->registerUser->update(
                $userId,
                $request->firstName,
                $request->lastName,
                $request->gender,
                $request->address,
                $request->phoneNumber,
                $user->username,
                $user->password,
                $imageName
            );

            return redirect('/UserInformationPage')
                ->with('success', 'Profile updated successfully');

        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Failed to update profile. Please try again.')
                ->withInput();
        }
    }

    private function handleImageUpload($image, string $oldImage): ?string
    {
        try {
            // Ensure the storage directory exists
            Storage::disk('public')->makeDirectory('images');

            // Delete old image if it exists and is not the default
            if ($oldImage && $oldImage !== 'default.jpg') {
                Storage::disk('public')->delete('images/' . $oldImage);
            }

            // Log the original file name and size
            Log::info('Uploading image: ' . $image->getClientOriginalName() . ' with size: ' . $image->getSize());

            // Check if the image is valid
            if (!$image->isValid()) {
                Log::error('Uploaded image is not valid.');
                return null;
            }

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Store the new image
            Storage::disk('public')->putFileAs('images', $image, $imageName);

            Log::info('Image uploaded successfully: ' . $imageName);
            return $imageName;

        } catch (\Exception $e) {
            Log::error('Image upload failed: ' . $e->getMessage());
            return null;
        }
    }



    public function UserAddToCart(Request $request, string $productId)
    {
        $product = DB::table('products')->where('productId', $productId)->first();
        if (!$product) {
            return redirect('/')->with('error', 'Product not found');
        }

        $validator = Validator::make($request->all(), [
            'productId' => 'required|string|exists:products,productId',
            'productName' => 'required|string|exists:products,productName',
            'category' => 'required|string|exists:products,category',
            'price' => 'required|integer|exists:products,price',
            'stock' => 'required|integer|exists:products,stock',
            'quantity' => 'required|integer',
            'description' => 'required|string|exists:products,description',
            'image' => 'required|string|exists:products,image',
            'userId' => 'required|string|exists:users,userId',
            'username' => 'required|string|exists:users,username',
        ]);

        if ($validator->fails()) {
            return redirect('/MainPage')->with('error', $validator->errors()->first());
        }

        $existingCartItem = AddtoCart::where('productId', $request->productId)
            ->where('userId', $request->userId)
            ->first();

        if ($existingCartItem) {
            if ($request->has('confirm') && $request->confirm === 'yes') {
                $existingCartItem->quantity += $request->quantity;
                $existingCartItem->save();
                return redirect('/MainPage')->with('success', 'Product quantity updated in cart');
            } else {
                // Store the form data in session
                session([
                    'lastFormData' => [
                        'action' => route('addtocart', ['id' => $productId]),
                        'fields' => $request->except(['_token', 'confirm'])
                    ]
                ]);
                
                return redirect('/MainPage')->with([
                    'info' => 'Product already in your cart, do you want to add more?',
                    'confirm' => true
                ]);
            }
        }

        AddtoCart::create(attributes: $request->except('_token'));
        return redirect('/MainPage')->with('success', 'Added to cart successfully');
    }

    public function checkoutPreview(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'selectedItems' => 'required|string',
                'totalPrice' => 'required|numeric|min:0'
            ]);

            // Decode the JSON string back to array
            $items = json_decode($request->selectedItems, true);
            
            if (empty($items)) {
                return redirect()->back()
                    ->with('error', 'Please select items to checkout');
            }

            // Store in session for the checkout view
            session([
                'items' => $items,
                'totalPrice' => $request->totalPrice
            ]);

            return view('UserSide.Pages.CheckOut')
                ->with('items', $items)
                ->with('totalPrice', $request->totalPrice);
            
        } catch (\Exception $e) {
            Log::error('Checkout preview error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error processing checkout: ' . $e->getMessage());
        }
    }

    public function checkoutProcess(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'items' => 'required|string',
                'totalPrice' => 'required|numeric|min:0',
                'address' => 'required|string',
                'paymentMethod' => 'required|string',
                'phoneNumber' => 'required|string'
            ]);

            $items = json_decode($request->items, true);

            if (empty($items)) {
                return redirect()->back()->with('error', 'No items found for checkout.');
            }

            $userId = Auth::user()->userId;
            $firstName = Auth::user()->firstName;
            $address = $request->address;
            $paymentMethod = $request->paymentMethod;
            $phoneNumber = $request->phoneNumber;

            $orderId = 'ORD-' . $this->GetTheGenerateOrderId();

            DB::beginTransaction();

            try {
                DB::table('orders')->insert([
                    'orderId' => $orderId,
                    'userId' => $userId,
                    'firstName' => $firstName,
                    'address' => $address,
                    'paymentMethod'=> $paymentMethod,
                    'phoneNumber' => $phoneNumber,
                    'totalAmount' => $request->totalPrice,
                    'orderStatus' => 'Pending',
                    'created_at' => Carbon::now()->toDateTimeLocalString(),
                    'updated_at' => Carbon::now()->toDateTimeLocalString(),
                ]);

                foreach ($items as $item) {
                    DB::table('order_details')->insert([
                        'orderId' => $orderId,
                        'productId' => $item['productId'],
                        'productName' => $item['productName'],
                        'category' => $item['category'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'image' => $item['image'],
                        'created_at' => Carbon::now()->toDateTimeLocalString(),
                        'updated_at' => Carbon::now()->toDateTimeLocalString()
                    ]);

                    DB::table('products')
                        ->where('productId', $item['productId'])
                        ->decrement('stock', $item['quantity']);
                }

                foreach ($items as $item) {
                    DB::table('add_to_cart')
                        ->where('userId', $userId)
                        ->where('productId', $item['productId'])
                        ->delete();
                }

                DB::commit();

                return redirect()->route('user.order.receipt', ['orderId' => $orderId])
                    ->with('success', 'Order placed successfully! Your order ID is: ' . $orderId);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error processing order: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Error processing your order: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error validating your order: ' . $e->getMessage());
        }
    }

    
    public function UserRemoveItemFromAddtoCart(string $productId)
    {
        $product = DB::table('add_to_cart')->where('productId', $productId)->first();

        if (!$product) {
            return redirect('/MainPage')->with('error', 'Product not found in cart');
        }

        try {
            DB::table('add_to_cart')->where('productId', $productId)->delete();
            return redirect('/MainPage')->with('success', 'Product removed from cart successfully');
        } catch (\Exception $e) {
            return redirect('/MainPage')->with('error', 'Failed to remove product from cart. Please try again.');
        }
    }


    public function toPayHistory()
    {
        $userId = Auth::user()->userId;
        
        // Get pending/to pay orders
        $toPayOrders = DB::table('orders')
            ->join('order_details', 'orders.orderId', '=', 'order_details.orderId')
            ->where('orders.userId', $userId)
            ->where('orders.orderStatus', 'Pending')
            ->select('orders.*', 'order_details.*')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('UserSide.Pages.PurchaseHistory.ToPay', compact('toPayOrders'));
    }


    public function DeliveryHIstory()
    {
        $userId = Auth::user()->userId;
        
        // Get accepted/received orders
        $deliveryOrders = DB::table('orders')
            ->join('order_details', 'orders.orderId', '=', 'order_details.orderId')
            ->where('orders.userId', $userId)
            ->where('orders.orderStatus', 'Accepted')
            ->select('orders.*', 'order_details.*')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('UserSide.Pages.PurchaseHistory.Delivery', compact('deliveryOrders'));
    }

    public function MoveToRecieved(Request $request, $id)
    {
        // First get the order
        $order = DB::table('orders')->where('orderId', $id)->first();
        if(!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        // Get the order details which contain product information
        $orderDetails = DB::table('order_details')
            ->where('orderId', $id)
            ->first();
        
        if(!$orderDetails) {
            return redirect()->back()->with('error', 'Order details not found');
        }

        try {
            $receivedOrder = DB::table('delivered_items')->insert([
                'orderId' => $order->orderId,
                'productId' => $orderDetails->productId,
                'productName' => $orderDetails->productName,
                'category' => $orderDetails->category,
                'quantity' => $orderDetails->quantity,
                'price' => $orderDetails->price,
                'image' => $orderDetails->image,
                'orderStatus' => 'Delivered',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update the status in orders table
            DB::table('orders')
                ->where('orderId', $id)
                ->update([
                    'orderStatus' => 'Delivered',
                    'updated_at' => now()
                ]);

            return view('UserSide.Pages.PurchaseHistory.Received', compact('receivedOrders'))->with('success', 'Order marked as received successfully');

        } catch (\Exception $e) {
            Log::error('Error moving order to received: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to mark order as received. Please try again.');
        }
    }

    public function receivedHistory()
    {
        $userId = Auth::user()->userId;
        
        // Get accepted/received orders
        $receivedOrders = DB::table('delivered_items')->get();

        return view('UserSide.Pages.PurchaseHistory.Received', compact('receivedOrders'));
    }

    public function cancelledHistory()
    {
        $userId = Auth::user()->userId;
        
        // Get declined/cancelled orders
        $cancelledOrders = DB::table('orders')
            ->join('order_details', 'orders.orderId', '=', 'order_details.orderId')
            ->where('orders.userId', $userId)
            ->where('orders.orderStatus', 'Declined')
            ->select('orders.*', 'order_details.*')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('UserSide.Pages.PurchaseHistory.Cancelled', compact('cancelledOrders'))
        ->with('success', 'Order cancelled successfully');
    }

    public function cancelOrder(Request $request, $orderId)
    {
        $order = DB::table('orders')->where('orderId' , $orderId)
        ->first();
        if(!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        try {
            DB::table('orders')->where('orderId', $orderId)->update([
                'orderStatus' => 'Declined',
                'updated_at' => now()
            ]);

            return redirect()->back()->with('success', 'Order cancelled successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }


    public function GetTheGenerateOrderId(): string
    {
        do {
            $id = $this->GenerateProductID(6);
            // Check if the generated ID already exists
            $exists = DB::table('orders')->where('orderid', $id)->first();
        } while ($exists !== null); // Ensure the ID is unique

        return $id;
    }

    public function GenerateProductID(int $length = 0): string
    {
        $result = substr(bin2hex(random_bytes(ceil($length / 2))), 0, $length);

        return $result;
    }

    public function reorderCancelled($orderId)
    {
        try {
            // Get the order details
            $order = DB::table('orders')
                ->where('orders.orderId', $orderId)
                ->where('orders.userId', Auth::user()->userId)
                ->join('products', 'orders.productId', '=', 'products.productId')
                ->select(
                    'orders.*',
                    'products.stock',
                    'products.status as productStatus'
                )
                ->first();

            if (!$order) {
                return redirect()->back()->with('error', 'Order not found');
            }

            // Check if product is available and has stock
            if ($order->productStatus !== 'active' || $order->stock < $order->quantity) {
                return redirect()->back()
                    ->with('error', 'Product is not available or insufficient stock');
            }

            // Prepare checkout data
            $items = [[
                'productId' => $order->productId,
                'productName' => $order->productName,
                'category' => $order->category,
                'quantity' => $order->quantity,
                'price' => $order->price,
                'image' => $order->image,
                'stock' => $order->stock
            ]];

            // Store in session for checkout
            session([
                'checkout_items' => $items,
                'totalPrice' => $order->quantity * $order->price
            ]);

            // Update original order status
            DB::table('orders')
                ->where('orderId', $orderId)
                ->update([
                    'orderStatus' => 'Reordered',
                    'updated_at' => Carbon::now()->toDateTimeLocalString()
                ]);

            // Redirect to checkout preview
            return redirect()->route('checkout.preview')
                ->with('success', 'Order has been restored for checkout');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to process reorder. Please try again.');
        }
    }

    public function showOrderReceipt($orderId)
    {
        try {
            // Get order details
            $order = DB::table('orders')
                ->where('orderId', $orderId)
                ->first();
            
            if (!$order) {
                return redirect('/')->with('error', 'Order not found');
            }
            
            // Get order items
            $orderItems = DB::table('order_details')
                ->where('orderId', $orderId)
                ->get();
            
            return view('UserSide.Pages.UserOrderReceipt', compact('order', 'orderItems'));
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error retrieving order details: ' . $e->getMessage());
        }
    }

   
}