<?php

/**
 * Format nomor hp 62
 * @param int $number
 */

use Illuminate\Support\Carbon;

if (!function_exists('phone_number')) {
    function phone_number($nohp)
    {
        if (substr($nohp, 0, 2) === "62") {
            return $nohp;
        }
        // kadang ada penulisan no hp 0811 239 345
        $nohp = str_replace(" ", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace("(", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace(")", "", $nohp);
        // kadang ada penulisan no hp 0811.239.345
        $nohp = str_replace(".", "", $nohp);

        // cek apakah no hp mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            // cek apakah no hp karakter 1-3 adalah 62
            if (substr(trim($nohp), 0, 3) == '62') {
                $hp = trim($nohp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr(trim($nohp), 0, 1) == '0') {
                $hp = '62' . substr(trim($nohp), 1);
            }
        }
        return $hp;
    }
}

/**
 * cut long string
 * @param string $string
 * @param int $int default 70
 */
if (!function_exists('body_text')) {
    function body_text($string, $int = 70)
    {
        $end = (strlen($string) > $int) ? '...' : null;
        return substr($string, 0, $int) . $end;
    }
}

/** Menampilkan tanggal format indonesia */
if (!function_exists('date_id')) {
    function date_id($timestamp, $format = 'D MMMM, YYYY')
    {
        return Carbon::parse($timestamp)->isoFormat($format);
    }
}

/** Menampilkan jam format indonesia */
if (!function_exists('time_id')) {
    function time_id($timestamp, $format = 'H:i')
    {
        return Carbon::parse($timestamp)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format($format);
    }
}

/**
 * http request with curl
 */
if (!function_exists('http_request')) {
    function http_request($method, $url, $data = [])
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        // 'authorization: ' . config('message.token'),
        // 'cache-control: no-cache',
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return json_decode($result, true);
    }
}
