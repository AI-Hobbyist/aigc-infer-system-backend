<?php
#=================加载所需函数=================
#-----------------用户相关函数-----------------
require_once($_SERVER['DOCUMENT_ROOT'] . "/user/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/user/refresh_token.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/user/get_user.php");

#-----------------管理相关函数-----------------
#用户管理
require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/user/list_user.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/user/set_admin.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/user/unset_admin.php");

#后端管理
require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/backend/list_infer_server.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/backend/add_infer_server.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/backend/update_infer_server.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/backend/del_infer_server.php");

#-----------------推理相关函数-----------------
require_once($_SERVER['DOCUMENT_ROOT'] . "/infer/get_spks.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/infer/gen.php");

#-----------------其他相关函数-----------------
require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/check_support.php");
#==============================================
