# UEditor 后端PHP部分



## 介绍

UEditor 官方文档 http://fex.baidu.com/ueditor/

ueditor和后台通信的功能较多，这里列一下编辑器和后台通信的功能：

1. 上传图片

2. 拖放图片上传、粘贴板图片上传

3. word文档图片转存

4. 截图工具上传

5. 上传涂鸦

6. 上传视频

7. 上传附件

8. 在线图片管理

9. 粘贴转存远程图片

   

## 安装

```bash
composer require cshaptx4869/ueditor
```



## 使用

UEditor 前端配置与服务器通信的地址

```javascript
// 服务器统一请求接口路径
serverUrl: xxxxxx
```

服务器使用

```php
use Fairy\UEditor;

echo UEditor::controller();
```

即可实现UEditor与服务器的通信
