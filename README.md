## Feature

 - 自己开发所用sdk

## Requirement

1. PHP >= 5.2.4
2. **[composer](https://getcomposer.org/)**

> SDK 对所使用的框架并无特别要求

## Installation

```shell
composer require xuzongchao/superwechat dev-master
```

## Usage

基本使用（以服务端为例）:

```php
<?php

    $appId = '***************';
    $appSecret = '*************';
    
    $accessToken = new \Superwechat\Core\AccessToken($appId, $appSecret);
    
    $groups = new \Superwechat\Groups\Groups($accessToken);
    $groupList = $groups->all();
```

更多请参考[http://www.xuzongchao.com](http://www.xuzongchao.com)。

## Documentation

- Homepage: http://www.xuzongchao.com
- Forum: https://forum.easywechat.org
- 微信公众平台文档: https://mp.weixin.qq.com/wiki

## License

MIT