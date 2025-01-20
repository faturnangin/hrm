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
        // $balance = DB::table('users')
        // ->select('balance')
        // ->where('id', $user_id)
        // ->first();
        // $paid_inv = DB::table('invoices')
        // ->select('invoice_id')
        // ->where('userid', $username)
        // ->where('status', 4)
        // ->count();
        // $count2 = DB::table('api_logs')->where('status', 2)->where('user_id',$username)->count();
        // $count4 = DB::table('api_logs')->where('status', 4)->where('user_id',$username)->count();
        return view('pages.dashboard', compact('type_menu','user_id','username'));
    }
}
