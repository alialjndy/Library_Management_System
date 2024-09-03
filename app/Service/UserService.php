<?php
namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService{
    public function getAllUser()
    {
        $user = User::all();
        $formattedUser = $user->map(function ($user){
            return [
                'name'=>$user->name ,
                'email'=>$user->email,
                'is_admin'=>$user->is_admin,
            ];
        });
        return $formattedUser;
    }
    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return $user ;
    }
    public function update(array $data ,$id)
    {
        $User_id = JWTAuth::user()->id;
        $user = User::findOrFail($id);
        return $user->update($data);

    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }
}
?>
