<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a list of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            "success" => true,
            "message" => "User List",
            "data" => $users
        ]);
    }


    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation Error.",
                "error" => $validator->errors(),
            ], 400);
        }

        try {
            $user = User::create($input);
            return response()->json([
                "success" => true,
                "message" => "User created successfully.",
                "data" => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Server error.",
                "error" => $th,
            ], 400);
        }
    }

    /**
     * Show user by id.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json([
                "success" => false,
                "message" => "User not found.",
            ], 400);
        }
        return response()->json([
            "success" => true,
            "message" => "User retrieved successfully.",
            "data" => $user
        ]);
    }


    /**
     * Update user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation Error.",
                "error" => $validator->errors(),
            ], 400);
        }

        $user->exists = true;
        $user->name = $input['name'];
        $user->email = $input['email'];

        try {
            $user->save();
            return response()->json([
                "success" => true,
                "message" => "User updated successfully.",
                "data" => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Server error.",
                "error" => $th,
            ], 400);
        }
    }

    /**
     * Remove user.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::where('id', $id)->delete();
        return response()->json([
            "success" => true,
            "message" => ($user === 1 ? "User deleted successfully." : "User not found."),
            "data" => $user
        ]);
    }
}
