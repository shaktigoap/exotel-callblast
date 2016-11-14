<?php
        $config = include('call_blast_config.php');
        $numbers = file_get_contents("phone_number_list.txt");
    $number_list = explode(",", $numbers);


    if(is_odd($number_list)){
        array_push($number_list, $config['extra_number']);
    }

        shuffle($number_list);


        for($i = 0; $i < sizeOf($number_list); $i+=2){
                if($i + 1 == sizeOf($number_list)){
                        return;
                }
                make_call($number_list[$i], $number_list[$i + 1]);
        }

        function is_odd($number_list){
                if(sizeOf($number_list)/2 == 0){
                        return false;
                }
                return true;
        }

function make_call($from, $to){
        $post_data = array(
    'From' => $from,
    'To' => $to,
    'CallerId' => $config['exo_phone'],
    'TimeLimit' => "",
    'TimeOut' => "",
    'CallType' => "trans" //Can be "trans" for transactional and "promo" for promotional content
        );

        $exotel_sid = $config['exotel_sid']; // Your Exotel SID - Get it from here: http://my.exotel.in/settings/site#api-settings
        $exotel_token = $config['exotel_token']; // Your exotel token - Get it from here: http://my.exotel.in/settings/site#api-settings

        $url = "https://".$exotel_sid.":".$exotel_token."@twilix.exotel.in/v1/Accounts/".$exotel_sid."/Calls/connect";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));

        $http_result = curl_exec($ch);
        $error = curl_error($ch);
        $http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);

        curl_close($ch);

        //print "Response = ".print_r($http_result);
}