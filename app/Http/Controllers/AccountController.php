<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    // This method will show the registration page
    public function registration()
    {
        return view('front.account.registration');
    }

    // This method will save the user
    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255|unique:users,name', //validate the name
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);



        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            // $user->remember_token = Str::random(60);
            $user->save();

            session()->flash('success', 'You have registerd successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // This method will show the login page
    public function login()
    {
        return view('front.account.login');
    }

    // This method will authenticate the user  validation ကို ကိုယ်တိုင် စစ်ချင်တဲ့အခါ make($request->all(),[arrays]) |
    // Rules about which fields should be checked and how. '' => '|'
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {

            // Auth Session  | Auth::attempt() method က user login လုပ်ရန်အသုံးပြု
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }


    public function profile()
    {
        // dd(Auth::user());
        //  $id = Auth::user()->id;   => check the user id
        // dd($id);

        // $user = User::where('id',$id)->first(); => get the user by id
        // dd($user);
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first(); // Find the user by ID

        return view('front.account.profile', [
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);

        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'Profile updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function logout()
    {
        Auth::logout();   //why auth logout is used here
        return redirect()->route('account.login');
    }

    // public function generateRememberToken(User $user)
    // {
    //     $rememberToken = Str::random(60); // Generate a random string for the remember_token

    //     // Update the user's remember_token in the database
    //     $user->remember_token = $rememberToken;
    //     $user->save();

    //     // Now the user has a remember_token
    //     return $rememberToken;
    // }



}
