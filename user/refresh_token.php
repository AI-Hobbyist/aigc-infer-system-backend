<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function refresh_token($user_token,$ip){
    global $db;
    $access_token = 0;
    if ($db->get_user_token($user_token) == "" || !$db->token_status($user_token)){
        $msg = "用户令牌无效！";
    }else{
        $access_token = $db->refresh_access_token($user_token);
        $db->updata_last_login($db->get_uid_by_user_token($user_token),$ip);
        $msg = "刷新成功！";
    }
    return array($access_token, $msg);
}