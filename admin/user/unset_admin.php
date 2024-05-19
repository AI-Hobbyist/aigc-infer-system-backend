<?php
function unset_admin($user_token, $uid) {
    global $db;
    $user_list = array();
    if ($db->get_user_token($user_token) == "") {
        $msg = "用户令牌错误！";
    } else {
        $group = $db->get_group($user_token);
        if ($group < 1) {
            $msg = "无权进行该操作！";
        } else {
            $user_info = $db->get_info_by_uid($uid);
            if ($user_info[0] != '') {
                $dst_user_token = $db->get_user_token_by_uid($uid);
                if ($user_token == $dst_user_token){
                    $msg = "无法取消自己的管理员身份！";
                }else if ($user_info[3] != 1) {
                    $msg = "当前用户不是是管理员，无需操作！";
                }else{
                    $db->unset_admin($uid);
                     $msg = "已将取消管理员身份！";
                }
            }else{
                $msg = "该用户不存在或已被删除！";
            }
        }
    }
    return $msg;
}