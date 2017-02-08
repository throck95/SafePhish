<?php

namespace App\Http\Controllers;

use App\Models\Email_Tracking;
use App\Models\Website_Tracking;
use App\Http\Controllers\AuthController As Auth;
use Illuminate\Http\Request;

class CSVController extends Controller
{
    /**
     * generateEmailReport
     * Defines the query to retrieve the report data then triggers a CSV download response.
     *
     * @param   Request         $request
     * @return  \Illuminate\Http\RedirectResponse | resource
     */
    public static function generateEmailReport(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('e401');
        }

        $campaignId = $request->input('campaignIdSelect');
        $userId = $request->input('userIdText');
        $ip = $request->input('ipText');
        $ipExact = $request->input('ipExactToggle');
        $timestampStart = $request->input('timestampStart');
        $timestampEnd = $request->input('timestampEnd');
        $array = array($campaignId, $userId, $ip, $ipExact, $timestampStart, $timestampEnd);

        if(empty($campaignId) && empty($userId) && empty($ip) && empty($ipExact) && empty($timestampStart) && empty($timestampEnd)) {
            $json = Email_Tracking::all();
        }
        else {
            $json = Email_Tracking::where(function($q) use ($array) {
                if(!empty($array[0])) {
                    $q->where('CampaignId',$array[0]);
                }
                if(!empty($array[1])) {
                    $q->where('UserId',$array[1]);
                }
                if(!empty($array[3]) && !empty($array[2])) {
                    $q->where('Ip','LIKE',$array[2]);
                }
                else if(empty($array[3]) && !empty($array[2])) {
                    $q->where('Ip',$array[2]);
                }
                if(!empty($array[4])) {
                    $q->where('Timestamp','>=',$array[4]);
                }
                if(!empty($array[5])) {
                    $q->where('Timestamp','<=',$array[5]);
                }
            })->get();
        }

        $path = 'temp\emailTracking.csv';
        $array = json_decode($json, true);
        $f = fopen($path, 'w+');

        $arrays = self::generateCSVArray($array, $f);
        foreach($arrays as $array) {
            fputcsv($f, $array);
        }

        header("Content-Type: application/octet-stream");
        header("Content-Description: File Transfer");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Disposition: attachment; filename=\"" . basename($path) . "\"");
        readfile($path);
    }

    /**
     * generateWebsiteReport
     * Defines the query to retrieve the report data then triggers a CSV download response.
     *
     * @param   Request         $request
     * @return  \Illuminate\Http\RedirectResponse | resource
     */
    public static function generateWebsiteReport(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('e401');
        }

        $campaignId = $request->input('campaignIdSelect');
        $userId = $request->input('userIdText');
        $ip = $request->input('ipText');
        $ipExact = $request->input('ipExactToggle');
        $timestampStart = $request->input('timestampStart');
        $timestampEnd = $request->input('timestampEnd');
        $array = array($campaignId, $userId, $ip, $ipExact, $timestampStart, $timestampEnd);

        if(empty($campaignId) && empty($userId) && empty($ip) && empty($ipExact) && empty($timestampStart) && empty($timestampEnd)) {
            $json = Website_Tracking::all();
        }
        else {
            $json = Website_Tracking::where(function($q) use ($array) {
                if(!empty($array[0])) {
                    $q->where('CampaignId',$array[0]);
                }
                if(!empty($array[1])) {
                    $q->where('UserId',$array[1]);
                }
                if(!empty($array[3]) && !empty($array[2])) {
                    $q->where('Ip','LIKE',$array[2]);
                }
                else if(empty($array[3]) && !empty($array[2])) {
                    $q->where('Ip',$array[2]);
                }
                if(!empty($array[4])) {
                    $q->where('Timestamp','>=',$array[4]);
                }
                if(!empty($array[5])) {
                    $q->where('Timestamp','<=',$array[5]);
                }
            })->get();
        }
        $path = 'temp\websiteTracking.csv';
        $array = json_decode($json, true);
        $f = fopen($path, 'w+');

        $arrays = self::generateCSVArray($array, $f);
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

    /**
     * generateCSVArray
     * Returns an array of arrays. Each array stores a line of the report.
     *
     * @param   array       $array
     * @param   resource    $f
     * @return  array
     */
    private static function generateCSVArray($array, $f) {
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