# CloudDiskAnalysis

获取云盘分享链接直链

[![Security Status](https://s.murphysec.com/badge/HurryBy/lanzou-directlink.svg)](https://www.murphysec.com/p/HurryBy/lanzou-directlink)
### 测试网站

网页版测试网站: https://cloud.humorously.cn

### 支持云盘

蓝奏云盘/123云盘/中国移动云空间
### 功能列表

- [x] 程序自动获取最后的外链
- [x] 支持获取文件夹外链分享
- [x] API 单独文件 、 API 实时解析
- [x] 免费开源，永久更新!

### 介绍

自动获取各个云盘分享链接的直链，可以用作直链下载等.

### 免责声明

本程序对在适用法律允许的最大范围内，对因使用或不能使用本软件所产生的损害及风险，包括但不限于直接或间接的个人损害、商业赢利的丧失、贸易中断、商业信息的丢失或任何其它经济损失，不承担任何责任。

### 更多

我花费了很多的时间和精力，如果你想让这个项目传播的更广，麻烦点个 Star，谢谢！

# Api

以蓝奏云解析为例

### 测试网站

API 测试网站: https://cloud.humorously.cn/api/lanzou.php

### API 参数

- link:蓝奏云分享外链链接
- pwd:分享链接的密码
- red:是否直接跳转至下载网站 填写任意参数都代表您要进行跳转

### 支持

PHP Version<=7.4

> 支持所有格式的链接

### 请求示例

无密码: `?link=https://wwt.lanzouw.com/inAe108hg9de`

有密码: `?link=https://wwt.lanzouw.com/iKvVt08mqfxa&pwd=ggg2`

直接下载: `?link=https://wwt.lanzouw.com/inAe108hg9de&red=114514`

文件夹分享: `?link=https://wwt.lanzouw.com/b0cmny2aj&pwd=c8wc`

### 返回示例

- 无密码

```json
{
  "code": 200,
  "msg": "解析成功",
  "data": {
    "name": "配音文件.mp3",
    "size": "2.8 M",
    "author": "18**",
    "time": "2022-07-27",
    "description": null,
    "url": "https://s41.lanzoug.com/100309bb/2022/07/27/c9cfbdfb1d487506e3dd375317a3464f.mp3?st=5uPUVQOVGdIms5GcFWpQnw&e=1664761013&b=B7xc2QOOVbkCyFWwBbNXxVOBALgAulbmUSwPb1QjVGU_c&fi=76444934&pid=107-151-195-148&up=2&mp=1&co=1"
  }
}
```

- 有密码

```json
{
  "code": 200,
  "msg": "解析成功",
  "data": {
    "name": "字幕.txt",
    "size": "1.0 K",
    "author": "18**",
    "time": "2022-07-29",
    "description": null,
    "url": "https://s01.lanzoug.com/100309bb/2022/07/29/ad5b3876da02ca8dbd6a7b3387c3493f.txt?st=ETWtF1FGPkeJR2AZtdczyg&e=1664761037&b=ArUJpFfAVbUC7lWWUS8DcwUoASk_c&fi=76691410&pid=222-131-184-198&up=2&mp=0&co=1"
  }
}
```

- 文件夹分享

```json
{
  "code": 200,
  "msg": "解析成功",
  "docname": "Chyua",
  "data": [
    {
      "id": "injhP096pa3e",
      "name": "点击启动游戏.exe",
      "size": "2.6 M",
      "author": "18**",
      "time": "2022-08-08",
      "description": null,
      "url": "https://s41.lanzoug.com/100309bb/2022/08/08/89a9b721568792d6788454555f9f93a4.exe?st=GKQvsd8jsUAhakYUK8kgkA&e=1664761057&b=Ardc3lPqU7MA0l6zAbQFkQX_aXeQBigepAbQLvgW6UbVWjFnWBigAYAAtX2w_c&fi=77623024&pid=107-151-195-148&up=2&mp=1&co=1"
    },...
  ]
}
```

| 返回值      | 解释                 |
| ----------- | -------------------- |
| code        | 判断码               |
| msg         | 文字说明             |
| docname     | 文件夹的名字         |
| id          | 文件 ID              |
| name        | 文件的名字           |
| size        | 文件的大小           |
| author      | 文件的分享者         |
| time        | 文件分享的时间       |
| url         | 直链解析的 URL       |
| description | 文件描述，可用作公告 |

最新更新日期 2023/07/13
