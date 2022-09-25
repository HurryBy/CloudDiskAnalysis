var HtmlMessage = document.documentElement.outerHTML;
const regex = /((?:https?:\/\/)?(?:[a-zA-Z0-9\-.]+)?lanzou[a-z]\.com\/[a-zA-Z0-9_\-]+)/g;
var link = '';
while ((m = regex.exec(HtmlMessage)) !== null) {
    if (m.index === regex.lastIndex) {
        regex.lastIndex++;
    }
    m.forEach((match, groupIndex) => {
        //console.log(`Found match, group ${groupIndex}: ${match}`);
        var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function(){
		if (xhr.readyState === 4){
			if (xhr.status === 200){
                    console.log(xhr.responseText)
				}
				console.error(xhr.statusText);
			}
		};
		xhr.onerror = function (e) {
		    console.error(xhr.statusText);
		};
		xhr.open('GET', `https://wgame.miaovps.com:32022/api/api.php?link=${matches}&red=`, true);
		xhr.send(null);
    });
}



