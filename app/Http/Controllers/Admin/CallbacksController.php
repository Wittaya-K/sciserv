<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CallbacksController extends Controller
{
    public function callback()
    {
        define('CLIENT_ID', 'lCKbpOejfXrkUuHuxk9fMt');
        define('CLIENT_SECRET', 'YgXzEUVAqUKxIPqv8prl9rS46LREPCcTSreZxo2pbVJ');
        define('LINE_API_URI', 'https://notify-bot.line.me/oauth/token');
        define('CALLBACK_URI', url('admin/callbacks'));

        parse_str($_SERVER['QUERY_STRING'], $queries);

        $fields = [
            'grant_type' => 'authorization_code',
            'code' => $queries['code'],
            'redirect_uri' => CALLBACK_URI,
            'client_id' => CLIENT_ID,
            'client_secret' => CLIENT_SECRET
        ];

        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, LINE_API_URI);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $res = curl_exec($ch);
            curl_close($ch);

            if ($res == false)
                throw new Exception(curl_error($ch), curl_errno($ch));

            $json = json_decode($res);
            $access_token = $json->access_token; //เก็บค่า line access token
            //insert ข้อมูลลงตาราง tbl_edtech_connects
            $EdtechConnects = DB::table('tbl_edtech_connects')->where('username','=', Auth::user()->username)->count();
            if($EdtechConnects < 1)
            {
                DB::table('tbl_edtech_connects')->updateOrInsert(
                    array(
                        'username'          => Auth::user()->username,
                        'department_name'   => Auth::user()->department_name,
                        'access_token'      => $access_token,
                        'status'            => 1
                    )
                );
            }
        } catch (Exception $e) {
            var_dump($e);
        }

        $queryString = '';
        return view('admin.edtech_connects.index', compact('queryString'));
    }
}
