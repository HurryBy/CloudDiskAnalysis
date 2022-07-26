import requests
import re
mobile_agent = "Mozilla/5.0 (Android 4.4; Mobile; rv:70.0) Gecko/70.0 Firefox/70.0"
headers = {
    "user-agent": mobile_agent,
    "accept-language": 'zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6'
}
url = input("请输入蓝奏云的Url.并非ID:")
try:
    url = url.replace('https://','')
except:
    try:
        url = url.replace('http://','')
    except:
        pass
lanzou = re.findall('.lanzou(.*).com/',url)[0]
lanzou_prefix = re.findall('(.*).lanzou' + lanzou + '.com',url)[0]
lanzou_id = re.findall('.lanzou' + lanzou + '.com/(.*)',url)[0]
tp_url = 'https://' + lanzou_prefix + '.lanzou' + lanzou + '.com/tp/' + lanzou_id
tp_response = requests.get(url=tp_url,headers=headers)
pototo = re.findall('var pototo = (.*)',tp_response.text)[0]
spototo = re.findall('var spototo = (.*)',tp_response.text)[0]
pototo = pototo.replace('\'' , '').replace(';','')
spototo = spototo.replace('\'' , '').replace(';','')
final_url = pototo+spototo
final_response = requests.get(url=final_url,headers=headers,allow_redirects=False)
print (final_response.headers["Location"])
input('')