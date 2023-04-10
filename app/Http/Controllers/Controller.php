<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function responseJson($success, $statusCode, $message, $result)
    {
        $data =  array(
            'success' => $success,
            'code' => $statusCode,
            'message' => $message,
            'result' => $result
        );

        return response()->json($data, $statusCode);
    }

    public function success($message, $data)
    {
        return $this->responseJson(true, 200, $message, $data);
    }

    public function error($message)
    {
        return $this->responseJson(false, 400, $message, null);
    }

    public function unauthorized($message)
    {
        return $this->responseJson(false, 401, $message, null);
    }

    public function invalidation($message)
    {
        return $this->responseJson(false, 400, $message, null);
    }

    //Convert date/datetime/time() to tanggal indonesia
    //Cara panggil di blade - {{ (new \App\Helpers\MyHelper)->indonesian_date($undangan->akad_tanggal_datetime, 'l, d F Y') }}
    public function indonesian_date($timestamp = '', $date_format = 'd F Y', $suffix = '')
    {
        if ($timestamp == NULL)
            return '-';

        if ($timestamp == '1970-01-01' || $timestamp == '0000-00-00' || $timestamp == '-25200')
            return '-';


        if (trim($timestamp) == '') {
            $timestamp = time();
        } elseif (!ctype_digit($timestamp)) {
            $timestamp = strtotime($timestamp);
        }
        # remove S (st,nd,rd,th) there are no such things in indonesia :p
        $date_format = preg_replace("/S/", "", $date_format);
        $pattern = array(
            '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
            '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
            '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
            '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
            '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
            '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
            '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
            '/November/', '/December/',
        );
        $replace = array(
            'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
            'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'September',
            'Oktober', 'November', 'Desember',
        );
        $date = date($date_format, $timestamp);
        $date = preg_replace($pattern, $replace, $date);
        $date = "{$date} {$suffix}";
        return $date;
    }

    function formatPhone($string)
    {
        if (substr($string, 0, 1) === "0") {
            $string = "62" . substr($string, 1);
        } else if (substr($string, 0, 3) === "+") {
            $string = "" . substr($string, 1);
        }
        return $string;
    }
}
