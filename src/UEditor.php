<?php

namespace Fairy;

use Fairy\Factory\ConfigAction;
use Fairy\Factory\CrawlerAction;
use Fairy\Factory\ListAction;
use Fairy\Factory\UploadAction;

//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
//date_default_timezone_set("Asia/chongqing");
//error_reporting(E_ERROR);
//header("Content-Type: text/html; charset=utf-8");

class UEditor
{
    static public function controller()
    {
        switch ($_GET['action']) {
            case 'config':
                $result = (new ConfigAction())->getResult();
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = (new UploadAction())->getResult();
                break;

            /* 列出图片、文件 */
            case 'listimage':
            case 'listfile':
                $result = (new ListAction())->getResult();
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = (new CrawlerAction())->getResult();
                break;

            default:
                $result = json_encode(['state' => '请求地址出错']);
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            $result = preg_match("/^[\w_]+$/", $_GET["callback"]) ?
                htmlspecialchars($_GET["callback"]) . '(' . $result . ')' :
                json_encode(['state' => 'callback参数不合法']);
        }

        return $result;
    }
}
