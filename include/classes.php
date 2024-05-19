<?php
#=================加载配置文件=================
require_once $_SERVER['DOCUMENT_ROOT'] ."/config.php";

#==================加载所需类==================
require_once($_SERVER['DOCUMENT_ROOT'] . "/include/classes/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/include/classes/pinyin.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/include/classes/postdata.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/include/classes/exceptions.php");

$db = new database();