<?php
function post($link, $post_data)
{
    $postdata = http_build_query($post_data);
    $options = array('http' => array(
        'method' => 'POST',
        'content' => $postdata,
    ));
    $context = stream_context_create($options);
    $data = file_get_contents($link, false, $context);
    return $data;
}
function get_redirect_url($url)
{
    $re = '/\?params=(.*)&/m';
    preg_match_all($re, $url, $matches, PREG_SET_ORDER, 0);
    return base64_decode($matches[0][1]);
}
function start($link = 0, $password = '')
{
    $result = array(
        'code' => 200,
        'data' => array(),
        'msg' => "解析成功"
    );
    // Get Share_Key
    $re = '/s\/(.*).html/m';
    preg_match_all($re, $link, $matches, PREG_SET_ORDER, 0);
    $share_key = $matches[0][1] ? $matches[0][1] : NULL;
    if ($share_key == NULL) {
        return array(
            "code" => 201,
            "message" => "分享地址错误"
        );
    }
    $data = file_get_contents("https://www.123pan.com/b/api/share/get?limit=100&next=1&orderBy=share_id&orderDirection=desc&shareKey=$share_key&SharePwd=$password&ParentFileId=0&Page=1", false);
    $data = json_decode($data, true);
    if ($data['code'] == 5103) {
        return array(
            "code" => 201,
            "message" => $data['message']
        );
    } else {
        // 开始获取链接
        // 1.获取Len
        if ($data['data']['InfoList'][0]['Type'] == 1) {
            $ID = $data['data']['InfoList'][0]['FileId'];
            $result = array(
                'code' => 200,
                'data' => array(),
                'msg' => "解析成功",
                'docname' => $data['data']['InfoList'][0]['FileName']
            );
            // 文件夹
            $data = file_get_contents("https://www.123pan.com/b/api/share/get?limit=100&next=1&orderBy=share_id&orderDirection=desc&shareKey=$share_key&SharePwd=$password&ParentFileId=$ID&Page=1", false);
            $data = json_decode($data, true);
            if ($data['code'] == 5103) {
                return array(
                    "code" => 201,
                    "message" => $data['message']
                );
            }
        }
        $length = $data['data']['Len'];
        // 2. 循环Length遍

        for ($i = 1; $i <= $length; $i++) {
            // 获取InfoList
            $infoList = $data['data']['InfoList'][$i - 1];
            $FileID = $infoList['FileId'];
            $FileName = $infoList['FileName'];
            $Size = $infoList['Size'];
            $S3KeyFlag = $infoList['S3KeyFlag'];
            $Etag = $infoList['Etag'];
            $post_data = array(
                'Etag' => $Etag,
                'FileID' => $FileID,
                'S3keyFlag' => $S3KeyFlag,
                'ShareKey' => $share_key,
                'Size' => $Size
            );
            $data = post('https://www.123pan.com/b/api/share/download/info', $post_data);
            $data = json_decode($data, true);
            $DownloadURL = $data['data']['DownloadURL'];
            $DownloadURL1 = get_redirect_url($DownloadURL);
            array_push($result['data'], array(
                "name" => $FileName,
                "size" => $Size,
                "DownloadURL" => $DownloadURL1
            ));
        }
        return $result;
    }
}


$link = isset($_GET['link']) ? $_GET['link'] : NULL;
$password = isset($_GET['pwd']) ? $_GET['pwd'] : NULL;
$redirect = isset($_GET['red']) ? $_GET['red'] : NULL;
$result = start($link, $password);
if ($redirect == NULL) {
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');
    if ($result['data'][0]['DownloadURL'] == NULL && $result['code'] != 201) {
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
