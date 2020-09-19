<?php

namespace Fairy\Factory;

use Fairy\Uploader;

/**
 * Class Crawler
 * 抓取远程图片
 * @package Fairy\Factory
 */
class CrawlerAction extends Action
{
    /* 上传配置 */
    public function getResult()
    {
        set_time_limit(0);
        /* 上传配置 */
        $config = [
            "pathFormat" => $this->config['catcherPathFormat'],
            "maxSize" => $this->config['catcherMaxSize'],
            "allowFiles" => $this->config['catcherAllowFiles'],
            "oriName" => "remote.png"
        ];
        $fieldName = $this->config['catcherFieldName'];
        /* 抓取远程图片 */
        $list = [];
        $source = isset($_POST[$fieldName]) ? $_POST[$fieldName] : $_GET[$fieldName];
        foreach ($source as $imgUrl) {
            $item = new Uploader($imgUrl, $config, "remote");
            $info = $item->getFileInfo();
            array_push($list, [
                "state" => $info["state"],
                "url" => $info["url"],
                "size" => $info["size"],
                "title" => htmlspecialchars($info["title"]),
                "original" => htmlspecialchars($info["original"]),
                "source" => htmlspecialchars($imgUrl)
            ]);
        }

        /* 返回抓取数据 */

        return json_encode([
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list' => $list
        ]);
    }
}
