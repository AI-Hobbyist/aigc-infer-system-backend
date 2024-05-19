<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/functions.php');
$apitype = $_GET['type'];
$actmode = $_GET['mode'];
$id = $_GET['id'];
$ip = $_SERVER["REMOTE_ADDR"];
$method = $_SERVER['REQUEST_METHOD'];
//API模式
switch ($apitype) {
    case 'user';
        switch ($actmode) {
            //登录验证
        case 'login';
            if ($method == "POST") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $login = login($data["account"], $data["password"], $ip);
                $login_data = array("user_token" => $login[0], "message" => $login[1]);
                echo json_encode($login_data, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;

            //获取Access Token
        case 'refresh_token';
            if ($method == "POST") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $refresh = refresh_token($data["user_token"], $ip);
                $token_data = array("access_token" => $refresh[0], "message" => $refresh[1]);
                echo json_encode($token_data, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;

            //获取用户信息
        case 'get_user';
            if ($method == "GET") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $user = get_user($data["user_token"]);
                $user_data = array("uid" => $user[0], "username" => $user[1], "email" => $user[2], "isadmin" => $user[3], "ip" => $user[4], "avatar" => $user[5], "reg_time" => $user[6], "last_login" => $user[7], "access_token" => $user[8], "message" => $user[9]);
                echo json_encode($user_data, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;
        }
        break;
    case 'admin';
        switch ($actmode) {
            //列出用户
        case 'list_user';
            if ($method == "GET") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $users = list_user($data["user_token"]);
                $user_list = array("message" => $users[0], "user_list" => $users[1]);
                echo json_encode($user_list, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;

            //设为管理
        case 'set_admin';
            if ($method == "POST") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $set_admin = set_admin($data["user_token"], $id);
                $res = array("message" => $set_admin);
                echo json_encode($res, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;

            //取消管理
        case 'unset_admin';
            if ($method == "POST") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $unset_admin = unset_admin($data["user_token"], $id);
                $res = array("message" => $unset_admin);
                echo json_encode($res, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;

            //添加推理后端
        case 'add_infer_server';
            if ($method == "POST") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $add_infer_server = add_infer_server($data["user_token"], $data["server"], $data["prarm"]["name"], $data["prarm"]["category"], $data["prarm"]["brand"], $data["prarm"]["appkey"], $data["prarm"]["note"]);
                $res = array("message" => $add_infer_server);
                echo json_encode($res, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;

            //列出推理后端
        case 'list_infer_server';
            if ($method == "GET") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $servers = list_servers($data["user_token"]);
                $server_list = array("message" => $servers[0], "server_list" => $servers[1]);
                echo json_encode($server_list, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;

            //修改推理后端
        case 'update_infer_server';
            if ($method == "POST") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $update_infer_server = update_server($data["user_token"], $id, $data["prarm"]["server"], $data["prarm"]["name"], $data["prarm"]["category"], $data["prarm"]["brand"], $data["prarm"]["appkey"], $data["prarm"]["note"]);
                $res = array("message" => $update_infer_server);
                echo json_encode($res, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;

            //删除推理后端
        case 'del_infer_server';
            if ($method == "POST") {
                header('content-type:application/json;charset=utf8');
                $data = json_decode(file_get_contents('php://input'), true, 10);
                $del_infer_server = delete_server($data['user_token'], $id);
                $res = array("message" => $del_infer_server);
                echo json_encode($res, JSON_PRETTY_PRINT);
            } else {
                exceptions::doErr(405, 'HTTP/1.1 405 Method not allowed', '不支持该请求方法');
            }
            break;
        }
        break;
    case 'infer';
        switch ($actmode) {
            //获取说话人
        case 'get_spks';
            header('content-type:application/json;charset=utf8');
            $data = json_decode(file_get_contents('php://input'), true, 10);

            break;

            //推理
        case 'gen';
            header('content-type:application/json;charset=utf8');
            $data = json_decode(file_get_contents('php://input'), true, 10);

            break;
        }
        break;
}
?>