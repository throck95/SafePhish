<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController as Auth;
use App\Models\Email_Tracking;
use App\Models\Website_Tracking;
use App\Models\Reports;
use App\Models\Two_Factor;
use App\Models\User;
use League\Csv;

class DataController extends Controller
{
    /**
     * postWebsiteJson
     * Posts data queried from website_tracking table. Requires authenticated user to execute data retrieval.
     *
     * @return  array|\Illuminate\Http\RedirectResponse
     */
    public static function postWebsiteJson() {
        if(Auth::check()) {
            $json = Website_Tracking::all();
            return $json;
        }
        return redirect()->route('e401');
    }

    /**
     * postEmailJson
     * Posts data queried from email_tracking table. Requires authenticated user to execute data retrieval.
     *
     * @return  array|\Illuminate\Http\RedirectResponse
     */
    public static function postEmailJson() {
        if(Auth::check()) {
            $json = Email_Tracking::all();
            return $json;
        }
        return redirect()->route('e401');
    }

    /**
     * postReportsJson
     * Posts data queried from reports table. Requires authenticated user to execute data retrieval.
     *
     * @return  array|\Illuminate\Http\RedirectResponse
     */
    public static function postReportsJson() {
        if(Auth::check()) {
            $json = Reports::all();
            return $json;
        }
        return redirect()->route('e401');
    }

    public static function emailTrackingCSV() {
        $json = Email_Tracking::all();
        $path = 'C:\Users\tyler\Documents\emailTracking.csv';
        $array = json_decode($json, true);
        $f = fopen($path, 'w+');

        $arrays = self::baseCSV($array, $f);
        foreach($arrays as $array) {
            fputcsv($f, $array);
        }

        header("Content-Type: application/octet-stream");
        header("Content-Description: File Transfer");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Disposition: attachment; filename=\"" . basename($path) . "\"");
        readfile($path);
    }

    public static function websiteTrackingCSV() {
        $json = Website_Tracking::all();
        $path = 'C:\Users\tyler\Documents\websiteTracking.csv';
        $array = json_decode($json, true);
        $f = fopen($path, 'w+');

        $arrays = self::baseCSV($array, $f);
        for($i = 0; $i < sizeof($array); $i++) {
            $temp = array_slice($arrays[$i],0,1,true) + array('BrowserAgent' => $array[$i]['BrowserAgent']) + array('ReqPath' => $array[$i]['ReqPath']) + array_slice($arrays[$i],1,count($arrays) - 1, true);
            $arrays[$i] = $temp;
            fputcsv($f, $arrays[$i]);
        }

        header("Content-Type: application/octet-stream");
        header("Content-Description: File Transfer");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Disposition: attachment; filename=\"" . basename($path) . "\"");
        readfile($path);
    }

    private static function baseCSV($array, $f) {
        $arrays = array();
        $firstLineKeys = false;
        foreach($array as $line) {
            if(empty($firstLineKeys)) {
                $firstLineKeys = array_keys($line);
                fputcsv($f, $firstLineKeys);
                $firstLineKeys = array_flip($firstLineKeys);
            }
            $line_array = array($line['Ip']);
            array_push($line_array,$line['Host']);
            array_push($line_array,$line['UserId']);
            array_push($line_array,$line['CampaignId']);
            array_push($line_array,$line['Timestamp']);
            array_push($arrays, $line_array);
        }

        return $arrays;
    }
}
