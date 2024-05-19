<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function delete_server($user_token, $id) {
    global $db;
    if ($db->get_user_token($user_token) == "") {
        $msg = "用户令牌错误！";
    } else {
        $group = $db->get_group($user_token);
        if ($group < 1) {
            $msg = "无权进行该操作！";
        } else {
            if ($id != "") {
                $is_exist = $db-> server_id_exist($id);
                if ($is_exist) {
                    $db->delete_server($id);
                    $msg = "删除成功！";
                } else {
                    $msg = "该后端不存在或已被删除！";
                }
            } else {
                $msg = "后端 id 不能为空！";
            }
        }
    }
    return $msg;
}