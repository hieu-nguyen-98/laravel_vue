<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Api\Exception\BadRequest;

class ProfileController extends Controller
{
    protected $profileRepository;

    public function __construct(UserRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function index(Request $request){
        $profile = $this->profileRepository->showUser($request);
        return $profile;
    }

    public function update(Request $request, $id){

        $this->profileRepository->update($id, $request->all());

        return response()->json(['success' => true]);
    }

    public function changePassword(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        if (empty($data['currentPassword'])) {
            return response()->json(['message' => 'Bạn chưa nhập mật khẩu!']);
        }
        if (Hash::check($data['currentPassword'], $user->password)) {
            if ($data['password'] != $data['passwordConfirmation']) {
                return response()->json(['errors' => 'Password not same!']);
            } else {
                // Tạo một đối tượng User và gọi phương thức update trên đối tượng đó
                $user->update([
                    'password' => bcrypt($data['password'])
                ]);
                
                return $user;
            }
        }else{
            return response()->json(['message_error' => 'Mật khẩu cũ không trùng khớp!']);
        }
    }

    public function uploadImage(Request $request)
    {
        $auth = Auth::user();
        if ($request->hasFile('profile_picture')) {
            try {
                $image = $request->file('profile_picture');
                if ($image->isValid()) {
                    $uploadedFile = Cloudinary::upload($image->getRealPath(), [
                        'upload_preset' => 'my-custom-preset',
                    ]);
                    $imageUrl = $uploadedFile->getSecurePath();
                    $auth ->update(['avatar' => $imageUrl]);
        
                    return response()->json(['message' => 'Profile picture uploaded successfully!']);
                } else {
                    return response()->json(['error' => 'Invalid file.'], 400);
                }
            } catch (BadRequest $e) {
                return response()->json(['error' => 'Bad request. Please check your API request.'], 400);
            } catch (Exception $e) {
                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }
    }
}
