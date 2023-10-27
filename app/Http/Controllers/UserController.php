<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->paginate(10);
        return view('pages.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->default_password),
            'description' => $request->description,
            'image_link' => $request->image_link,
            'is_manager' => isset($request->is_manager) ? true: false,
        ]);

        return redirect()->route('users.create')->with('success', 'User has been created.');        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.users.show', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $payload = $request->only(["name","image_link", 'email', 'description']);
        $payload["is_manager"] = isset($request->is_manager) ? true: false;
        $user->update($payload);
        return redirect()->route('users.show', $user->id)->with('success', "{$user->name} has been updated.");        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if(Auth::user()->id != $user->id) {
            $user->delete();
        } else {
            return redirect()->back();   
        }
        return redirect()->route('products.index')->with('success', "{$product->name} has been deleted.");  
    }
}
