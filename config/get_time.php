<?php
header("Content-type:application/json;charset=utf-8");
class get_time{
	private $sec;
    public function __construct(){
   		date_default_timezone_set('PRC');
   	}
   	public function get_now_msec(){
   	     list($msec, $sec) = explode(' ', microtime());
         $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
         return $msectime;
   	}
   	public function get_now_sec(){
		 $this -> sec=mktime();
   		 return  $this -> sec;
   	}
   	public function get_now_format(){
		 return date('Y-m-d h:i:s A');
   	}
   	public function get_now_format_d(){
   		 return date('Y-m-d');
   	}
   	public function sec_time_format($sec_time){
   		 return date('Y-m-d H:i:s',$sec_time);
   	}
    public function sec_time_format_d($sec_time){
        return date('Y-m-d',$sec_time);
    }
   	public function format_time_sec($format_time){
		 $date=date_create($format_time);
         return date_timestamp_get($date);
   	}

   	public function get_day_sec($year,$month,$day){
		$date=date_create($year.'-'.$month.'-'.$day);
        return date_timestamp_get($date);
   	}

   	public function days_by_year_month($year,$month){
   		$i=$month;
        $y=$year;
        return date("t",strtotime("$y-$i"));
   	}
}