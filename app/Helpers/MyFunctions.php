<?php
namespace App\Helpers;
use App\Models\Logs;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyFunctions
{
    function authorizations($request){
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader && Str::startsWith($authorizationHeader, 'Basic ')) {
            $basicAuth = str_replace('Basic ', '', $authorizationHeader);
            $auth = base64_decode($basicAuth);
            $appKey = env('APP_KEY');
            $appCode = env('APP_CODE');
            $arrBasicAuth = explode(":",$auth);
            if($arrBasicAuth[0] == $appCode && base64_decode($arrBasicAuth[1]) == $appKey){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function tokenVerification($request,$email){
        $userToken = $request->header('User-Token');
        $data_user = DB::table('users')
                    ->where('username', $email)
                    ->where('token',$userToken)
                    ->first();
        if($data_user){
            return $data_user;
        }else{
            return false;
        }
    }

    public static function userActivity($user,$message){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        DB::table('user_activities')->insert([
            'activity' => $message,
            'user' => $user,
            'ip' => $ipAddress,
            'date_created' => now()
        ]);
    }

    public static function logact($user,$data,$messages,$source,$outlet_id){
        $data = str_replace("\n", "", $data);
        $ua = new Logs();
        $ua->user = $user;
        $ua->query = $data;
        $ua->outlet_id = $outlet_id;
        $ua->error_number = $source;
        $ua->messages = $messages;
        $ua->save();
    }

    public static function randomerrorid(){
        $date=date("YmdH");
        $rand=str_shuffle(date("His"));
        return $date.$rand;
    }

    public static function aol_auth(){
        $res=false;
        $q=DB::select("select baseurl, bearer, session from aol limit 1");
        if (count($q) > 0) {
            $res = $q;
        }
        return $res;
    }

    public static function generate_string($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Angka dan huruf
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function laststok_nonimei($warehouse, $idproduct) {
        $res = 0;
        $result = DB::table('acc_master')
            ->where('warehouse', $warehouse)
            ->where('id_product', $idproduct)
            ->value('qty');
        if ($result !== null) {
            $res = $result;
        }
        return $res;
    }
    
    public static function is_exist_acc_master($product, $warehouse) {
        $result = DB::table('acc_master')
            ->where('id_product', $product)
            ->where('warehouse', $warehouse)
            ->first();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    
    public static function temp_qty_itemdepo($idproduct, $warehouse) {
        $result = DB::table('acc_depo_executor')
            ->where('warehouse', $warehouse)
            ->where('id_product', $idproduct)
            ->where('status', 0)
            ->sum('qty');
        return $result ? $result : 0;
    }

    public static function createXenditInvoice(
        string $name,
        string $email,
        string $phone,
        string $packageName,
        float $packagePrice,
        string $externalId,
        float $amount,
        string $description
    ): array {
        $apiKey = config('services.xendit.api_key');
        $url = 'https://api.xendit.co/v2/invoices';

        $customerInfo = [
            'given_names' => $name,
            'email' => $email,
            // 'mobile_number' => $phone
        ];

        $items = [
            [
                'name' => $packageName,
                'quantity' => 1,
                'price' => $packagePrice,
                'category' => 'SaaS',
                'url' => 'http://io.nusapos.id/'
            ]
        ];

        $data = [
            'external_id' => $externalId,
            'amount' => $amount,
            'description' => $description,
            'invoice_duration' => 86400,
            'customer' => $customerInfo,
            'customer_notification_preference' => [
                'invoice_created' => ['whatsapp', 'email'],
                'invoice_reminder' => ['whatsapp', 'email'],
                'invoice_paid' => ['whatsapp', 'email']
            ],
            'success_redirect_url' => 'http://io.nusapos.id/passport/billing',
            'failure_redirect_url' => 'http://io.nusapos.id/passport/billing',
            'currency' => 'USD',
            'items' => $items,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":");
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        
        curl_close($ch);
        
        return [
            'http_code' => $httpCode,
            'response' => json_decode($response, true)
        ];
    }
}
