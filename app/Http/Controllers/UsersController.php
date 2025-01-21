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
        }else{
            $units = DB::table('units')->select('name')->get();
            $jobtitles = DB::table('positions')->select('name')->get();
            return view('pages.adduser',compact('type_menu','units','jobtitles'));
        }
    }

    public function edituser(Request $request, $id){
        $type_menu = "dashboard";
        $user = DB::table('users')->where('user_id', $id)->first();
        if(!$user){
            return redirect()->back()->with('error', 'User Not Found!');
        }
        if ($request->isMethod('post')) {
            $username = $request->input('username');
            $fullname = $request->input('fullname');
            $joindate = $request->input('joindate');
            $joindatetime = Carbon::createFromFormat('Y-m-d', $joindate)->format('Y-m-d H:i:s');
            $unit = $request->input('unit');
            $jobtitles = $request->input('jobtitles');
            $jobTitleString = implode(',', $jobtitles);
            $dataToUpdate = [
                'user_id' => $username,
                'name' => $fullname,
                'role' => $jobTitleString,
                'unit' => $unit,
                'join_date' => $joindatetime
            ];
            $update = DB::table('users')->where('user_id', $id)->update($dataToUpdate);
            if($update){
                return redirect()->back()->with('success', 'User Updated Successfully!');
            }else{
                return redirect()->back()->with('error', 'Failed to Update User!');
            }
        }else{
            $units = DB::table('units')->select('name')->get();
            $jobtitles = DB::table('positions')->select('name')->get();
            return view('pages.edituser',compact('type_menu','units','jobtitles','user'));
        }
    }
}
