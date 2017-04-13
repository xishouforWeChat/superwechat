# Markdown--从入门到精通
#### 导语：
> [Markdown](http://zh.wikipedia.org/wiki/Makrdown) 是一种轻量级的标记语言，它的有点很多，目前也被越来越多的写作爱好者，撰稿者广泛应用

## 一、认识Markdown
如果你从事文字工作，我强烈建议你购买 Ulysses for Mac，这款软件入围了苹果 Mac App Store 的 The Best of 2013。它支持更多的写作格式、多文档的支持。Mou，iA writer 这些软件都是基于单文档的管理方式，而 Ulysses 支持 Folder、Filter 的管理，一个 Folder 里面可以创建多个 Sheet，Sheet 之间也可以进行 Combine 处理。

### 代码片断
```php
<?php
    $options = [
        'debug'     => true,
        'app_id'    => 'wx3cf0f39249eb0e60',
        'secret'    => 'f1c242f4f28f735d4687abb469072a29',
        'token'     => 'easywechat',
        'log' => [
            'level' => 'debug',
            'file'  => '/tmp/easywechat.log',
        ],
        // ...
    ];
    
    $app = new Application($options);
    
    $server = $app->server;
    $user = $app->user;
```

```shell
svn st | grep A | awk '{print$2}' | xargs svn add
```

```css
.header-red {
    background:red;
    color:white  ; 
}
.header-black {
    background:black;
    color:red;
}
```

```js
var status = 1;
if (status == 1) {
    status = 2;
    while (true) {
        status = 1;
    }
}
```

### Makrdown官方文档

>这里可以看到官方的Markdown语法规则文档，当然，文后我也会用自己的方式阐述这些语法的具体用法

*   [创始人](http://www.baidu.com)

### 使用Markdown的有点
* 专注你的文字内容而不是排版样式
* 轻松导出HTML、PDF

### 我应该用什么工具
![Mou icon](http:///mouapp.com/Mou_128.png)