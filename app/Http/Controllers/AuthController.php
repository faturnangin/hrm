<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Helpers\MyFunctions;
use App\Helpers\QueryHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {  
        try {
            $this->validate($request, [
                'email' => 'required|min:3|max:100',
                'password' => 'required|max:100'
            ],[
                'email.required' => 'Email wajib diisi',
                'email.min' => 'email minimal 4 karakter',
                'email.max' => 'email maksimal 100 karakter',
                'password.required' => 'Kata sandi wajib diisi',
                'password.max' => 'Kata sandi maksimal 100 karakter'
            ]);

            $usr = $request->email;
            $pwd = $request->password;
            $remember = $request->remember;
            // dd($usr,$pwd,$remember);
            $user = DB::table('users')
                ->where('email', $usr)
                ->where('status', 1)
                ->first();

            if (!$user) {
                return redirect()
                    ->route('login.index')
                    ->with('error', '[10101] ' . QueryHelper::errorcode('10101'));
            }
            if (Hash::check($pwd, $user->password)) {
                // Set session
                $newtoken = md5(Hash::make($user->id.date("YmdHis")));
                session([
                    'nama_user' => $user->name,
                    'id_user' => $user->id,
                    'username' => $user->user_id,
                    'email' => $user->email,
                    'role' => $user->role,
                    'unit' => $user->unit,
                    'token' => $newtoken
                ]);

                // Update token
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['remember' => $newtoken]);
                MyFunctions::userActivity($user->name, "LOGIN");
                if ($remember) {
                    Cookie::queue('remember_token', $newtoken, 43200);
                }
                return redirect()->route('dashboard');
            }

            return redirect()
                ->route('login.index')
                ->with('error', '[10102] ' . QueryHelper::errorcode('10102'));

        } catch (\Exception $e) {
            return redirect()
                ->route('login.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $user_id = session('id_user');
        
        if ($user_id) {
            redirect()->route('dashboard');
        }
        
        // Check remember token dari cookie
        $remember_token = Cookie::get('remember_token');
        if ($remember_token) {
            $user = DB::table('users')
                ->where('remember', $remember_token)
                ->where('status', 1)
                ->first();
                
            if ($user) {
                // Set session
                session([
                    'nama_user' => $user->name,
                    'id_user' => $user->id,
                    'username' => $user->user_id,
                    'role' => $user->role,
                    'token' => $remember_token
                ]);
                
                return redirect()->route('dashboard');
            }
        }
        
        return view('pages.login');
    }

    public function logout(){
        session()->flush();
        Cookie::queue(Cookie::forget('remember_token'));
        return redirect()->route('login.index');
    }

    public function register(Request $request){
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
            return view('pages.register');
        }
    }
}
