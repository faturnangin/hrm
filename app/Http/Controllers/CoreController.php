<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Helpers\QueryHelper;
use App\Helpers\MyFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Endpoints;

class CoreController extends Controller
{
    public function credentials(Request $request)
    {
        $type_menu = "dashboard";
        $user_id = session('id_user');
        $username = session('username');
        $email = session('email');
        $api_keys = DB::table('api_keys')->where('user_id', $user_id)->get();
        $user_data = DB::select("select user_id,token,token_refresh,token_date,api_key from users where email='$email' and user_id='$username' and id='$user_id'");
        if ($request->isMethod('post')) {
            if($request->has('addkey')) {
                $permission = $request->input('permission');
                $password = $request->input('password');
                $user = DB::table('users')
                    ->where('user_id', $username)
                    ->where('status', 1)
                    ->first();
                if (Hash::check($password, $user->password)) {
                    $apiKey = Str::uuid();
                    DB::table('api_keys')->insert([
                        'api_key' => $apiKey,
                        'user_id' => $user_id,
                        'created_at' => now(),
                        'permissions' => $permission,
                    ]);
                    return redirect()->back()->with(['success' => 'API Key Generated']);
                }else{
                    return redirect()->back()->with(['error' => 'Incorrect Password']);
                }
            }
            elseif($request->has('deletekey')) {
                DB::table('api_keys')
                    ->where('api_key', $request->dapikey)
                    ->delete();
                return redirect()->back()->with('success', 'Key deleted successfully!');
            }
        }else{
            return view('pages.credentials', compact('type_menu','user_id','api_keys','username','user_data'));
        }
    }

    public function endpoints(Request $request)
    {
        $type_menu = "dashboard";
        $user_id = session('id_user');
        $username = session('username');

        if ($request->isMethod('post')) {
            $permission = $request->input('permission');
            $method = $request->input('method');
            $description = $request->input('description');
            $name = $request->input('name');
            // dd($permission,$method,$description,$name);
            $insert = DB::table('endpoints')->insert([
                    'name' => $name,
                    'description' => $description,
                    'method' => $method,
                    'permissions' => $permission]);
            if($insert){
                return redirect()->back()->with(['success' => 'Endpoint Created']);
            }else{
                return redirect()->back()->with(['error' => 'Failed to create endpoint']);
            }
        }else{
            $endpoints = DB::table('endpoints')->get();
            return view('pages.endpoints', compact('type_menu','user_id','endpoints','username'));
        }
    }

    public function positions(Request $request)
    {
        $type_menu = "dashboard";
        $user_id = session('id_user');
        $username = session('username');
        if ($request->isMethod('post')) {
            if($request->has('addposition')) {
                $validated = $request->validate([
                    'aname' => 'required|string|max:255',
                    'adescription' => 'required|string'
                ]);
                DB::table('positions')->insert([
                    'name' => $request->aname,
                    'description' => $request->adescription,
                ]);
                return redirect('/positions')->with('success', 'Position added successfully!');
            }

            elseif($request->has('editposition')) {
                $validated = $request->validate([
                    'ename' => 'required|string|max:255',
                    'edescription' => 'required|string'
                ]);

                DB::table('positions')
                    ->where('id', $request->eid)
                    ->update([
                        'name' => $request->ename,
                        'description' => $request->edescription
                    ]);

                return redirect('/positions')->with('success', 'Position updated successfully!');
            }

            elseif($request->has('deleteposition')) {
                DB::table('positions')
                    ->where('id', $request->did)
                    ->delete();
                return redirect('/positions')->with('success', 'Position deleted successfully!');
            }
        }else{
            $positions = DB::table('positions')->get();
            return view('pages.positions', compact('type_menu','user_id','positions','username'));
        }
    }

    public function units(Request $request)
    {
        $type_menu = "dashboard";
        $user_id = session('id_user');
        $username = session('username');
        if ($request->isMethod('post')) {
            if($request->has('addunit')) {
                $validated = $request->validate([
                    'aname' => 'required|string|max:255'
                ]);
                DB::table('units')->insert([
                    'name' => $request->aname,
                    'description' => $request->adescription ? $request->adescription : "",
                ]);
                return redirect('/units')->with('success', 'Unit added successfully!');
            }

            elseif($request->has('editunit')) {
                $validated = $request->validate([
                    'ename' => 'required|string|max:255'
                ]);

                DB::table('units')
                    ->where('id', $request->eid)
                    ->update([
                        'name' => $request->ename,
                        'description' => $request->edescription ? $request->edescription : "",
                    ]);

                return redirect('/units')->with('success', 'Unit updated successfully!');
            }

            elseif($request->has('deleteunit')) {
                DB::table('units')
                    ->where('id', $request->did)
                    ->delete();
                return redirect('/units')->with('success', 'Unit deleted successfully!');
            }
        }else{
            $units = DB::table('units')->get();
            return view('pages.units', compact('type_menu','user_id','units','username'));
        }
    }

    public function log(Request $request)
    {
        $type_menu = "dashboard";
        $user_id = session('id_user');
        $username = session('username');
        $email = session('email');
        $api_keys = DB::table('api_keys')->where('user_id', $user_id)->get();
        
        $api_logs = DB::table('api_logs')
        ->where('user_id', $username)
        ->whereDate('date', now()->format('Y-m-d'))
        ->get();
        $date = date("Y-m-d");
        if ($request->isMethod('post')) {
            if($request->has('filter')) {
                $daterange = $request->input('daterange');
                if ($daterange) {
                    $dates = explode(' - ', $daterange);
                    $start_date = trim($dates[0]);
                    $end_date = trim($dates[1]);
                    $date = $daterange;
                    $api_logs = DB::table('api_logs')
                    ->where('user_id', $username)
                    ->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)
                    ->get();
                    return view('pages.log', compact('type_menu','user_id','api_keys','username','api_logs','date'));
                }else{
                    return redirect()->back()->with(['error' => 'Internal Error']);
                }
            }
        }else{
            return view('pages.log', compact('type_menu','user_id','api_keys','username','api_logs','date'));
        }
    }
}
