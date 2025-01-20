<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class QueryHelper
{
    public static function getMenus()
    {
        $user = Session::get('id_user');
        $ouid = Session::get('outlet_id');
        $menuid_arr = DB::select("select menu_access from users where id='$user'");
        $menuid = $menuid_arr[0]->menu_access;
        $menu_arr = DB::select("select kategori,ikon_kategori, name, url from menu_list where kategori != 'Service' AND status=1 and id in ($menuid) order by urutan_kategori");
        $groupedMenuItems = collect($menu_arr)->groupBy('kategori');
        return $groupedMenuItems;
    }

    public static function getCategories()
    {
        $ouid = Session::get('outlet_id');
        $cat = DB::select("select id, name from categories where status = 1 and outlet_id = '$ouid' ");
        return $cat;
    }

    public static function getRegularProducts()
    {
        $prod = DB::select("select id_product, name_product from products");
        return $prod;
    }

    public static function getWarehouses()
    {
        $ouid = Session::get('outlet_id');
        $wh = DB::select("select id, name from warehouse where outlet_id = '$ouid' ORDER BY name ASC ");
        return $wh;
    }

    public static function getAccounts()
    {
        $department = Session::get('department');
        $user = Session::get('id_user');
        $account = DB::select("SELECT account_no, account_type, account_name FROM accounts ORDER BY account_name ASC");
        return $account;
    }

    public static function errorcode($data){
        $select = DB::select("select messages from response_code where code='$data'");
        if(count($select) > 0){
            return $select[0]->messages;
        }else{
            return "Terjadi kesalahan";
        }
    }

    public static function cekusermenu($url){
        $cek = DB::select("select id from menu_list where url='$url'");
        if(count($cek) > 0 ){
            $uid = Session::get('id_user');
            $idmenu = $cek[0]->id;
            $cek2 = DB::select("select menu_access from users where id='$uid' and menu_access like '%$idmenu%'");
            if(count($cek2) > 0){
                return 1;
            }else{
                $select = DB::select("select messages from response_code where code='91001'");
                if(count($select) > 0){
                    return $select[0]->messages. "error code 91001";
                }else{
                    return "Terjadi kesalahan";
                }
            }
        }
    }

    public static function getUserDetail($pid){
        $ouid = Session::get('outlet_id');
        $sel = DB::select("select user_id, nick_name, role from users where user_id='$pid' and outlet_id='$ouid'");
        if(count($sel) > 0){
            return $sel[0]->user_id. " - " .$sel[0]->nick_name." [".$sel[0]->role."]";
        }else{
            return "rincian pengguna tidak ditemukan";
        }
    }

    public static function getWarehouseName($pid){
        $ouid = Session::get('outlet_id');
        $sel = DB::select("select name from warehouse where id='$pid' and outlet_id='$ouid'");
        if(count($sel) > 0){
            return $sel[0]->name;
        }else{
            return "nama gudang tidak ditemukan";
        }
    }

    public static function getVendorName($pid){
        $ouid = Session::get('outlet_id');
        $sel = DB::select("select name from distributors where distributor_id='$pid' and outlet_id='$ouid'");
        if(count($sel) > 0){
            return $sel[0]->name;
        }else{
            return "nama pemasok tidak ditemukan";
        }
    }

    public static function getBankDetail($pid){
        $ouid = Session::get('outlet_id');
        $sel = DB::select("select type, account_name,coa from bank_account where coa='$pid' and outlet_id='$ouid'");
        if(count($sel) > 0){
            return $sel[0]->coa. " - " .$sel[0]->account_name." [".$sel[0]->type."]";
        }else{
            return "akun penyesuaian tidak ditemukan";
        }
    }

    public static function transferStock($product_id, $from_warehouse, $to_warehouse, $qty, $last_stock_from, $last_stock_to, $notes) {
        $ouid = Session::get('outlet_id');
        $user = Session::get('id_user');
        $uniqid = $ouid."-".date("ymd").str_shuffle(date("His"));
        // $innumber = "TRF-IN".$ouid."-".date("ymd").str_shuffle(date("His"));
        $new_stock_from = $last_stock_from - $qty;
        $new_stock_to = $last_stock_to + $qty;
        // Insert stock out mutation
        DB::table('stock_mutation')->insert([
            'outlet_id' => $ouid,
            'reff_no' => 'TRF-OUT'.$uniqid,
            'product' => $product_id,
            'warehouse' => $from_warehouse,
            'qty_out' => $qty,
            'last_stock' => $last_stock_from,
            'current_stock' => $new_stock_from,
            'note' => 'Pemindahan barang '.$product_id.' dari ' . $from_warehouse . ' ke ' . $to_warehouse . ' : '. $notes,
            'user' => $user,
            'date_created' => now(),
            'type' => 'TRANSFER',
        ]);

        // Insert stock in mutation
        DB::table('stock_mutation')->insert([
            'outlet_id' => $ouid,
            'reff_no' => 'TRF-IN'.$uniqid,
            'product' => $product_id,
            'warehouse' => $to_warehouse,
            'qty_in' => $qty,
            'last_stock' => $last_stock_to,
            'current_stock' => $new_stock_to,
            'note' => 'Pemindahan barang '.$product_id.' dari ' . $from_warehouse . ' ke ' . $to_warehouse . ' : ' . $notes,
            'user' => $user,
            'date_created' => now(),
            'type' => 'TRANSFER',
        ]);
    }

    public static function status_pesanan($status){
        switch($status){
            case 0 :
                $nw = "RECEIVED"; //Masuk job list"
                $color = "primary";
                break;
            case 1 :
                $nw = "REPAIRING"; //Diterima tukang
                $color = "warning";
                break;
            case 3 :
                $nw = "READY"; //Selesai diperbaiki
                $color = "info";
                break;
            case 5 :
                $nw = "COMPLETED"; //Selesai/sudah di pick up
                $color = "success";
                break;
            case 2 :
                $nw = "CANCELLED"; //Batal/dikembalikan
                $color = "danger";
                break;
            case 4 :
                $nw = "SUCCESS"; //sukses di accuarate
                $color = "success";
                break;
            default :
                $nw = "status belum ditentukan";
                $color = "secondary";
        }

        return $nw."#".$color;

    }

    public static function count_job($menu){
        $role = session('role');
        $idsales = session('id_sales');
        switch($menu){
            case "sales/list" :
                $nw = DB::select("select id from sales_invoice where status in (0,1,3) group by no_faktur");
                if($role == "TEKNISI"){
                    $nw = DB::select("select id from sales_invoice where status = 0 group by no_faktur");
                }    
                $jum = count($nw);
                $color = "primary";
                break;
            case "sales/myjob" :
                $nw = DB::select("select id from sales_invoice where status = 1 and idsalesman='$idsales' group by no_faktur");
                $jum = count($nw);
                $color = "warning";
                break;
            case "itemtransfer" :
                $nw = DB::select("select id from item_transfer where status in (0,2) group by transfer_no");
                $color = "warning";
                $jum = count($nw);
                break;
            case "sales" :
                // $nw = DB::table('sales_invoice')
                // ->join('sales_order','sales_invoice.no_faktur','=','sales_order.reff')
                // ->select('sales_invoice.no_faktur', 'sales_order.response_1')
                // ->where('sales_invoice.status', '<', 4)
                // ->where('sales_invoice.status_aol', '<', 4)
                // ->groupBy('no_faktur')
                // ->get();
                $nw = DB::select("
                    SELECT COUNT(DISTINCT so.id) AS jum 
                    FROM sales_order so 
                    WHERE (so.status < 4 OR so.status_aol < 4)
                    AND EXISTS (
                        SELECT 1 
                        FROM sales_invoice si 
                        WHERE si.no_faktur = so.reff
                    )
                ");
                $color = "success";
                $jum = $nw[0]->jum;;
                break;
            case "sales/joborder" :
                $nw = "CANCELLED";
                $color = "danger";
                $jum = 0;
                break;
            case "sales/downpayment" :
                $nw = "SUCCESS";
                $color = "success";
                $jum = 0;
                break;
            case "stock/pi" :
                $nw = DB::select("select no_faktur from purchase_invoice where status in (0,1,3) group by no_faktur");
                $color = "info";
                $jum = count($nw);
                break;
            case "stock/transfer/log" :
                $nw = DB::select("select reff from item_depo_transfer where status = 0 group by reff");
                $color = "danger";
                $jum = count($nw);
                break;
            case "sales/return/list" :
                $nw = DB::select("select no_faktur from sales_return where status = 0 group by no_faktur");
                $color = "danger";
                $jum = count($nw);
                break;
            default :
                $nw = "status belum ditentukan";
                $color = "dark";
                $jum = 0;
        }

        return $jum."#".$color;
    }

    public static function stocktransfer($product, $warehouseAsal, $warehouseTujuan, $qty)
    {
        DB::beginTransaction();
        try {
            // Update or insert untuk gudang asal
            DB::table('acc_master')
                ->updateOrInsert(
                    ['id_product' => $product, 'warehouse' => $warehouseAsal],
                    ['qty' => DB::raw("COALESCE(qty, 0) - $qty")]
                );

            // Update or insert untuk gudang tujuan
            DB::table('acc_master')
                ->updateOrInsert(
                    ['id_product' => $product, 'warehouse' => $warehouseTujuan],
                    ['qty' => DB::raw("COALESCE(qty, 0) + $qty")]
                );

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public static function getWarehouseByIdsales($idsales)
    {
        $warehouse = DB::table('users')
            ->where('idsales', $idsales)
            ->value('warehouse');
        return $warehouse ?? false;
    }

    public static function getUnitPrice($idProduct)
    {
        $product = DB::table('products')
            ->select('unit_price')
            ->where('id_product', $idProduct)
            ->first();
        return $product ? $product->unit_price : 0;
    }

    public static function getSalesInvoiceSummary($noFaktur)
    {
        $search = "SO";
        $replace = "SI";
        $no_si = str_replace($search, $replace, $noFaktur);
        $currentSales = DB::table('sales_invoice')
            ->select(
                DB::raw('SUM(total) as total_amount'),
                DB::raw('MAX(warranty_type) as warranty_type'),
                DB::raw('MAX(status) as status')
            )
            ->where('no_faktur', $no_si);

        $logSales = DB::table('log_sales_invoice')
            ->select(
                DB::raw('SUM(total) as total_amount'),
                DB::raw('MAX(warranty_type) as warranty_type'),
                DB::raw('MAX(status) as status')
            )
            ->where('no_faktur', $no_si);

        $result = $currentSales->union($logSales)
            ->get();

        // Menghitung total dari kedua tabel
        $totalAmount = $result->sum('total_amount');
        
        // Mengambil warranty_type yang tidak null, defaultnya dari tabel utama
        $warrantyType = $result->first(function($item) {
            return !is_null($item->warranty_type);
        });

        $status = $result->first(function($item) {
            return !is_null($item->status);
        });

        return [
            'total_amount' => $totalAmount ?? 0,
            'warranty_type' => $warrantyType ? $warrantyType->warranty_type : '-',
            'status' => $status ? $status->status : ''
        ];
    }

    public static function endpointAmount($data){
        $select = DB::select("select point from endpoints where name='$data'");
        if(count($select) > 0){
            return $select[0]->point;
        }else{
            return false;
        }
    }

    public static function bankMutation($user_id, $reff_no, $last_balance, $debit, $credit, $current_balance, $note, $source){
        $select = DB::insert("insert into bank_mutations set user_id='$user_id', reff_no='$reff_no', last_balance='$last_balance', 
                                debit='$debit', credit='$credit', current_balance='$current_balance', note='$note', source='$source'");
        if($select){
            return true;
        }else{
            return false;
        }
    }

    public static function responseCode($data){
        $select = DB::select("select messages from response_code where code='$data'");
        if(count($select) > 0){
            return $select[0]->messages;
        }else{
            return "Terjadi kesalahan";
        }
    }
}