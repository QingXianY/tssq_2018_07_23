<?php
class baidu_map{
    private $baidu_mishi='sfhBu71jI5yhUQbm5aVDwGs54CGDW810';
    public function get_positon_detail($longitude,$latitude){
        $baidu_url = "http://api.map.baidu.com/geocoder/v2/?ak=".$this->baidu_mishi."&callback=renderReverse&location=".$latitude.",".$longitude."&output=json&pois=0";
        $res = file_get_contents($baidu_url);    //获取文件内容或获取网络请求的内容
        return json_decode(explode(')',(explode('(',$res)[1]))[0]);
    }
}