<?php
function curlPost($url, $post_data = array(), $timeout = 5, $header = "", $data_type = "")
{
    $header = empty($header) ? '' : $header;
    //支持json数据数据提交
    if ($data_type == 'json') {
        $post_string = json_encode($post_data);
    } elseif ($data_type == 'array') {
        $post_string = $post_data;
    } elseif (is_array($post_data)) {
        $post_string = http_build_query($post_data, '', '&');
    }
    $ch = curl_init();    // 启动一个CURL会话
    curl_setopt($ch, CURLOPT_URL, $url);     // 要访问的地址
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // 对认证证书来源的检查   // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($ch, CURLOPT_POST, true); // 发送一个常规的Post请求
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);     // Post提交的数据包
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);     // 设置超时限制防止死循环
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     // 获取的信息以文件流的形式返回 
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function get($link)
{
    $options = array('http' => array(
        'method' => 'GET',
    ));
    $context = stream_context_create($options);
    $data = file_get_contents($link, false, $context);
    return $data;
}

function start($link = 0, $password = '')
{
    $result = array(
        'code' => 200,
        'data' => array(),
        'msg' => "解析成功"
    );
    // 分割
    $re = '/data=([^&]*)/m';
    preg_match_all($re, $link, $matches, PREG_SET_ORDER, 0);
    $data = $matches[0][1] ? $matches[0][1] : NULL;
    // 替换
    str_replace("&data=$data", '', $link);
    str_replace("&isShare=1", '', $link);
    str_replace("&isShare=0", '', $link);
    str_replace("&pwd=$password", '', $link);
    // 编码
    $link = urlencode($link);
    // 请求
    $response = get("https://www.ecpan.cn/drive/fileextoverrid.do?chainUrlTemplate=$link&data=$data&parentId=-1");
    $json = json_decode($response, true);
    $fileName = $json["var"]["chainFileInfo"]["jsonFileList"][0]["fileName"];
    $fileSize = $json["var"]["chainFileInfo"]["jsonFileList"][0]["fileSize"];
    // 是否是加密连接
    $downloadLink = $json["var"]["chainFileInfo"]["jsonFileList"][0]["downloadUrl"];
    if ($password != NULL) {
        // 获取数据
        $cloudpFileList = $json["var"]["chainFileInfo"]["cloudpFileList"];
        // 构建cloudpFileList
        $cloudpFileList[0]['downloadUrl'] = NULL;
        // 获取信息
        $groupId = $cloudpFileList[0]["groupId"];
        $shareId = $json["var"]["chainFileInfo"]["shareId"];
        // 构建POST请求
        $postdata = array(
            'extCodeFlag' => 1,
            'extractionCode' => $password,
            'groupId' => $groupId,
            'isIp' => 0,
            'shareId' => $shareId,
            'fileIdList' => $cloudpFileList
        );
        // $dlData = post("https://www.ecpan.cn/drive/sharedownload.do", $postdata);
        $header = array("Content-Type:multipart/x-www-form-urlencoded");
        $dlData = curlPost("https://www.ecpan.cn/drive/sharedownload.do", $postdata, 5, $header, 'json');
        $json1 = json_decode($dlData, true);
        $downloadLink = $json1["var"]["downloadUrl"];
    }
    // 输出
    array_push($result['data'], array(
        "name" => $fileName,
        "size" => $fileSize,
        "DownloadURL" => $downloadLink
    ));
    return $result;
}

$link = isset($_GET['link']) ? $_GET['link'] : NULL;
$password = isset($_GET['pwd']) ? $_GET['pwd'] : NULL;
$redirect = isset($_GET['red']) ? $_GET['red'] : NULL;
$result = start($link, $password);
if ($redirect == NULL) {
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');
    if ($result['data'][0]['DownloadURL'] == NULL) {
        $result = array(
            "code" => 202,
            "msg" => '链接错误/失效/解析失败',
        );
    }
    echo json_encode($result, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit();
} else {
    if ($result['data'][1] == NULL) {
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: ' . $result['data'][0]['DownloadURL']);
    } else {
        header('Access-Control-Allow-Origin:*');
        header('Content-Type:application/json');
        $json = array(
            "code" => 200,
            "msg" => '解析成功(多文件不支持直接跳转)',
            "data" => $result
        );
        echo json_encode($json, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
