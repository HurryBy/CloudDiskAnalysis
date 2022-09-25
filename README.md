# Lanzou-DirectLink

获取蓝奏云直链

### 测试网站

网页版测试网站: https://lanzou.humorously.tk

### 功能列表

- [x] 自动获取真实直链
- [x] 拥有 API 版本
- [x] 支持文件夹外链分享获取
- [x] API 实时解析
- [x] 免费开源，永久更新!

### 介绍

自动获取蓝奏云分享链接的直链，然后你就可以获取添加到你自己的网页里面.

### 免责声明

使用这个软件代表你不会用这个软件干任何违法的事情，不会违反任何国家的任何法律，所作任何违法的事情与本作者无任何关系。

### 更多

网页版不支持 PHP8.0 经过测试可行的版本为 PHP7.4

我花费了很多的时间和精力，如果你想让这个项目传播的更广，麻烦点个 Star，谢谢！

# Lanzou-DirectLink-Api

获取蓝奏云直链的 API

### 测试网站

API 测试网站: https://lanzou.humorously.tk/api/api.php

### API 参数

- link:蓝奏云分享外链链接
- pwd:分享链接的密码
- red:是否直接跳转至下载网站(文件夹分享不支持) 填写任意参数都代表您要进行跳转

### 支持链接

> 全部都支持，发现错误的网址会自动纠正

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
  "docname": "Chyua",
  "data": [
    {
      "id": "injhP096pa3e",
      "name": "点击启动游戏.exe",
      "size": "2.6 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/89a9b721568792d6788454555f9f93a4.exe?st=pUYrhgeThJnia36IeQdC_w&e=1662868734&b=VuMPjQa_aU7NYil_byBbBSxlSuCLFU3wCuALVc6QC_aBeEG3AiHAC5UNFB9X2w_c&fi=77623024&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "i6mck096p9mh",
      "name": "d8-ff.rar",
      "size": "85.2 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/25003f1fc1002fe4a4788f32f4b4edb5.rar?st=mmEYRTjl00N7jrQcRvU3Pw&e=1662868734&b=ADZaYgQpUDNSYVYuACIHYgAn&fi=77623007&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "iJQXg096p90f",
      "name": "a8-d7.rar",
      "size": "92.1 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/956a3caf34287acca8ffc27c702cdeff.rar?st=SUopdsHZop9l79fQAqK8-w&e=1662868735&b=VGcJMVJ_aVDVXNQN7UHIBZAcg&fi=77622985&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "i8kTb096p7wf",
      "name": "66-a7.rar",
      "size": "75.8 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/49c07d2f5f2627a852aaf09675000999.rar?st=BunYZs39WPecRIzKUUxrVQ&e=1662868736&b=BGABNwAtUDRUNl8nUXMPagEm&fi=77622945&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "iSXm1096p74h",
      "name": "42-65.rar",
      "size": "79.3 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/f6e349e1be631f06561ad64c1cdc8777.rar?st=0rMFzpGaqj9IsNFuiMAWyA&e=1662868736&b=UjQPPQAtBzRUNAd_aUnBQNQMk&fi=77622917&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "iErZR096p6da",
      "name": "06-41.rar",
      "size": "89.3 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/5d06c143945766d4eba238701774cafa.rar?st=FpdOp-eS1vJjU6jQ1x8nIA&e=1662868737&b=BmQBNwAtUWAAZFYuVXcHYlVy&fi=77622890&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "ilmmk096p5ri",
      "name": "00-5f.rar",
      "size": "68.2 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/3a93113b7938c2529581aa6b8c456dca.rar?st=w0rUTmJHprNp5UjdU5zlkQ&e=1662868737&b=AmBaalB9WWlXZF8nCylUMQcg&fi=77622868&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "iTcNs096p5fg",
      "name": "assets_1.rar",
      "size": "207.5 K",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/416da531b26955bde9aa0b2e8335a9e0.rar?st=WLa4KXOXy1JFlxagl9HU6w&e=1662868738&b=UmEAcwZ1UTFSc196BAsGMwN4XnBQMAVx&fi=77622856&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "i4Tq8096p5ab",
      "name": "libraries_2.rar",
      "size": "31.0 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/e0452329c4e376594e913d63619e1aec.rar?st=fwJW9Q8H0a0Iimsx2kGZ3Q&e=1662868739&b=BTteN1AyAHcFMQMnAzpSMwUjDg0DMFR8U3JcMAdy&fi=77622851&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "ic5Og096p53e",
      "name": "libraries_1.rar",
      "size": "63.8 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/dfdf3958bc9783413e882690a2f25a49.rar?st=bJ5UF9855Ge6-I5U3737pw&e=1662868739&b=AT8KY1Q2UiVXY197V25XNgAmDg0GNgIqVncKZl0o&fi=77622844&pid=43-248-96-182&up=2&mp=1&co=1"
    },
    {
      "id": "iSeyF096p4pa",
      "name": "except_assets_libraries.rar",
      "size": "42.7 M",
      "author": "18**",
      "time": "2022-08-08",
      "url": "https://all-file.lanzoug.com/091111bb/2022/08/08/bfa92c20211f18b5bf1e7abee3e692a3.rar?st=HW4p1FzGuO8thWm0kLGZSw&e=1662868740&b=BjEOdlIxAmJTdlR2V1gGYwMlDSIBZQt5CSldD1I5AGsJOVspB2ZTJAM_aUGNXdAQuASZbZgBz&fi=77622830&pid=43-248-96-182&up=2&mp=1&co=1"
    }
  ]
}
```

| 返回值  | 解释                       |
| ------- | -------------------------- |
| code    | 简便的判断程序返回是否正常 |
| msg     | 程序返回的文字说明         |
| docname | 文件夹分享中文件夹的名字   |
| id      | 文件夹分享中各个文件的 ID  |
| name    | 文件的名字                 |
| size    | 文件的大小                 |
| author  | 文件的分享者               |
| time    | 文件分享的时间             |
| url     | 直链解析的 URL             |

正在爆肝油猴脚本。最新更新日期 2022/09/11
