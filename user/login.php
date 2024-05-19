<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function login($account,$password,$ip){
    global $db;
    $user_token = 0;
    if ($account != "" && $password != ""){
        $user_info = $db->get_ucenter_user($account);
        $md5_pass = md5(md5($password).$user_info[4]);
        if ($md5_pass == $user_info[2] || password_verify($password,$user_info[2]) == true){
            if($md5_pass == $user_info[2]){
                $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
                $db->upgrade_pass_to_bcrypt($user_info[0],$hashed_pass);
                $password = $hashed_pass;
            }else if (password_verify($password,$user_info[2])){
                $password = $user_info[2];
            }
            if ($db->get_uid($user_info[0]) == ""){
                $db->create_user($user_info[0],$user_info[1],$user_info[3],$password,$ip);
            }else{
                $db->update_user($user_info[0],$user_info[1],$user_info[3],$password,$ip);
            }
            $user_token = $db->get_user_token_by_uid($user_info[0]);
            $msg = "登录成功！";
        }else{
            $msg = "用户名或密码错误！";
        }
    }else{
        $msg = "账号或密码不得为空！";
    }
    return array($user_token,$msg);
}