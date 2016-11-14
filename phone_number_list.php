<?php
        $data = $_GET['From'];
        $filename = 'phone_number_list.txt';
        $file = fopen('phone_number_list.txt', 'a');

        if(!is_number_added($data)){
                if(0 == filesize($filename)){
                        fwrite($file, $data);
                 }else{
                        fwrite($file, ','.$data);
                 }
        }
        fclose($file);

        function is_number_added($number){
            $numbers = file_get_contents("phone_number_list.txt");
            $number_list = explode(",", $numbers);
            for($i = 0; $i < sizeOf($number_list); $i++){
                if($number == $number_list[$i]){
                    return true;
                }
            }

            return false;
        }

?>