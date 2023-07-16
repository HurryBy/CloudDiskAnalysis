<?php
error_reporting(0);
$downloadLink = "";
$docname = "";
function rand_IP()
{
    $ip2id = round(rand(600000, 2550000) / 10000);
    $ip3id = round(rand(600000, 2550000) / 10000);
    $ip4id = round(rand(600000, 2550000) / 10000);
    $arr_1 = array("218", "218", "66", "66", "218", "218", "60", "60", "202", "204", "66", "66", "66", "59", "61", "60", "222", "221", "66", "59", "60", "60", "66", "218", "218", "62", "63", "64", "66", "66", "122", "211");
    $randarr = mt_rand(0, count($arr_1) - 1);
    $ip1id = $arr_1[$randarr];
    return $ip1id . "." . $ip2id . "." . $ip3id . "." . $ip4id;
}
function get_file_info($data)
{
    $info = [];
    $name = zhengze('/"md">(.*) <span/', $data);
    $info[0] = $name;
    $size = zhengze('/mtt">\( (.*) \)<\/span>/', $data);
    $info[1] = $size;
    $author = zhengze('/发布者:<\/span>(.*?) <span/', $data);
    $info[2] = $author;
    $time = zhengze('/时间:<\/span>(.*?) <span/', $data);
    $info[3] = $time;
    $description = zhengze('/mdo">[\s\S](.*?)<\/div>/m', $data);
    $info[4] = $description;
    return $info;
}
function get_file_info_vip($data)
{
    $info = [];
    $name = zhengze('/<div class="appname">(.*?)</div>', $data);
    $info[0] = $name;
    $size = zhengze('/下载 \((.*?)\)/', $data);
    $info[1] = $size;
    $author = zhengze('/<div class="user-name">(.*?)<\/div>/', $data);
    $info[2] = $author;
    // $time = zhengze('/时间:<\/span>(.*?) <span/', $data);
    $info[3] = NULL;
    // $description = zhengze('/mdo">[\s\S](.*?)<\/div>/m', $data);
    $info[4] = NULL;
    return $info;
}
function get_redirect_url($url, $ua = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $httpheader[] = "Accept:*/*";
    $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
    $httpheader[] = "Accept-Language:zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($ch, CURLOPT_HEADER, true);
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0");
    }
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    preg_match("/Location: (.*?)\r\n/iU", $ret, $location);
    return $location[1];
}
function c($url, $ua = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    $headers = array(
        "accept-language: zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6"
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Android 4.4; Mobile; rv:70.0) Gecko/70.0 Firefox/70.0");
    }
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
function zhengze($biaodashi, $link)
{
    $soisMatched = preg_match($biaodashi, $link, $somatches);
    return $somatches[1];
}
function start($link, $password)
{
    $result = array(
        'code' => 200,
        'data' => array(),
        'msg' => "解析成功"
    );
    // 去除前缀
    $link = str_replace("https://", "", $link);
    $link = str_replace("http://", "", $link);
    // 获取链接信息
    $lanzou = zhengze('/.lanzou(.*).com/', $link);
    $lanzou_prefix = zhengze('/(.*).lanzou' . $lanzou . '.com/', $link);
    $length = strlen($link) - strrpos($link, "/") + 1;
    $lanzou_id = substr($link, strrpos($link, "/") + 1, $length);
    // 修正链接
    $realLink = "https://" . $lanzou_prefix . ".lanzou" . $lanzou . ".com/" . $lanzou_id;
    $testData = c($realLink, "");
    $accessiblePrefix = ['w', 'k', 'i', 'l'];
    if (stripos($testData, '谨防刷单兼职，网贷，金融，裸聊敲诈，赌博等诈骗，请立即举报') == FALSE) {
        for ($i = 0; $i <= count($accessiblePrefix) - 1; $i++) {
            $lanzou = $accessiblePrefix[$i];
            $realLink = "https://" . $lanzou_prefix . ".lanzou" . $lanzou . ".com/" . $lanzou_id;
            $testData = c($realLink, "");
            if (stripos($testData, '谨防刷单兼职，网贷，金融，裸聊敲诈，赌博等诈骗，请立即举报') != FALSE || stripos($testData, '文件受密码保护，请输入密码继续下载') != FALSE) {
                break;
            }
            if ($i == count($accessiblePrefix) - 1) {
                return array(
                    "code" => 202,
                    "msg" => '链接错误'
                );
            }
        }
    }
    $curlData = $testData;
    $documentData = c($realLink, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36");
    if (stripos($documentData, '文件受密码保护，请输入密码继续下载')) {
        $curlData = $documentData;

        // 文件夹
        preg_match_all('/var (.*)\';/m', $curlData, $somatches, PREG_SET_ORDER, 0);
        $docname = $somatches[0][1];
        $t = $somatches[1][1];
        $k = $somatches[2][1];
        $docname = zhengze('/=\'(.*)/', $docname);
        $t = zhengze('/= \'(.*)/', $t);
        $k = zhengze('/= \'(.*)/', $k);
        $fid = zhengze('/\'fid\':(.*),/', $curlData);
        $uid = zhengze('/\'uid\':\'(.*)\'/', $curlData);
        $pgs = 1;
        $post_data = array('lx' => 2, 'fid' => intval($fid), 'uid' => $uid, 'pg' => intval($pgs), 'rep' => '0', 't' => $t, 'k' => $k, 'up' => 1, 'ls' => 1, 'pwd' => $password);
        $postdata = http_build_query($post_data);
        $options = array('http' => array(
            'method' => 'POST',
            'header' => 'Referer: ' . "https:" . $lanzou_prefix . ".lanzou" . $lanzou . ".com/" . '\\r\\n' . 'Accept-Language:zh-CN,zh;q=0.9\\r\\n',
            'content' => $postdata,
        ));
        $context = stream_context_create($options);
        $data = file_get_contents('https://' . $lanzou_prefix . '.lanzou' . $lanzou . '.com/filemoreajax.php', false, $context);
        $dataa = json_decode($data, true);
        if ($dataa['zt'] != 1) {
            return array(
                'code' => 201,
                'msg' => '密码错误'
            );
        }
        $i = 0;
        while (1) {
            if ($dataa['text'][$i]['id'] != NULL) {
                $file_id = $dataa['text'][$i]['id'];
                $curlData = c("https://" . $lanzou_prefix . ".lanzou" . $lanzou . ".com/tp/" . $file_id, "");
                $pototo = zhengze('/var tedomain = \'(.*)\';/', $curlData);
                if (!$pototo) {
                    $lanzou = "w";
                    $curlData = c("https://" . $lanzou_prefix . ".lanzou" . $lanzou . ".com/tp/" . $lanzou_id, "");
                    $pototo = zhengze('/var tedomain = (.*)/', $curlData);
                }
                $spototo = zhengze('/var domianload = \'(.*)\';/', $curlData);
                $resultabc = $pototo . $spototo;
                $resultabc = get_redirect_url($resultabc, "Mozilla/5.0 (Android 4.4; Mobile; rv:70.0) Gecko/70.0 Firefox/70.0");
                $info = get_file_info($curlData);
                array_push($result['data'], array(
                    'id' => $dataa['text'][$i]['id'],
                    "name" => $info[0],
                    "size" => $info[1],
                    "author" => $info[2],
                    "time" => $info[3],
                    "description" => $info[4],
                    "DownloadURL" => $resultabc
                ));
            } else {
                break;
            }
            $i = $i + 1;
        }
        return $result;
    }
    // 有密码的
    if ($password) {
        if (stripos($curlData, '分享者')) {
            // 普通用户
            $realLink = "https://" . $lanzou_prefix . ".lanzou" . $lanzou . ".com/tp/" . $lanzou_id;
            $curlData = c($realLink, "");
            $posign = zhengze('/var postsign = (.*)/', $curlData);
            $posign = str_replace("'", "", $posign);
            $posign = str_replace(";", "", $posign);
            $info = get_file_info($curlData);
        } else {
            // 会员用户
            $posign = zhengze('/sign=([^&]*)/', $curlData);
            $info = get_file_info_vip($curlData);
        }
        // 有密码请求网址
        $post_data = array('action' => 'downprocess', 'sign' => $posign, 'p' => $password);
        $postdata = http_build_query($post_data);
        $options = array('http' => array(
            'method' => 'POST',
            'header' => 'Referer: ' . "https:" . $lanzou_prefix . ".lanzou" . $lanzou . ".com/" . '\\r\\n'  . 'Accept-Language:zh-CN,zh;q=0.9\\r\\n',
            'content' => $postdata,
        ));
        $context = stream_context_create($options);
        $data = file_get_contents('https://' . $lanzou_prefix . '.lanzou' . $lanzou . '.com/ajaxm.php', false, $context);
        $data123 = json_decode($data, true);
        $dom = $data123['dom'];
        $url = $data123['url'];
        $zt = $data123['zt'];
        if ($zt != 1) {
            return array(
                'code ' => 201,
                'msg' => '密码错误'
            );
        }
        $resultUrl = $dom . '/file/' . $url;
        $headers = array(
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate',
            'Accept-Language: zh-CN,zh;q=0.9',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Pragma: no-cache',
            'Upgrade-Insecure-Requests: 1',
            'X-Forwarded-For: ' . rand_IP()
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $resultUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);
        $url = curl_getinfo($curl);
        curl_close($curl);
        $downloadLink = $url["redirect_url"];
        array_push($result['data'], array(
            "id" => $lanzou_id,
            "password" => $password,
            "name" => $info[0],
            "size" => $info[1],
            "author" => $info[2],
            "time" => $info[3],
            "description" => $info[4],
            "DownloadURL" => $downloadLink
        ));
        return $result;
    }
    // 无密码的
    if (stripos($curlData, '分享者')) {
        // 普通用户
        $realLink = "https://" . $lanzou_prefix . ".lanzou" . $lanzou . ".com/tp/" . $lanzou_id;
        $curlData = c($realLink, "");
        $pototo = zhengze('/var tedomain = \'(.*)\';/', $curlData);
        if (!$pototo) {
            $lanzou = "w";
            $curlData = c("https://" . $lanzou_prefix . ".lanzou" . $lanzou . ".com/tp/" . $lanzou_id, "");
            $pototo = zhengze('/var tedomain = (.*)/', $curlData);
        }
        $spototo = zhengze('/var domianload = \'(.*)\';/', $curlData);
        $resultUrl = $pototo . $spototo;
        $resultUrl = get_redirect_url($resultUrl, "Mozilla/5.0 (Android 4.4; Mobile; rv:70.0) Gecko/70.0 Firefox/70.0");
        $downloadLink = $resultUrl;
        $info = get_file_info($curlData);
        array_push($result['data'], array(
            "id" => $lanzou_id,
            "name" => $info[0],
            "size" => $info[1],
            "author" => $info[2],
            "time" => $info[3],
            "description" => $info[4],
            "DownloadURL" => $downloadLink
        ));
    } else {
        // 会员用户
        $urlpt = zhengze('/var urlpt = \'(.*)\';/', $curlData);
        $downloadLink = zhengze('/var link = \'(.*)\';/', $curlData);
        $resultUrl = $urlpt . $downloadLink;
        $resultUrl = get_redirect_url($resultUrl, "Mozilla/5.0 (Android 4.4; Mobile; rv:70.0) Gecko/70.0 Firefox/70.0");
        $info = get_file_info_vip($curlData);
        array_push($result['data'], array(
            "id" => $lanzou_id,
            "name" => $info[0],
            "size" => $info[1],
            "author" => $info[2],
            "time" => $info[3],
            "description" => $info[4],
            "DownloadURL" => $resultUrl
        ));
    }
    return $result;
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
            "msg" => '解析失败',
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
