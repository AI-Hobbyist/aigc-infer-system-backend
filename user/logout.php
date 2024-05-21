<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function logout($user_token){
    global $db;
    if ($db->get_user_token($user_token) == ""  || !$db->token_status($user_token)){
        $msg = "用户令牌无效或已退出登录！";
    }else{
        $db->user_logout($user_token);
        $msg = "已退出登录！";
    }
    return $msg;
}
