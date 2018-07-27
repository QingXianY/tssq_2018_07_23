<?php
include_once "../class/Role.php";
/**
 * 数据操作类
 */
class Request
{
    //允许的请求方式
    private static $method_type = array('get', 'post', 'put', 'patch', 'delete');


    public static function getRequest(){
        //请求方式
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (in_array($method, self::$method_type)) {
            //调用请求方式对应的方法
            $data_name = $method . 'Data';
            return self::$data_name($_REQUEST);
        }
        return false;
    }

    //GET 获取信息
    private static function getData($request_data)
    {
        $role_name = isset($request_data['role_name'])?$request_data['role_name']:null;
        //GET /class/name：获取某个指定角色的信息
        $Role = Role::getInstance();
        return $Role->getRoleList($role_name);
    }

    //POST /class：新建一个班
    private static function postData($request_data)
    {
        if (!empty($request_data['name'])) {
            $data['name'] = $request_data['name'];
            $data['count'] = (int)$request_data['count'];
            self::$test_class[] = $data;
            return self::$test_class;//返回新生成的资源对象
        } else {
            return false;
        }
    }

    //PUT /class/ID：更新某个指定班的信息（全部信息）
    private static function putData($request_data)
    {
        $class_id = (int)$request_data['class'];
        if ($class_id == 0) {
            return false;
        }
        $data = array();
        if (!empty($request_data['name']) && isset($request_data['count'])) {
            $data['name'] = $request_data['name'];
            $data['count'] = (int)$request_data['count'];
            self::$test_class[$class_id] = $data;
            return self::$test_class;
        } else {
            return false;
        }
    }

    //PATCH /class/ID：更新某个指定班的信息（部分信息）
    private static function patchData($request_data)
    {
        $class_id = (int)$request_data['class'];
        if ($class_id == 0) {
            return false;
        }
        if (!empty($request_data['name'])) {
            self::$test_class[$class_id]['name'] = $request_data['name'];
        }
        if (isset($request_data['count'])) {
            self::$test_class[$class_id]['count'] = (int)$request_data['count'];
        }
        return self::$test_class;
    }

    //DELETE /class/ID：删除某个班
    private static function deleteData($request_data)
    {
        $class_id = (int)$request_data['class'];
        if ($class_id == 0) {
            return false;
        }
        unset(self::$test_class[$class_id]);
        return self::$test_class;
    }
}