<?php


namespace Fairy\Factory;

use Fairy\Uploader;

/**
 * Class Upload
 * 上传附件和上传视频
 * @package Fairy\Factory
 */
class UploadAction extends Action
{
    public function getResult()
    {
        /* 上传配置 */
        $base64 = "upload";
        switch (htmlspecialchars($_GET['action'])) {
            // 图片配置项
            case 'uploadimage':
                $config = [
                    "pathFormat" => $this->config['imagePathFormat'],
                    "maxSize" => $this->config['imageMaxSize'],
                    "allowFiles" => $this->config['imageAllowFiles']
                ];
                $fieldName = $this->config['imageFieldName'];
                break;
            // 涂鸦图片配置项
            case 'uploadscrawl':
                $config = [
                    "pathFormat" => $this->config['scrawlPathFormat'],
                    "maxSize" => $this->config['scrawlMaxSize'],
                    "oriName" => "scrawl.png"
                ];
                $fieldName = $this->config['scrawlFieldName'];
                $base64 = "base64";
                break;
            // 视频配置项
            case 'uploadvideo':
                $config = [
                    "pathFormat" => $this->config['videoPathFormat'],
                    "maxSize" => $this->config['videoMaxSize'],
                    "allowFiles" => $this->config['videoAllowFiles']
                ];
                $fieldName = $this->config['videoFieldName'];
                break;
            // 文件配置项
            case 'uploadfile':
            default:
                $config = [
                    "pathFormat" => $this->config['filePathFormat'],
                    "maxSize" => $this->config['fileMaxSize'],
                    "allowFiles" => $this->config['fileAllowFiles']
                ];
                $fieldName = $this->config['fileFieldName'];
                break;
        }

        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $base64);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        /* 返回数据 */

        return json_encode($up->getFileInfo());
    }
}
