<?php
class database {
    public $mysqli;
    function __construct() {
        global $host,$port,$user,$pass;
        $iscon = mysqli_connect($host.":".$port, $user, $pass);
        if (!$iscon) {
            echo "无法连接至MySQL数据库：".mysqli_connect_error();
            header(Exceptions::$codes[500]);
            die();
        }
        $this->mysqli = new mysqli($host.":".$port, $user, $pass);
    }
    function query($sql) {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt == false) {
            echo "MySQL查询出错：".$this->mysqli->error;
            header(Exceptions::$codes[500]);
            return -1;
        }
        $stmt->execute();
        $ret = $stmt->get_result();
        $result = $ret->fetch_all();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    function query_change($sql) {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt == false) {
            echo "MySQL查询出错：".$this->mysqli->error;
            header(Exceptions::$codes[500]);
            return -1;
        }
        $stmt->execute();
        $ret = $stmt->get_result();
        $result = $this->mysqli->affected_rows;
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    //参考，无用//
    /*function getNameByUuid($uuid) {
        global $luckperms;
        $from_luckperm = $this->query("select username from ".$luckperms.".luckperms_players where uuid = '".$uuid."'");
        if ($from_luckperm[0][0]) {
            return $from_luckperm[0][0];
        } else {
            return false;
        }
    }*/
    #==============数据查询==============
    #获取Ucenter用户数据
    function get_ucenter_user($account) {
        global $userdata;
        $res = $this->query("select * from $userdata.pre_ucenter_members where email='$account'");
        if ($res[0][5] == "") {
            $res = $this->query("select * from $userdata.pre_ucenter_members where username='$account'");
        }
        return array($res[0][0], $res[0][1], $res[0][2], $res[0][5], $res[0][12]);
    }

    #根据用户数据库uid获取推理平台用户uid
    function get_uid($uid) {
        global $appdata;
        $res = $this->query("select uid from $appdata.users where uid='$uid'");
        return $res[0][0];
    }

    #根据用户令牌获取推理平台用户uid
    function get_uid_by_user_token($user_token) {
        global $appdata;
        $res = $this->query("select uid from $appdata.tokens where user_token='$user_token'");
        return $res[0][0];
    }

    #根据uid获取用户令牌
    function get_user_token_by_uid($uid) {
        global $appdata;
        $res = $this->query("select user_token from $appdata.tokens where uid='$uid'");
        return $res[0][0];
    }

    #根据用户uid获取用户信息
    function get_info_by_uid($uid) {
        global $appdata;
        $res = $this->query("select * from $appdata.users where uid='$uid'");
        return array($res[0][1], $res[0][2], $res[0][3], $res[0][5], $res[0][6], $res[0][7], $res[0][8], $res[0][9]);
    }

    #获取用户令牌
    function get_user_token($user_token) {
        global $appdata;
        $res = $this->query("select * from $appdata.tokens where user_token='$user_token'");
        return $res[0][2];
    }

    #获取访问令牌
    function get_access_token($user_token) {
        global $appdata;
        $res = $this->query("select access_token from $appdata.tokens where user_token='$user_token'");
        return $res[0][0];
    }

    #获取用户组
    function get_group($user_token) {
        global $appdata;
        $uid = $this->get_uid_by_user_token($user_token);
        $group = $this->query("select isadmin from $appdata.users where uid='$uid'");
        return $group[0][0];
    }

    #获取数据条数
    function get_data_num($table) {
        global $appdata;
        $res = $this->query("SELECT COUNT(*) as count FROM $appdata.$table");
        return $res[0][0];
    }

    #判断同名且同类型的后端是否存在
    function check_backend($name, $brand) {
        global $appdata;
        $res = $this->query("select name, brand from $appdata.apis where name='$name' and brand = '$brand'");
        if (!empty($res)) {
            return true;
        } else {
            return false;
        }
    }

    #判断id不同但是同名且同类型的后端是否存在
    function check_backend_id($name, $brand, $id) {
        global $appdata;
        $res = $this->query("select name, brand from $appdata.apis where name='$name' and brand = '$brand' and id != '$id'");
        if (!empty($res)) {
            return true;
        } else {
            return false;
        }
    }

    #判断指定的推理后端服务器是否存在
    function check_server($server) {
        global $appdata;
        $res = $this->query("select name, brand from $appdata.apis where server='$server'");
        if (!empty($res)) {
            return true;
        } else {
            return false;
        }
    }

    #判断id不同但是同一个url的推理后端服务器是否存在
    function check_server_id($server, $id) {
        global $appdata;
        $res = $this->query("select name, brand from $appdata.apis where server='$server' and id !='$id'");
        if (!empty($res)) {
            return true;
        } else {
            return false;
        }
    }

    #判断指定id的推理后端服务器是否存在
    function server_id_exist($id) {
        global $appdata;
        $res = $this->query("select name, brand from $appdata.apis where id='$id'");
        if (!empty($res)) {
            return true;
        } else {
            return false;
        }
    }

    #==============用户操作==============
    #将密码加密方式升级为Bcrypt
    function upgrade_pass_to_bcrypt($uid, $password) {
        global $userdata;
        $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
        $this->query_change("update $userdata.pre_ucenter_members set password='$hashed_pass' where uid='$uid'");
    }

    #更新部分用户信息
    function updata_last_login($uid, $ip) {
        global $appdata;
        $last_login = time();
        $this->query_change("update $appdata.users set ip='$ip', last_login='$last_login' where uid='$uid'");
    }

    #创建用户
    function create_user($uid, $username, $email, $password, $ip) {
        global $appdata,
        $avatar_api;
        $reg = $last_login = time();
        $avatar = $avatar_api.$uid;
        $this->query_change("insert into $appdata.users (uid, username, email, password, ip, avatar, reg, last_login) values ('$uid', '$username', '$email', '$password', '$ip', '$avatar', '$reg', '$last_login')");
        $hash_mehod = 'sha256';
        $user_token = md5(hash($hash_mehod, hash($hash_mehod, $username).hash($hash_mehod, $email).hash($hash_mehod, $password)));
        $access_token = md5(hash($hash_mehod, hash($hash_mehod, $user_token).rand()).time());
        $this->query_change("insert into $appdata.tokens (uid, user_token, access_token) values ('$uid', '$user_token', '$access_token')");
    }

    #更新用户
    function update_user($uid, $username, $email, $password, $ip) {
        global $appdata,
        $avatar_api;
        $last_login = time();
        $avatar = $avatar_api.$uid;
        $this->query_change("update $appdata.users set username='$username', email='$email', password='$password', ip='$ip', avatar='$avatar', last_login='$last_login' where uid='$uid'");
        $hash_mehod = 'sha256';
        $user_token = md5(hash($hash_mehod, hash($hash_mehod, $username).hash($hash_mehod, $email).hash($hash_mehod, $password)));
        $this->query_change("update $appdata.tokens set user_token='$user_token', status='1' where uid='$uid'");
    }

    #刷新访问令牌
    function refresh_access_token($user_token) {
        global $appdata;
        $hash_mehod = 'sha256';
        $access_token = md5(hash($hash_mehod, hash($hash_mehod, $user_token).rand()).time());
        $this->query_change("update $appdata.tokens set access_token='$access_token' where user_token='$user_token'");
        return $access_token;
    }
    
    #退出登录
    function user_logout($user_token){
        global $appdata;
        $this->query_change("update $appdata.tokens set status='0' where user_token='$user_token'");
    }
    
    #获取令牌状态
    function token_status($user_token){
        global $appdata;
        $res = $this->query("select status from $appdata.tokens where user_token='$user_token'");
        if ($res[0][0] == 1){
            return true;
        }else{
            return false;
        }
    }
    
    #==============推理操作==============
    #判断项目是否存在
    function check_type($category, $brand, $name) {
        global $appdata;
        $res = $this->query("select name, brand from $appdata.apis where name='$name' and brand = '$brand' and category = '$category'");
        if (!empty($res)) {
            return true;
        } else {
            return false;
        }
    }
    
    #根据条件获取url
    function get_url($category, $brand, $name){
        global $appdata;
        $res = $this->query("select server, spk_url from $appdata.apis where name='$name' and brand = '$brand' and category = '$category'");
        return array($res[0][0],$res[0][1]);
    }
    
    #判断访问令牌是否有效
    function check_access($access_token){
        global $appdata;
        $res = $this->query("select access_token from $appdata.tokens where access_token='$access_token'");
        if (!empty($res)) {
            return true;
        } else {
            return false;
        }
    }
    
    #获取APPKEY
    function get_infer_prarm($category, $brand, $name){
        global $appdata;
        $res = $this->query("select app_key, server from $appdata.apis where name='$name' and brand = '$brand' and category = '$category'");
        return array($res[0][0],$res[0][1]);
    }
    

    #==============管理操作==============
    #--------------用户管理--------------
    #列出用户
    function get_user_list($index) {
        global $appdata;
        $res = $this->query("select * from $appdata.users");
        return array($res[$index][1], $res[$index][2], $res[$index][3], $res[$index][5], $res[$index][6], $res[$index][7], $res[$index][8], $res[$index][9]);
    }

    #将用户设成管理员
    function set_admin($uid) {
        global $appdata;
        $this->query_change("update $appdata.users set isadmin='1' where uid='$uid'");
    }

    #将用户取消管理员
    function unset_admin($uid) {
        global $appdata;
        $this->query_change("update $appdata.users set isadmin='0' where uid='$uid'");
    }

    #--------------后端管理--------------
    #添加推理后端
    function add_infer_server($server, $name, $username, $category, $brand, $appkey, $spk_url, $note) {
        global $appdata;
        $date = time();
        $this->query_change("insert into $appdata.apis (server, name, added_by, category, brand, app_key, spk_url, note, date) values ('$server', '$name', '$username', '$category', '$brand', '$appkey', '$spk_url', '$note', '$date')");
    }

    #列出推理后端
    function get_server_list($index) {
        global $appdata;
        $res = $this->query("select * from $appdata.apis");
        return array($res[$index][0], $res[$index][1], $res[$index][2], $res[$index][3], $res[$index][4], $res[$index][5], $res[$index][6], $res[$index][7], $res[$index][8], $res[$index][9]);
    }

    #修改推理后端
    function update_server($id, $server, $name, $category, $brand, $appkey, $spkurl) {
        global $appdata;
        $this->query_change("update $appdata.apis set server='$server', name='$name', category='$category', brand='$brand', spk_url='$spkurl', app_key='$appkey' where id='$id'");
    }
    
    #删除推理后端
    function delete_server($id) {
        global $appdata;
        $this->query_change("delete from $appdata.apis where id = '$id'");
    }
    
}