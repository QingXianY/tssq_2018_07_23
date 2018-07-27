<?php
class file{
    public function base64_image_content($base64_image_content,$path){
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
            $new_file = $path."/".date('Ymd',time())."/";
            if(!file_exists($new_file)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $new_file = $new_file.time().".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                return '/'.$new_file;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function upload_image_file($file,$path,$image_name,$url_head){
        $name = $file['name'];
        $type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
//        $allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型
        //判断文件类型是否被允许上传
//        if(!in_array($type, $allow_type)){
//            //如果不被允许，则直接停止程序运行
//            echo json_encode(array('status'=>0,'msg'=>"上传失败！图片格式只支持'jpg','jpeg','gif','png"));
//            return ;
//        }
        //判断是否是通过HTTP POST上传的
        if(!is_uploaded_file($file['tmp_name'])){
            //如果不是通过HTTP POST上传的
            return array('status'=>0,'msg'=>"上传失败！,请求方式错误");
        }
        $upload_path = $path; //上传文件的存放路径
        //开始移动文件到相应的文件夹
        if(move_uploaded_file($file['tmp_name'],$upload_path.$image_name.'.'.$type)){
            return array('status'=>1,'msg'=>"上传成功！,请求方式错误",'data'=>$url_head.$image_name.'.'.$type);
        }else{
            return array('status'=>0,'msg'=>"上传失败！,请求方式错误");
        }
    }
    public function upload_excel_file($file,$path,$excel_name){
        $name = $file['name'];
        $type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
        $allow_type = array('xls','xlsx'); //定义允许上传的类型
        //判断文件类型是否被允许上传
        if(!in_array($type, $allow_type)){
            //如果不被允许，则直接停止程序运行
            echo json_encode(array('status'=>0,'msg'=>"上传失败！音频格式只支持'xls','xlsx'"));
            return ;
        }
        //判断是否是通过HTTP POST上传的
        if(!is_uploaded_file($file['tmp_name'])){
            //如果不是通过HTTP POST上传的
            return ;
        }
        $upload_path = $path; //上传文件的存放路径
        //开始移动文件到相应的文件夹
        if(move_uploaded_file($file['tmp_name'],$upload_path.$excel_name.'.'.$type)){
            return $excel_name.'.'.$type;
        }else{
            return 'False';
        }
    }
}