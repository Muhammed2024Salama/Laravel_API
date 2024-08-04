<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//Route::get('/setup', function () {
//    $credentials = [
//        'email' => 'admin@admin.com',
//        'password' => 'password'
//    ];
//
////    $user = User::query()->where('email', $credentials['email'])->first();
////
////    \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password);
////
////    Auth::login($user);
//
//
//    if (!Auth::attempt($credentials)) {
//        $user = new User();
//
//        $user->name = 'Admin';
//        $user->email = $credentials['email'];
//        $user->password = Hash::make($credentials['password']);
//
//        $user->save();
//
//        if (Auth::attempt($credentials)) {
//            $user = Auth::user();
//
//            $adminToken = $user->createToken('admin-token', ['create','update','delete']);
//            $updateToken = $user->createToken('update-token',['create','update']);
//            $basicToken = $user->createToken('basic-token');
//
//            return [
//                'admin' => $adminToken->plainTextToken,
//                'update' => $updateToken->plainTextToken,
//                'basic' => $basicToken->plainTextToken
//            ];
//        }
//    }
//});


Route::get('/setup', function () {
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'password'
    ];

    if (!Auth::attempt($credentials)) {

        $user = new User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Failed to authenticate after user creation'], 500);
        }
    }

    $user = Auth::user();
    $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);
    $updateToken = $user->createToken('update-token', ['create', 'update']);
    $basicToken = $user->createToken('basic-token');

    return response()->json([
        'admin' => $adminToken->plainTextToken,
        'update' => $updateToken->plainTextToken,
        'basic' => $basicToken->plainTextToken
    ]);
});
