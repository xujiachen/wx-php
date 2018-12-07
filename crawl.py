# coding:utf-8

import sys
import requests
import pymysql
from bs4 import BeautifulSoup as bs

reload(sys)
sys.setdefaultencoding('utf-8')
# 创建连接
conn = pymysql.connect(host='127.0.0.1',
                       port=3306,
                       user='sql140_143_30_1',
                       passwd='rR5dfsZyr2',
                       db='sql140_143_30_1',
                       charset='utf8')
cursor = conn.cursor(cursor=pymysql.cursors.DictCursor)
cursor.execute('select weather_code from ins_county')
result = cursor.fetchall()

for i in range(len(result)):
    cityCode = result[i]['weather_code']
    url = "http://wthrcdn.etouch.cn/WeatherApi?citykey=" + cityCode
    r = requests.get(url, verify=False)
    soup = bs(r.text, 'xml')
    wendu = soup.find('wendu').text
    fengli = soup.find('fengli').text
    shidu = soup.find('shidu').text
    fengxiang = soup.find('fengxiang').text
    
    if soup.find('pm25'):
        pm25 = soup.find('pm25').text
    else:
        pm25 = 'NULL'
    if soup.find('suggest'):
        suggest = soup.find('suggest').text
    else:
        suggest = 'NULL'
    if soup.find('quality'):
        quality = soup.find('quality').text
    else:
        quality = 'NULL'
    weather_content = '温度：' + wendu + '℃' + '\n风力：' + fengli + \
                      '\n湿度：' + shidu + '\n风向：' + fengxiang + \
                      '\nPM2.5：' + pm25 + '\n空气质量：' + quality + \
                      '\n建议：' + suggest
    sql_exe = 'UPDATE ins_county SET weather_info = \''\
              + weather_content + '\' WHERE weather_code = ' + cityCode
    print(sql_exe)
    cursor.execute(sql_exe)
    conn.commit()
cursor.close()
conn.close()

