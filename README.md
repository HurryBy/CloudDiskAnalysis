# Lanzou-DirectLink

获取蓝奏云直链

### 测试网站

网页版测试网站: http://jiexi.lanzoucloud.ml/

### 功能列表

- [x] 自动获取真实直链
- [x] 拥有 API 版本
- [x] 支持文件夹外链分享获取
- [x] API 实时解析
- [x] 免费开源，永久更新!

### 介绍

自动获取蓝奏云分享链接的直链，然后你就可以获取添加到你自己的网页里面，主要是蓝奏云还不限速，非常好用！

### 免责声明

使用这个软件代表你不会用这个软件干任何违法的事情，不会违反任何国家的任何法律，所作任何违法的事情与本作者无任何关系。

### 更多

网页版不支持 PHP8.0 经过测试可行的版本为 PHP7.4

我花费了很多的时间和精力，如果你想让这个项目传播的更广，麻烦点个 Star，谢谢！

# Lanzou-DirectLink-Api

获取蓝奏云直链的 API

### 测试网站

API 测试网站: http://wgame.miaovps.com:32022/api/api.php

### API 参数

- link:蓝奏云分享外链链接
- pwd:分享链接的密码
- red:是否直接跳转至下载网站(文件夹分享不支持) 填写任意参数都代表您要进行跳转

### 支持链接

> 全部都支持，发现错误的网址会自动纠正

### 请求示例

无密码: `?link=https://wwt.lanzouw.com/inAe108hg9de`

有密码: `?link=https://wwt.lanzouw.com/iKvVt08mqfxa&pwd=ggg2`

直接下载: `?link=https://wwt.lanzouw.com/iKvVt08mqfxa&red=114514`

文件夹分享: `?link=https://wwt.lanzouw.com/b0cmmk8ni&pwd=9m4q`

### 返回示例

- 无密码

```json
{
  "code": 200,
  "msg": "解析成功",
  "data": {
    "name": "配音文件.mp3",
    "size": " 2.8 M",
    "author": "18**",
    "time": "前天13:18",
    "url": "https://i41.lanzoug.com/072917bb/2022/07/27/c9cfbdfb1d487506e3dd375317a3464f.mp3?st=DAVtxTvj-6oQwKAkQRFyFA&e=1659089377&b=ALtc2QKPWLRYkl_b6AbcPnVKAAblU7gGxBXgMbAZxUWA_c&fi=76444934&pid=43-248-96-182&up=2&mp=1&co=1"
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
    "size": " 1.0 K",
    "author": "18**",
    "time": "3 分钟前",
    "url": "https://i01.lanzoug.com/072917bb/2022/07/29/ad5b3876da02ca8dbd6a7b3387c3493f.txt?st=XRC5tMY9L_G5cMe9eXO2Yw&e=1659089409&b=VONZ9AifBORXuwfEB3lXJwQpWXE_c&fi=76691410&pid=43-248-96-182&up=2&mp=0&co=1"
  }
}
```

- 文件夹分享

```json
{
  "code": 200,
  "msg": "解析成功",
  "data": [
    {
      "id": "iuuKM08hpb1i",
      "name": "忘记密码看这里.txt",
      "size": " 100.0 B",
      "author": "18**",
      "time": "前天15:55",
      "url": "https://i81.lanzoug.com/072917bb/2022/07/27/25db0252a38e165c34288edbea065927.txt?st=Ri_65a09hD1dEH1BLnyU8A&e=1659089434&b=AbYAv1LKBehQq1O1ArdX_aATXWuECo1PUBbFfzlHdVL4F6ACZA_bpT0VGIBX1VcVIuByY_c&fi=76456658&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "ifqDn08hpb0h",
      "name": "字幕.txt",
      "size": " 1.0 K",
      "author": "18**",
      "time": "前天15:55",
      "url": "https://i71.lanzoug.com/072917bb/2022/07/27/317ab6df371a60c6a38137b4d9ebe183.txt?st=MLJrjngon-FrPHHwnZOnDg&e=1659089435&b=Cb4NoASTBeVZtVCTB3lXJwYrCiI_c&fi=76456657&pid=43-248-96-182&up=2&mp=1&co=1"
    }
  ]
}
```

| Code | 返回值              |
| ---- | ------------------- |
| 200  | 解析成功            |
| 201  | 密码错误/请输入密码 |
| 202  | 链接错误/链接失效   |

**Star过15爆肝TamperMonkey脚本**
