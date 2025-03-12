<?php
namespace App\Helpers;

use Illuminate\Support\Collection;
use Response;

class CommonHelper
{
    public static function rowResponse($response){
        return Response::json($response);
    }

    public static function response($response, $type = null, $message = "")
    {
        $array = [];
        if($type == SUCCESS){
            $array = array('status' => 1, 'title' => 'Success');
        }
        if($type == ERROR){
            $array = array('status' => 0, 'title' => 'Error');
        }

        if($message != ""){
            $array['message'] = $message;
        }

        if (!empty($array)) {
            if(is_array($response)){
                $response = array_merge($array, $response);
            }else{
                $response = (new Collection($array))->merge($response)->all();
            }
        }
        return Response::json($response);
    }

    public static function responseError($message, $code = 404)
    {
        return response()->json(array(
            'status' => 0,
            'title' => 'Error',
            'message' => $message
        ), $code);
    }

    public static function responseErrorWithData($errors, $message = "", $code = 404)
    {
        $array = array('status' => 0, 'title' => 'Error');
        if($message != ""){
            $array['message'] = $message;
        }
        $array['errors'] = $errors;
        return Response::json($array, $code);
    }

    public static function responseSuccess($message, $code = 200)
    {
        return Response::json(array('status' => 1, 'title' => 'Success', 'message' => $message), $code);
    }

    public static function responseSuccessWithData($data, $message = "", $code = 200)
    {
        return Response::json(array('status' => 1, 'title' => 'Success', 'message' => $message, 'data' => $data), $code);
    }

    public static function responseWithData($data,$total = 1, $code = 200)
    {
        return Response::json(array('status' => 1, 'title' => 'success','total'=> $total, 'data' => $data), $code);
    }

    public static function getColumnComment($tableName, $columnName){
        $databaseName = \DB::connection()->getDatabaseName();
        $comments = \DB::select("SELECT COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$databaseName' AND TABLE_NAME = '$tableName' AND COLUMN_NAME = '$columnName'");
        return $comments[0]->COLUMN_COMMENT;
    }


}
