<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Helpers\QueryHelper;
use Illuminate\Support\Facades\Session;
use App\Helpers\MyFunctions;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;


class UsersController extends Controller
{
    public function users(Request $request){
        $type_menu = "dashboard";
        $user_id = session('id_user');
        $username = session('username');
        if ($request->isMethod('post')) {
            if($request->has('edituser')) {
                DB::table('users')
                    ->where('user_id', $request->euid)
                    ->update([
                        'status' => $request->estatus,
                        'plan' => $request->eplan
                    ]);
                return redirect('/users')->with('success', 'User updated successfully!');
            }
            elseif($request->has('deleteuser')) {
                DB::table('users')
                    ->where('user_id', $request->duid)
                    ->delete();
                return redirect('/users')->with('success', 'User deleted successfully!');
            }
        }else{
            $users = DB::table('users')->get();
            return view('pages.users', compact('type_menu','user_id','users','username'));
        }
    }

    public function profile(Request $request)
    {
        $type_menu = "dashboard";
        $user_id = session('id_user');
        $username = session('username');

        if ($request->isMethod('post')) {
            if($request->has('change_password')) {
                $old = $request->input('password');
                $new = $request->input('password2');
                $hashed_password = Hash::make($new);
                $user = DB::table('users')
                ->where('user_id', $username)
                ->where('status', 1)
                ->first();
                if (Hash::check($old, $user->password)) {
                    $update = DB::table('users')
                    ->where('user_id', $username)
                    ->update([
                        'password' => $hashed_password
                    ]);
                    if($update){
                        return redirect()->back()->with('success', 'Password changed!');
                    }else{
                        return redirect()->back()->with('error', 'Error internal!');
                    }
                }else{
                    return redirect()->back()->with('error', 'Password is wrong!');
                }
            }
            
        }else{
            $user = DB::table('users')->where('user_id', $username)->first();
            return view('pages.profile', compact('type_menu','username','user'));
        }
    }

    public function adduser(Request $request){
        $type_menu = "dashboard";
        if ($request->isMethod('post')) {
            $fullname = $request->input('fullname');
            $email = $request->input('email');
            $password = $request->input('password');
            $password2 = $request->input('password2');
            // dd($firstname,$lastname,$email,$password,$password2);
            if($password != $password2) {
                return redirect()
                    ->route('register')
                    ->with('error', '[40001] ' . QueryHelper::errorcode('40001'));
            }else{
                $randomNumber = rand(100, 999);
                $hashed_password = Hash::make($password);
                // $username = strtolower(preg_replace('/[^a-zA-Z]/', '', $fullname)) . $randomNumber;
                $lastUserId = DB::table('users')
                    ->where('user_id', 'LIKE', 'SP%')
                    ->orderBy('user_id', 'desc')
                    ->value('user_id');
                if ($lastUserId) {
                    $newIdNumber = (int) substr($lastUserId, 2) + 1;
                    $newUserId = 'SP' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
                } else {
                    $newUserId = 'SP0001';
                }
                $plan = "TRIAL";
                $trial_data = DB::table('products')
                ->where('product_name', $plan)
                ->first();
                $balance = $trial_data->point ? $trial_data->point : 0; 

                $tokenHash = MyFunctions::generate_string(50);
                $tokenRefresh = MyFunctions::generate_string(65);
                $dateExpiry = date('Y-m-d H:i:s', strtotime('+365 days'));

                $createUser = DB::table('users')->insert([
                    'user_id' => $newUserId,
                    'password' => $hashed_password,
                    'email' => $email,
                    'name' => $fullname,
                    'role' => 'USER',
                    'plan' => $plan,
                    'status' => 1,
                    'balance' => $balance,
                    'date_created' => now(),
                    'last_active' => now(),
                    'token' => $tokenHash,
                    'token_date' => $dateExpiry,
                    'token_refresh' => $tokenRefresh]);
                if($createUser) {
                    DB::insert("insert into token_logs set token='$tokenHash', date_add=now(), user_id='$newUserId'");
                    DB::table('notifications')->insert([
                        'date' => now(),
                        'user_id' => $newUserId,
                        'message' => 'Account created successfully',
                    ]);
                    return redirect()->route('login.index')->with('success', 'Account created');
                }else{
                    return redirect()->route('register')->with('error', 'Failed to register');
                }
            }
        }else{
            $units = DB::table('units')->select('name')->get();
            $jobtitles = DB::table('positions')->select('name')->get();
            return view('pages.adduser',compact('type_menu','units','jobtitles'));
        }
    }
}
