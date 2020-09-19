<?php


namespace Fairy\Factory;

/**
 * Class Lists
 * 获取已上传的文件列表
 * @package Fairy\Factory
 */
class ListAction extends Action
{
    public function getResult()
    {
        /* 判断类型 */
        switch ($_GET['action']) {
            /* 列出文件 */
            case 'listfile':
                $allowFiles = $this->config['fileManagerAllowFiles'];
                $listSize = $this->config['fileManagerListSize'];
                $path = $this->config['fileManagerListPath'];
                break;
            /* 列出图片 */
            case 'listimage':
            default:
                $allowFiles = $this->config['imageManagerAllowFiles'];
                $listSize = $this->config['imageManagerListSize'];
                $path = $this->config['imageManagerListPath'];
        }
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

        /* 获取参数 */
        $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
        $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
        $end = $start + $size;

        /* 获取文件列表 */
        $path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "" : "/") . $path;
        $files = $this->getFiles($path, $allowFiles);
        if (!count($files)) {
            return json_encode([
                "state" => "no match file",
                "list" => [],
                "start" => $start,
                "total" => count($files)
            ]);
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = []; $i < $len && $i >= 0 && $i >= $start; $i--) {
            $list[] = $files[$i];
        }
        //倒序
//        for ($i = $end, $list = array(); $i < $len && $i < $end; $i++) {
//            $list[] = $files[$i];
//        }

        /* 返回数据 */

        return json_encode([
            "state" => "SUCCESS",
            "list" => $list,
            "start" => $start,
            "total" => count($files)
        ]);
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    public function getFiles($path, $allowFiles, &$files = array())
    {
        if (!is_dir($path)) return null;
        if (substr($path, strlen($path) - 1) != '/') $path .= '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->getFiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
                        $files[] = [
                            'url' => substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
                            'mtime' => filemtime($path2)
                        ];
                    }
                }
            }
        }

        return $files;
    }
}
