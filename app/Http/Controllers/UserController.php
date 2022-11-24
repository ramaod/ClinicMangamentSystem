<?php

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use SebastianBergmann\CodeCoverage\Driver\Selector;

class UserController extends controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return Response()->json(['users' => User::all()]);
    }

    public function register(Request $request){
        $data = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email'=> 'email|max:255',
                'password'=> 'required|string|min:6|max:15',
                'phone' => 'required|string|max:20',
                'image' => 'nullable|image|mimes:jpeg,jpg,png',
            ]
        );

        if($data->fails())
            return Response()->json(
                ['status' => false,
                'error_code' => 404,
                'message' => $data->errors()]);

        try{
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'phone' => $request['phone'],
            ]);

            if ($request->hasFile('image')) {
                // Get filename with extension
                $filenameWithExt = $request->file('image')->getClientOriginalName();

                // Get just the filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                // Get extension
                $extension = $request->file('image')->getClientOriginalExtension();

                // Create new filename
                $filenameToStore = $filename.'_'.time().'.'.$extension;

                // Uplaod image
                $path = $request->file('image')->storeAs('public/users/images/'.$user->id, $filenameToStore);

                $user->image = URL::asset('storage/'.'users/images/'.$user->id.'/'.$filenameToStore);

                // <img src="/storage/users/images/{{$user->id}}">
            }
        }
        catch (Exception $exception){
            return Response()->json(['status' => false,
            'error_code' => 404,
            'message' => 'Change your email or phone number please']);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        $user->save();
        return Response()->json([
            'status' => true,
            'status code' => 200,
            'token' => $token,
            'user'=>$user->attachRole('user'),
            'message' => 'WELCOM REGISTER SUCSSFULY'
        ]);
  }
   public function login(Request $request){
        if (!Auth::attempt($request->only('phone', 'password'))) {
            return response()->json([
                'status' => false,
                'error_code' => 404,
                'message' => 'Check your phone and password please !!'
            ]);
        }

        $user = User::where('phone', $request['phone'])->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => True,
            'status code' => 200,
            'token' => $token,
            'user' => $user,
            'message' => 'WELCOM LOGIN SUCSSFULY'

        ]);
    }
    public function logout(){
        try{
            Auth::user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return Response()->json([
                'status' => true,
                'status code' => 200,
                'message'=>'log out successfully.']);
        }
        catch (Exception $exception){
            return Response()->json([
                'status' => false,
                'status code' => 404,
                'error'=>'log out failed.']);
        }
    }

}
