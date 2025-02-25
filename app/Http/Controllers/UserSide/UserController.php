<?php

namespace App\Http\Controllers\UserSide;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Application\User\UpdateUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Application\User\RegisterUser;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UserRegistrationRequest;
use App\Services\ImageService;


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

            $validator = Validator::make($request->all(), [
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'gender' => 'required|string|in:Male,Female,Other',
                'address' => 'required|string|max:255',
                'phoneNumber' => 'required|string|regex:/^[0-9]{10,11}$/',  
                'username' => 'required|string|min:4|unique:users,username',
                'password' => 'required|min:8|string',
                'confirmPassword' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return redirect('/register')
                    ->withErrors($validator)
                    ->withInput();
            }

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
        $validator = Validator::make($request->all(), [    
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt($request->only(['username', 'password']))) {
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
}
