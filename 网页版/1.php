<?php
error_reporting(0);
function get_redirect_url($url,$ua=0){
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
    preg_match("/Location: (.*?)\r\n/iU",$ret,$location);
    return $location[1];
}
function c($url, $ua = 0){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    $headers = array(
        "accept-language: zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6"
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Android 4.4; Mobile; rv:70.0) Gecko/70.0 Firefox/70.0");
    }
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
function zhengze($biaodashi, $link){
    $soisMatched = preg_match($biaodashi, $link, $somatches);
    return $somatches[1];
}
function start($link = 0){
    if ($link) {
        $lanzou = zhengze('/.lanzou(.*).com/', $link);
        $lanzou_prefix = zhengze('/(.*).lanzou'.$lanzou.'.com/', $link);
        $length = strlen($link)-strrpos($link,"/")+1;
        $lanzou_id = substr($link,strrpos($link,"/")+1,$length);
    }
    $curldata = c("https://".$lanzou_prefix.".lanzou".$lanzou.".com/tp/".$lanzou_id, "");
    $pototo = zhengze('/var pototo = (.*)/',$curldata);
    if(!$pototo){
        $lanzou = "w";
        $curldata = c("https://".$lanzou_prefix.".lanzou".$lanzou.".com/tp/".$lanzou_id, "");
        $pototo = zhengze('/var pototo = (.*)/',$curldata);
    }
    $spototo = zhengze('/var spototo = (.*)/',$curldata);
    $pototo = str_replace("'","",$pototo);
    $pototo = str_replace(";","",$pototo);
    $spototo = str_replace("'","",$spototo);
    $spototo = str_replace(";","",$spototo);
    $result = $pototo.$spototo;
    $result = get_redirect_url($result,"Mozilla/5.0 (Android 4.4; Mobile; rv:70.0) Gecko/70.0 Firefox/70.0");
    return $result;
        
}
$link = isset($_GET['link']) ? $_GET['link'] : NULL;
if ($link==NULL) {
	echo "蓝奏云解析下载系统：</br>支持外链分享地址(link)解析</br>在链接后面加入?link=你的蓝奏分享链接</br>即可";
    exit();
}elseif ($link) {   
    $link = str_replace("https://","",$link);
    $link = str_replace("http://","",$link);
	$result = start($link);
}
if($result){
    echo $result;
}else{
    echo 'Error 请前往Gitee提交issue';
}
?>