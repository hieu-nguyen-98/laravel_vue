<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Providers\UserServiceProvider;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

class UserController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(){
        $query = request('query');
        $users = $this->userRepository->all($query);

        // $userRoles = $this->userRepository->getNameRole($users);
        
        return $users;
    }

    public function store(UserRequest $request){
        
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        return User::create($data);
    }

    public function update(UpdateUserRequest $request, $id){
        $data = $request->all();
        if(!empty($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        $user = $this->userRepository->update($id, $request->all());

        return $user;
    }

    public function destory($id)
    {
        $user = $this->userRepository->delete($id);
        if($user){
            return response()->json('message','something went wrong!');
        }
        return response()->noContent();
    }

    public function changeRole(Request $request, $id)
    {
        $role = $this->userRepository->changeRole($request->role, $id);
        return response()->json(['success' => true]);
    }

    public function search(Request $request){
        $name = request('query');
        $user = $this->userRepository->searchByName($name);

        return response()->json($user);
    }

    public function MultipleDelete(Request $request)
    {
        $ids = $request->ids; 

        if (!empty($ids)) { 
            $this->userRepository->mulDelete($ids);
            return response()->json(['message' => 'Users deleted successfully!']);
        }

        return response()->json(['message' => 'No users to delete.']);
    }
}
