<?php

namespace App\Http\Controllers;

use App\Libraries\Cryptor;
use App\Models\Email_Tracking;
use App\Models\Sessions;
use App\Models\User;
use App\Models\Website_Tracking;
use App\Http\Controllers\AuthController As Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('id', $sessionId)->first();

        if(empty($session)) {
            abort('500');
        }

        $user = User::where('id',$session->user_id)->first();

        if(empty($user)) {
            abort('500');
        }

        $campaignId = $request->input('campaignIdSelect');
        $userId = $request->input('userIdText');
        $ip = $request->input('ipText');
        $ipExact = $request->input('ipExactToggle');
        $timestampStart = $request->input('timestampStart');
        $timestampEnd = $request->input('timestampEnd');
        $array = array($campaignId, $userId, $ip, $ipExact, $timestampStart, $timestampEnd);

        if($user->company_id !== 1) {
            $where = array();
            if(!empty($array[0])) {
                array_push($where,['email_tracking.campaign_id','=',$array[0]]);
            }
            if(!empty($array[1])) {
                array_push($where,['email_tracking.user_id','=',$array[1]]);
            }
            if(!empty($array[3]) && !empty($array[2])) {
                array_push($where,['email_tracking.ip_address','LIKE',$array[2]]);
            }
            else if(empty($array[3]) && !empty($array[2])) {
                array_push($where,['email_tracking.ip_address','=',$array[2]]);
            }
            if(!empty($array[4])) {
                array_push($where,['email_tracking.timestamp','>=',$array[4]]);
            }
            if(!empty($array[5])) {
                array_push($where,['email_tracking.timestamp','<=',$array[5]]);
            }
            array_push($where,['companies.id','=',$user->company_id]);
            $json = DB::table('email_tracking')
                ->leftJoin('mailing_list','email_tracking.user_id','mailing_list.id')
                ->leftJoin('companies','mailing_list.company_id','companies.id')
                ->select('email_tracking.ip_address','email_tracking.host','email_tracking.timestamp',
                    'mailing_list.first_name','mailing_list.last_name')
                ->where($where)
                ->orderBy('mailing_list.id', 'asc')
                ->orderBy('companies.name','asc')
                ->get();

        } else {
            $where = array();
            if(!empty($array[0])) {
                array_push($where,['email_tracking.campaign_id','=',$array[0]]);
            }
            if(!empty($array[1])) {
                array_push($where,['email_tracking.user_id','=',$array[1]]);
            }
            if(!empty($array[3]) && !empty($array[2])) {
                array_push($where,['email_tracking.ip_address','LIKE',$array[2]]);
            }
            else if(empty($array[3]) && !empty($array[2])) {
                array_push($where,['email_tracking.ip_address','=',$array[2]]);
            }
            if(!empty($array[4])) {
                array_push($where,['email_tracking.timestamp','>=',$array[4]]);
            }
            if(!empty($array[5])) {
                array_push($where,['email_tracking.timestamp','<=',$array[5]]);
            }
            $json = DB::table('email_tracking')
                ->leftJoin('mailing_list','email_tracking.user_id','mailing_list.id')
                ->leftJoin('companies','mailing_list.company_id','companies.id')
                ->select('email_tracking.ip_address','email_tracking.host','email_tracking.timestamp',
                    'mailing_list.first_name','mailing_list.last_name','companies.name')
                ->where($where)
                ->orderBy('mailing_list.id', 'asc')
                ->orderBy('companies.name','asc')
                ->get();
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
     * @return  \Illuminate\Http\RedirectResponse | resource | string
     */
    public static function generateWebsiteReport(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('e401');
        }

        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('id', $sessionId)->first();

        if(empty($session)) {
            Auth::logout();
        }

        $user = User::where('id',$session->user_id)->first();

        if(empty($user)) {
            Auth::logout();
        }

        $campaignId = $request->input('campaignIdSelect');
        $userId = $request->input('userIdText');
        $ip = $request->input('ipText');
        $ipExact = $request->input('ipExactToggle');
        $timestampStart = $request->input('timestampStart');
        $timestampEnd = $request->input('timestampEnd');
        $array = array($campaignId, $userId, $ip, $ipExact, $timestampStart, $timestampEnd);

        if($user->company_id !== 1) {
            $where = array();
            if(!empty($array[0])) {
                array_push($where,['website_tracking.campaign_id','=',$array[0]]);
            }
            if(!empty($array[1])) {
                array_push($where,['website_tracking.user_id','=',$array[1]]);
            }
            if(!empty($array[3]) && !empty($array[2])) {
                array_push($where,['website_tracking.ip_address','LIKE',$array[2]]);
            }
            else if(empty($array[3]) && !empty($array[2])) {
                array_push($where,['website_tracking.ip_address','=',$array[2]]);
            }
            if(!empty($array[4])) {
                array_push($where,['website_tracking.timestamp','>=',$array[4]]);
            }
            if(!empty($array[5])) {
                array_push($where,['website_tracking.timestamp','<=',$array[5]]);
            }
            array_push($where,['companies.id','=',$user->company_id]);
            $json = DB::table('website_tracking')
                ->leftJoin('mailing_list','website_tracking.user_id','mailing_list.id')
                ->leftJoin('companies','mailing_list.company_id','companies.id')
                ->select('website_tracking.ip_address','website_tracking.host','website_tracking.timestamp',
                    'mailing_list.first_name','mailing_list.last_name',
                    'website_tracking.browser_agent','website_tracking.req_path')
                ->where($where)
                ->orderBy('mailing_list.id', 'asc')
                ->orderBy('companies.name','asc')
                ->get();

        } else {
            $where = array();
            if(!empty($array[0])) {
                array_push($where,['website_tracking.campaign_id','=',$array[0]]);
            }
            if(!empty($array[1])) {
                array_push($where,['website_tracking.user_id','=',$array[1]]);
            }
            if(!empty($array[3]) && !empty($array[2])) {
                array_push($where,['website_tracking.ip_address','LIKE',$array[2]]);
            }
            else if(empty($array[3]) && !empty($array[2])) {
                array_push($where,['website_tracking.ip_address','=',$array[2]]);
            }
            if(!empty($array[4])) {
                array_push($where,['website_tracking.timestamp','>=',$array[4]]);
            }
            if(!empty($array[5])) {
                array_push($where,['website_tracking.timestamp','<=',$array[5]]);
            }
            $json = DB::table('website_tracking')
                ->leftJoin('mailing_list','website_tracking.user_id','mailing_list.id')
                ->leftJoin('companies','mailing_list.company_id','companies.id')
                ->select('website_tracking.ip_address','website_tracking.host','website_tracking.timestamp',
                    'mailing_list.first_name','mailing_list.last_name','companies.name',
                    'website_tracking.browser_agent','website_tracking.req_path')
                ->where($where)
                ->orderBy('mailing_list.id', 'asc')
                ->orderBy('companies.name','asc')
                ->get();
        }

        $path = 'temp\websiteTracking.csv';
        $array = json_decode($json, true);
        $f = fopen($path, 'w+');

        $arrays = self::generateCSVArray($array, $f);

        for($i = 0; $i < sizeof($array); $i++) {
            $temp = array_slice($arrays[$i],0,1,true) + array('browser_agent' => $array[$i]['browser_agent']) + array('req_path' => $array[$i]['req_path']) + array_slice($arrays[$i],1,count($arrays) - 1, true);
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
            $line_array = array($line['ip_address']);
            array_push($line_array,$line['host']);
            array_push($line_array,$line['timestamp']);
            array_push($line_array,$line['first_name']);
            array_push($line_array,$line['last_name']);
            array_push($line_array,$line['name']);
            array_push($arrays, $line_array);
        }

        return $arrays;
    }
}