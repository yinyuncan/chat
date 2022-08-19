<?php
//八零在线缘明网络部提供技术驱动QQ1500203929
defined('UEDITORPATH') or exit('No direct script access allowed');

header('Access-Control-Allow-Origin:*'); //临时处理，后面在强化它
header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');

//chdir(__DIR__);

if (is_file("./assets/ueditor/php/config.php")) {
    $CONFIG = require "./assets/ueditor/php/config.php";
} elseif (is_file("./assets/ueditor/php/config.php")) {
    $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(APP_PATH . "./assets/ueditor/php/config.json")), true);
} else {
    echo json_encode(array(
        'state' => '无权限访问./assets/ueditor/php/config.php文件'
    ), JSON_UNESCAPED_UNICODE);
    exit;
}

if (isset($CONFIG['imageAltValue']) && $CONFIG['imageAltValue'] == 'name') {
    $CONFIG["imgTitleTag"] = '';
} else {
    $CONFIG["imgTitleTag"] = UEDITOR_IMG_TITLE;
}
if (!isset($_GET['action'])) {
    echo json_encode(array(
        'state' => '参数非法'
    ), JSON_UNESCAPED_UNICODE);
    exit;
}

$action = $_GET['action'];


// 验证了才能上传
switch ($action) {
    case 'config':
        $result = json_encode($CONFIG, JSON_UNESCAPED_UNICODE);
        break;

    /* 上传图片 */
    case 'uploadimage':
        /* 上传涂鸦 */
    case 'uploadscrawl':
        /* 上传视频 */
    case 'uploadvideo':
        /* 上传文件 */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /* 列出图片 */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listfile':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listvideo':
        $result = include("action_list.php");
        break;

    /* 抓取远程文件 */
    case 'catchimage':
        //$result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state' => '请求地址出错'
        ), JSON_UNESCAPED_UNICODE);
        break;
}


/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state' => 'callback参数不合法'
        ), JSON_UNESCAPED_UNICODE);
    }
} else {
    echo $result;
}
exit;