var HtmlMessage = document.getElementsByTagName("body")[0];
const regex = /((?:https?:\/\/)?(?:[a-zA-Z0-9\-.]+)?lanzou[a-z]\.com\/[a-zA-Z0-9_\-]+)/g;
var link = '';
while ((m = regex.exec(HtmlMessage.outerHTML)) !== null) {
    if (m.index === regex.lastIndex) {
        regex.lastIndex++;
    }
    m.forEach((match, groupIndex) => {
        //console.log(`Found match, group ${groupIndex}: ${match}`);
        var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function(){
		if (xhr.readyState === 4){
			if (xhr.status === 200){
                    var text = xhr.responseText;
					obj = JSON.parse(text);
					if(obj.msg == "解析成功"){
						url = obj.data.url;
						HtmlMessage.outerHTML = HtmlMessage.outerHTML.toString().replace(`${match}`,`${match} <a href=` + url + ">[Hurry]一键下载</a>");
					}else{
						HtmlMessage.outerHTML = HtmlMessage.outerHTML.toString().replace(`${match}`,`${match} <a href=` + url + ">[Hurry]一键下载(未获取到下载链接)</a>");
					}
					
				}
				console.error(xhr.statusText);
			}
		};
		xhr.onerror = function (e) {
		    console.error(xhr.statusText);
		};
		xhr.open('GET', `https://lanzou.humorously.tk/api/api.php?link=${match}&red=`, true);
		xhr.send(null);
    });
}