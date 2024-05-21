<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function set_admin($user_token, $uid) {
    if ($db->get_user_token($user_token) == "" || !$db->token_status($user_token)) {
        $msg = "用户令牌无效！";
    } else {
        if ($uid != "") {
            $group = $db->get_group($user_token);
            if ($group < 1) {
                $msg = "无权进行该操作！";
            } else {
                $user_info = $db->get_info_by_uid($uid);
                if ($user_info[0] != '') {
                    if ($user_info[3] == 1) {
                        $msg = "当前用户已经是管理员，无需操作！";
                    } else {
                        $db->set_admin($uid);
                        $msg = "已将用户设成管理员！";
                    }
                } else {
                    $msg = "该用户不存在或已被删除！";
                }

            }
        } else {
            $msg = "用户 uid 不能为空！";
        }
        
    }
    return $msg;
}