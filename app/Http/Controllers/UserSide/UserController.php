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

             $Validator = Validator::make( $request->all(), [
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'gender' => 'required|string|in:Male,Female,Other',
                'address' => 'required|string|max:255',
                'phoneNumber' => 'required|string|regex:/^[0-9]{10,11}$/',  
                'username' => 'required|string|min:4|unique:users,username',
                'password' => 'required|min:8|string',
                'confirmPassword' => 'required|same:password',
            ]);

            $this->imageService->ensureDefaultImageExists();
            
            $imageName = $this->imageService->storeUserImage($request->file('image'));
            $userId = $this->getGenerateUserID();

            $this->registerUser->create(
                $userId,
                $request->firstName,
                $request->lastName,
                $request->gender,
                $request->address,
                $request->phoneNumber,
                $request->username,
                Hash::make($request->password),
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
            return redirect('/')->with('success', 'Login successful');
        }

        return redirect('/')
            ->withInput($request->only('username'))
            ->with('error', 'Invalid credentials');
    }

    public function UserLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function UpdateInformationUser(Request $request, string $userId): \Illuminate\Http\RedirectResponse
    {
        // Use Eloquent model instead of DB facade
        $user = DB::table('users')->where('userId', $userId)->first();
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'address' => 'required|string|max:255',
            'phoneNumber' => 'required|string|regex:/^[0-9]{10,11}$/', // Match database column name
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

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
                $request->phoneNumber, // Match the validation field name
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

    /**
     * Handle image upload and return the new image name
     */
    private function handleImageUpload($image, string $oldImage): ?string
    {
        try {
            // Ensure the storage directory exists
            Storage::disk('public')->makeDirectory('images');

            // Delete old image if it exists and is not the default
            if ($oldImage && $oldImage !== 'default.jpg') {
                Storage::disk('public')->delete('images/' . $oldImage);
            }

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Store the new image
            Storage::disk('public')->putFileAs('images', $image, $imageName);

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

    public function checkoutItems(Request $request)
    {
        // Validate the request
        $request->validate([
            'selected_items' => 'required|array',
            'total_price' => 'required|numeric'
        ]);

        $selectedItems = $request->input('selected_items');
        $totalPrice = $request->input('total_price');

        // Get the cart items that were selected
        $cartItems = DB::table('add_to_cart')
            ->whereIn('productId', $selectedItems)
            ->where('userId', Auth::user()->userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'No items selected for checkout');
        }

        return view('UserSide.Pages.CheckOut', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
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

        return view('UserSide.Pages.PurchaseHistory.Cancelled', compact('cancelledOrders'));
    }

    public function cancelOrder(Request $request, $orderId)
    {
        $order = DB::table('orders')->where('orderId', $orderId)->first();
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

    public function checkoutPreview(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'items' => 'required|array',
                'totalPrice' => 'required|numeric'
            ]);

            $items = $request->items;
            $totalPrice = $request->totalPrice;

            if (empty($items)) {
                return redirect()->back()->with('error', 'Please select items to checkout');
            }

            return view('UserSide.Pages.CheckOut', compact('items', 'totalPrice'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing checkout: ' . $e->getMessage());
        }
    }

    public function checkoutProcess(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'items' => 'required|array',
                'totalPrice' => 'required|numeric',
                'address' => 'required|string',
                'paymentMethod' => 'required|string',
                'phoneNumber' => 'required|string'
            ]);

            $items = $request->items;
            $totalPrice = $request->totalPrice;
            $userId = Auth::user()->userId;
            $firstName = Auth::user()->firstName;
            $address = $request->address;
            $paymentMethod = $request->paymentMethod;
            $phoneNumber = $request->phoneNumber;

            // Generate a unique order ID
            $orderId = 'ORD-' . uniqid();

            DB::beginTransaction();

            try {
                // Create the order header
                DB::table('orders')->insert([
                    'orderId' => $orderId,
                    'userId' => $userId,
                    'firstName' => $firstName,
                    'address' => $address,
                    'paymentMethod'=> $paymentMethod,
                    'phoneNumber' => $phoneNumber,
                    'totalAmount' => $totalPrice,
                    'orderStatus' => 'Pending',
                    'created_at' => now(),
                    'updated_at' => Carbon::now()->toDateTimeLocalString(),
                ]);

                // Insert order details for each product
                foreach ($items as $item) {
                    DB::table('order_details')->insert([
                        'orderId' => $orderId,
                        'productId' => $item['productId'],
                        'productName' => $item['productName'],
                        'category' => $item['category'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'image' => $item['image'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Update product stock
                    DB::table('products')
                        ->where('productId', $item['productId'])
                        ->decrement('stock', $item['quantity']);
                }

                // Remove items from cart
                foreach ($items as $item) {
                    DB::table('add_to_cart')
                        ->where('userId', $userId)
                        ->where('productId', $item['productId'])
                        ->delete();
                }

                DB::commit();

                // Redirect to the receipt page with order details
                return redirect()->route('user.order.receipt', ['orderId' => $orderId])
                    ->with('success', 'Order placed successfully! Your order ID is: ' . $orderId);

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Error processing your order: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error validating your order: ' . $e->getMessage());
        }
    }

    // Add this new method to display the receipt
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


