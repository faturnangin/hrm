<?php

namespace App\Http\Controllers;
use App\Helpers\QueryHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $type_menu = "dashboard";
        $user_id = session('id_user');
        $username = session('username');
        
        $count_user = DB::table('users')->where('status', 1)->count();
        $count_login = DB::table('user_activities')->where('activity', 'LOGIN')->count();
        $count_unit = DB::table('units')->count();
        $count_role = DB::table('positions')->count();
        $topUser = DB::table('user_activities')
        ->select('user', DB::raw('COUNT(*) as login_count'))
        ->where('activity', 'LOGIN')
        ->groupBy('user')
        ->orderByDesc('login_count')
        ->first();
        return view('pages.dashboard', compact('type_menu','user_id','username','count_user','count_login','count_unit','count_role','topUser'));
    }
}
