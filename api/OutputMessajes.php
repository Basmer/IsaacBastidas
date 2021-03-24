<?php

define('INVALIDATE_FORM', 0x0000fa1);
define('SUCCESS', 0x0000fc11);
class OutputMessajes
{



    public static function sendMesage($code, $title, $message, $extras = []) {
        header('Content-Type: application/json');
        echo json_encode( ['code' => (int) $code, 'title' => $title, 'messsage' => $message, 'extras' => $extras]);
    }

}
