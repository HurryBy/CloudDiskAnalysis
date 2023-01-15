// ==UserScript==
// @name         Lanzou直链解析
// @namespace    https://lanzou.humorously.tk/
// @version      0.1
// @description  在蓝奏云连接旁出现点击下载的按钮
// @author       Hurry
// @match        *://*/*
// @match        *:/*
// @match        *
// @icon         https://www.google.com/s2/favicons?sz=64&domain=www.lanzou.com
// @grant GM_setValue
// @grant GM_getValue
// @grant GM_setClipboard
// @grant GM_log
// @grant GM_xmlhttpRequest
// @grant unsafeWindow
// @grant window.close
// @grant window.focus
// @connect      lanzou.humorously.tk
// ==/UserScript==

(function() {
    'use strict';
    var HtmlMessage = document.getElementsByTagName("body")[0];
    const m = '';
    const regex = /((?:https?:\/\/)?(?:[a-zA-Z0-9\-.]+)?lanzou[a-z]\.com\/[a-zA-Z0-9_\-]+)/g;
    function GetRegex(){
        GM_setValue(m, regex.exec(HtmlMessage.outerHTML));
        if (m.index === regex.lastIndex) {
            if(m !== null){
                regex.lastIndex++;
            }
        }
    }
    function requests(link){
        GM_xmlhttpRequest({
            "method": "GET",
            "url": "https://lanzou.humorously.tk/api/api.php?link=" + link + "&red=",
            "headers": {
                "user-agent": 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36'
            },
            "onload": function (result) {
                var text = result.response;
                var obj = JSON.parse(text);
                var url = obj.data.url;
                console.log(url);
                var body = document.getElementsByTagName("body")[0];
                body.outerHTML = body.outerHTML.toString().replace(link,link + " <a href=" + url + ">[一键直链下载]</a>");
            }
        });
    }
    GetRegex();
    var match = GM_getValue(m,'1');
    match.forEach((match) => {
        requests(`${match}`);
    });
})();