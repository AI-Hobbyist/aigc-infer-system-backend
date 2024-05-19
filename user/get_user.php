<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function get_user($user_token){
    global $db;
    $access_token = 0;
    $uid = $username = $email = $isadmin = $ip = $avatar = $reg = $last_login = 0;
    if ($db->get_user_token($user_token) == ""){
        $msg = "用户令牌错误！";
    }else{
        $uid = $db->get_uid_by_user_token($user_token);
        $user_info = $db->get_info_by_uid($uid);
        $id = $user_info[0];
        $username = $user_info[1];
        $email = $user_info[2];
        $isadmin = $user_info[3];
        $ip = $user_info[4];
        $avatar = $user_info[5];
        $reg = $user_info[6];
        $last_login = $user_info[7];
        $access_token = $db->get_access_token($user_token);
        $msg = "获取成功！";
    }
    $reg_time = date("Y-m-d H:i:s",$reg);
    $login_time = date("Y-m-d H:i:s",$last_login);
    return array($id, $username, $email, $isadmin, $ip, $avatar, $reg_time, $login_time, $access_token, $msg);
}