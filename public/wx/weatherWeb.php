<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxa57e401294e8f8ab", "648b66447644aca30baff317c10d794d");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
  <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
        // 所有要调用的 API 都要加到这个列表中
        'getLocation',
        'openLocation',
        'scanQRCode',
    ]
  });
  
    var latitude = 0.0;
    var longitude = 0.0;

    wx.ready(function () {
        // 在这里调用 API
        wx.getLocation({
            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                alert("latitude:" + latitude + "longitude:" + longitude);
              

                
                //var script = document.createElement('script');
                //script.setAttribute("type","text/javascript");
                //script.src = "http://api.map.baidu.com/geocoder?location=38.990998,103.645966&output=json&key=fjDkD13i9PWIGOfmgMTBzdVEbN05LG2G&callback=abc";
                //script.src = "http://140.143.30.100/wx/test2.json&callback=abc";
                /*script.onload = script.onreadystatechange = function() {
                   alert("aaa");
                     if (request.readyState == 4) {
                        alert(request.status);
                        if (request.status == 200) {
                            var response = request.responseXML;
                            var city = response.getElementsByTagName('city')[0].textContent; 
                            alert(city);
                        } else {
                            //alert("aaa");
                        }
                    } else {
                        //alert("ccc");
                    }
                };*/
                //document.head.appendChild(script);
                
                
                var request = new XMLHttpRequest();
                var postStr = String(latitude) + "," + String(longitude);
                var data = "location=" + postStr; 
                
                request.onreadystatechange = function() {
                    if (request.readyState == 4) {
                        if (request.status == 200) {
                            var response = request.responseText;
                            var div = document.createElement('div');
                            var p = document.createElement('p');
                            p.innerHTML = response;
                            div.appendChild(p);
                            document.body.appendChild(div);
                        } else {
                        }
                    } else {
                    }
                }
                //request.open('GET', "http://api.map.baidu.com/geocoder?location=38.990998,103.645966&output=xml&key=fjDkD13i9PWIGOfmgMTBzdVEbN05LG2G", true);
                request.open('POST', "apiServer.php", true);
                request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
                request.send(data);
                
            }
        });
    });

    function openLocation() {
        wx.ready(function () {
            wx.openLocation({
                latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
                longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
                name: '', // 位置名
                address: '', // 地址详情说明
                scale: 15, // 地图缩放级别,整形值,范围从1~28。默认为最大
                infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
            });
        });
    }


    function scanQRCode() {
        wx.ready(function () {
            wx.scanQRCode({
                needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                }
            });
        });
    }
  
    /*function loadScript(url, func) {
        //var head = document.head || document.getElementByTagName('head')[0];
        var script = document.createElement('script');
        script.setAttribute("type","text/javascript");
        script.src = url;
        
        script.onload = script.onreadystatechange = function(){
              alert(this.readyState);
             if(!this.readyState || this.readyState=='loaded' || this.readyState=='complete'){
                 func();
                 script.onload = script.onreadystatechange = null;
             }
        };
        head.insertBefore(script, 0);
    }*/
  
</script>
</head>
<body>
  
</body>

</html>
