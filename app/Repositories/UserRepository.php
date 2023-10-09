<?php
namespace App\Repositories;

use App\Models\User;
use App\Enums\TypePaginate;

class UserRepository implements BaseRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        $perPage = TypePaginate::TEN;
        return User::query()
        ->when(request('query'), function ($query, $searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%");
        })
        ->latest()
        ->paginate($perPage);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
    }

    // public function getNameRole($users){
    //     $userRoles = [];
    //     foreach ($users as $key => $user) {
    //         $userRoles[] = [
    //             'id' => $user->id,
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             'created_at' => $user->created_at,
    //             'role' => $user->role->key, // Access the enum key directly
    //         ];
    //     }
    //     return $userRoles;
    // }

    public function changeRole($role, $id){
        $user = $this->user->find($id);
        if (!$user) {
            return null; 
        }
        $user->update([
            'role' => $role
        ]);

        return $user;
    }

    public function searchByName($name)
    {
        $user = $this->user->where('name', 'like', "%{$name}%")->get();
        return $user;
    }

    public function mulDelete($ids){
        return $this->user->whereIn('id', $ids)->delete();
    }

    public function showUser($request){
        $profile = $request->user()->only(['id','name', 'email', 'role', 'avatar']);
        return $profile;
    }
    
}