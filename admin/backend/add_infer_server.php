<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
include($_SERVER['DOCUMENT_ROOT'].'/include/functions.php');
function add_infer_server($user_token, $server, $name, $category, $brand, $appkey, $note) {
    global $db;
    $cat = strtolower($category);
    $bra = strtolower($brand);
    if ($db->get_user_token($user_token) == "" || !$db->token_status($user_token)) {
        $msg = "用户令牌无效！";
    } else {
        $group = $db->get_group($user_token);
        if ($group < 1) {
            $msg = "无权进行该操作！";
        } else {
            $uid = $db->get_uid_by_user_token($user_token);
            $user_info = $db->get_info_by_uid($uid);
            if ($server != "" && $name != "" && $cat != "" && $brand != "") {
                $is_server_exist = $db->check_server($server);
                $is_api_exist = $db-> check_backend($name, $bra);
                if (!$is_server_exist) {
                    if (!$is_api_exist) {
                        if (check_support($cat, $bra)) {
                            $db->add_infer_server($server, $name, $user_info[1], $cat, $bra, $appkey, $note);
                            $msg = "添加成功！";
                        } else {
                            $msg = "添加失败，分类 $category 里面没有名为 $bra 的项目！";
                        }
                    }else{
                        $msg = "基于项目 $brand 的 $category 推理后端 $name 已存在！";
                    }
                } else {
                    $msg = "推理服务器 $server 已存在！";
                }
            } else {
                $msg = "服务器地址、服务器名、项目类型、项目名称不能为空！";
            }
        }
    }
    return $msg;
}