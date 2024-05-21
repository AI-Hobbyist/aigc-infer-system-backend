<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function list_servers($user_token) {
    global $db;
    $server_list = array();
    if ($db->get_user_token($user_token) == "" || !$db->token_status($user_token)) {
        $msg = "用户令牌无效！";
    } else {
        $group = $db->get_group($user_token);
        if ($group < 1) {
            $msg = "无权进行该操作！";
            $server_list = null;
        } else {
            $index = 0;
            $row_num = $db->get_data_num("apis");
            if ($row_num != 0) {
                while ($index <= $row_num) {
                    $servers = $db->get_server_list($index);
                    $server_data = array(
                        "id" => $servers[0],
                        "server" => $servers[1],
                        "name" => $servers[2],
                        "added_by" => $servers[3],
                        "category" => $servers[4],
                        "brand" => $servers[5],
                        "appkey" => $servers[6],
                        "note" => $servers[7],
                        "added_at" => date("Y-m-d H:i:s", $servers[8])
                    );
                    if ($servers[0] != '') {
                        array_push($server_list, $server_data);
                    }
                    $index++;
                }
                $msg = "后端列表获取成功！";
            }else{
                $msg = "当前没有推理后端";
            }
        }
    }
    return array($msg, $server_list);
}
