<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function check_token($user_token){
    global $db;
    $status = 0;
    if ($db->get_user_token($user_token) == ""){
        $msg = "用户令牌错误！";
    }else{
        if ($db->token_status($user_token)){
            $status = 1;
        }
    }
    return $status;
}