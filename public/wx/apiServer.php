<?php

    header("Content-type:text/plain; charset=utf-8");
    
    $location= $_POST['location'];
    $temp = "test";
    $url_get = "http://api.map.baidu.com/geocoder?location=".$location."&output=json&key=fjDkD13i9PWIGOfmgMTBzdVEbN05LG2G";
    $response = file_get_contents($url_get);
    $data = json_decode($response, true);
    $city = $data['result']['addressComponent']['city'];
    $temp = $city;
    $city = mb_substr($city, 0, mb_strlen($city, 'utf-8') - 1, 'utf-8');
    
    $url_get = "http://140.143.30.100/index.php/api/weather/read/county_name/".$city;
    $response = file_get_contents($url_get);
    $data = json_decode($response, true);
    $code = $data['code'];
    if ($code == "200") {
        $weather_info = $data['data'][0]['weather_info'];
    } else {
        $weather_info = "请求失败"; 
    }
    echo $temp."<br />".$weather_info;
    //header('Content-Length: ' . strlen($location));
    //echo mb_strlen($city, 'utf-8');
    //echo "北京";  
    //script.src = "http://api.map.baidu.com/geocoder?location=38.990998,103.645966&output=json&key=fjDkD13i9PWIGOfmgMTBzdVEbN05LG2G&callback=abc";
?>