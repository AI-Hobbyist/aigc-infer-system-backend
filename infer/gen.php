<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/classes.php');
function gen_audio($access_token, $category, $brand, $name, $prarms){
    global $db;
    $cat = strtolower($category);
    $bra = strtolower($brand);
    if (!$db->check_access($access_token)) {
        $msg = "访问令牌无效！";
    }else if ($cat != "" && $bra != "" && $name != "" && $prarms != ""){
        $is_exist = $db-> check_type($category, $brand, $name);
        if ($is_exist){
            $infer = $db-> get_infer_prarm($category, $brand, $name);
            $prarms["app_key"] = $infer[0];
            $infer_data = json_encode($prarms);
            $res = POSTDATA::json($infer[1].$infer[2], $infer_data);
            if($res[0] == 200){
                $res_data = json_decode($res[1],true);
                $msg = $res_data['msg'];
                $audio_url = $res_data['audio'];
            }else{
                $msg = "由于一些问题，无法访问推理后端";
            }
            
        } else {
            $msg = "符合指定条件的后端不存在或已被删除！";
        }
    }else{
        $msg = "访问令牌、项目类型、项目名称、模型名称、推理参数均不得为空！";
    }
    return array($msg, $audio_url);
}