<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function update_server($user_token, $id, $server, $name, $category, $brand, $appkey, $spkurl, $inferurl, $note) {
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
            if ($id != "" && $server != "" && $name != "" && $category != "" && $brand != "" && $spkurl !="" && $inferurl != "") {
                $is_exist = $db-> server_id_exist($id);
                $is_server_exist = $db->check_server_id($server, $id);
                $is_api_exist = $db-> check_backend_id($name, $bra, $id);
                if ($is_exist) {
                    if (!$is_server_exist) {
                        if (!$is_api_exist) {
                            if (check_support($cat, $bra)) {
                                $db->update_server($id, $server, $name, $cat, $bra, $appkey, $spkurl, $inferurl, $note);
                                $msg = "更新成功！";
                            } else {
                                $msg = "更新失败，分类 $category 里面没有名为 $bra 的项目！";
                            }
                        } else {
                            $msg = "基于项目 $brand 的 $category 推理后端 $name 已存在！";
                        }
                    } else {
                        $msg = "推理服务器 $server 已存在！";
                    }
                } else {
                    $msg = "该后端不存在或已被删除！";
                }
            } else {
                $msg = "后端 id、服务器地址、名称、项目类型、项目名称、说话人列表接入点，推理接入点均不能为空！";
            }
        }
    }
    return $msg;
}