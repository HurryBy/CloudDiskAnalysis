<?php
error_reporting(0);
function rand_IP(){
    $ip2id = round(rand(600000, 2550000) / 10000);
    $ip3id = round(rand(600000, 2550000) / 10000);
    $ip4id = round(rand(600000, 2550000) / 10000);
    $arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
    $randarr= mt_rand(0,count($arr_1)-1);
    $ip1id = $arr_1[$randarr];
    return $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
}
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
function start($link = 0, $password){
    if ($link) {
        $lanzou = zhengze('/.lanzou(.*).com/', $link);
        $lanzou_prefix = zhengze('/(.*).lanzou'.$lanzou.'.com/', $link);
        $length = strlen($link)-strrpos($link,"/")+1;
        $lanzou_id = substr($link,strrpos($link,"/")+1,$length);
    }
    $curldata = c("https://".$lanzou_prefix.".lanzou".$lanzou.".com/tp/".$lanzou_id, "");
    if(stripos($curldata, '举报文件') == FALSE){
        return '链接错误';
    }
    if($password){
        $posign = zhengze('/var posign = (.*)/', $curldata);
        $posign = str_replace("'","",$posign);
        $posign = str_replace(";","",$posign);
        // 有密码请求网址
        $post_data = array('action' => 'downprocess', 'sign' => $posign, 'p' => $password);
        $postdata = http_build_query($post_data);
        $options = array('http' => array(
            'method' => 'POST',
            'header' => 'Referer: '."https:".$lanzou_prefix.".lanzou".$lanzou.".com/".'\\r\\n' . 'Accept-Language:zh-CN,zh;q=0.9\\r\\n',
            'content' => $postdata,
        ));
        $context = stream_context_create($options);
        $data = file_get_contents('https://'.$lanzou_prefix.'.lanzou'.$lanzou.'.com/ajaxm.php', false, $context);
        $data123 = json_decode($data,true);
        $dom = $data123['dom'];
        $url = $data123['url'];
        $zt = $data123['zt'];
        if ($zt != 1){
            return '密码错误';
        }
        $result = $dom. '/file/' . $url;
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
        curl_setopt($curl, CURLOPT_URL, $result);
        curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);
        $url=curl_getinfo($curl);
        curl_close($curl);
        return $url["redirect_url"];
        // curl会被检测 :((( 导致出来的结果被加密
        // $post_data = ['action'=>'downprocess','sign'=>$posign,'p'=>$password];
        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, 'https://'.$lanzou_prefix.'.lanzou'.$lanzou.'.com/ajaxm.php');
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($curl, CURLOPT_POST, 1);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        // $headers = array(
        //     "Accept:*/*",
        //     "Accept-Encoding:gzip,deflate,sdch",
        //     "accept-language: zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6",
        //     "Referer: https://".$lanzou_prefix.".lanzou".$lanzou.".com/",
        // );
        // curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        // curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Android 4.4; Mobile; rv:70.0) Gecko/70.0 Firefox/70.0");
        // $data = curl_exec($curl);
        // curl_close($curl);
        // $data = strval($data);
        // $data123 = json_decode($data,true);
        // $dom = $data123['dom'];
        // $url = $data123['url'];
        // $result = $dom. '/file/' . $url;
        // echo $url;
    }else{
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
}
$link = isset($_GET['link']) ? $_GET['link'] : NULL;
$password = isset($_GET['pwd']) ? $_GET['pwd'] : NULL;
$redirect = isset($_GET['red']) ? $_GET['red'] : NULL;
if ($link==NULL) {
	echo "蓝奏云解析下载系统：</br>支持外链分享地址(link)解析</br>在链接后面加入?link=你的蓝奏分享链接&pwd=密码(可空)&red=任意数(可空)[填写任意数代表直接跳转至直链链接,可用于个人站点]</br>即可";
    exit(); 
}elseif ($link) {   
    $link = str_replace("https://","",$link);
    $link = str_replace("http://","",$link);
    if($password){
        $result = start($link,$password);
    }else{
        $result = start($link,NULL);
    }
}
if($redirect == NULL){
    echo $result;
}else{
  header("HTTP/1.1 301 Moved Permanently");
  header('Location: '.$result);
  exit();
}
?>