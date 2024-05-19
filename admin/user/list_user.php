<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function list_user($user_token) {
    global $db;
    $user_list = array();
    if ($db->get_user_token($user_token) == "") {
        $msg = "用户令牌错误！";
    } else {
        $group = $db->get_group($user_token);
        if ($group < 1) {
            $msg = "无权进行该操作！";
            $user_list = null;
        } else {
            $index = 0;
            $row_num = $db->get_data_num("users");
            if ($row_num != 0) {
                while ($index <= $row_num) {
                    $users = $db->get_user_list($index);
                    $user_data = array(
                        "uid" => $users[0],
                        "username" => $users[1],
                        "email" => $users[2],
                        "isadmin" => $users[3],
                        "ip" => $users[4],
                        "avatar" => $users[5],
                        "reg_time" => date("Y-m-d H:i:s", $users[6]),
                        "last_login" => date("Y-m-d H:i:s", $users[7])
                    );
                    if ($users[0] != '') {
                        array_push($user_list, $user_data);
                    }
                    $index++;
                }
                $msg = "用户列表获取成功！";
            }else{
                $msg = "当前没有任何用户";
            }
        }
    }
    return array($msg, $user_list);
}