<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

// use Symfony\Component\HttpFoundation\Request;

class MyHelper
{
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

  public function formatTanggal($tanggal)
  {
    // Ubah format tanggal menjadi objek Carbon
    $carbon = Carbon::createFromFormat('Y-m-d', $tanggal);

    // Set locale menjadi bahasa Indonesia
    setlocale(LC_TIME, 'id_ID');

    // Format tanggal dengan format yang diinginkan
    return $carbon->formatLocalized('%A, %d %B %Y');
  }
}
