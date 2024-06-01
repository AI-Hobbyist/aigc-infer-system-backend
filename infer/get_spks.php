<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function get_spks($category, $brand, $name) {
    global $db;
    $cat = strtolower($category);
    $bra = strtolower($brand);
    if ($name != "" && $category != "" && $brand != "") {
        $is_exist = $db-> check_type($category, $brand, $name);
        if ($is_exist) {
            $urls = $db->get_url($cat, $bra, $name);
            $spk_url = $urls[0]."/".$urls[1];
            $data = POSTDATA::getContent($spk_url);
            if ($data[0] == 200){
                $spk_list = json_decode($data[1]);
                $msg = "说话人列表获取成功！";
            }else{
                $msg = "由于一些问题，无法访问当前说话人列表";
            }
        } else {
            $msg = "符合指定条件的后端不存在或已被删除！";
        }
    } else {
        $msg = "项目类型、项目名称、模型名称均不能为空！";
    }
    return array($msg, $spk_list);
}