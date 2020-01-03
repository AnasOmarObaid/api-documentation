<?php

namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{

    //-- start responseTrail function
    public function responseTrait($data, $status = true, $error = null, $code = 200)
    {

        $array = [
            'data' => $data,
            'status' => $status,
            'error'   => $error,
        ];

        return response()->json($array, $code);
    } //-- end responseTrail function


    //-- start notFountResponse
    public function notFountResponse($code = 404)
    {
        return $this->responseTrait('null', false, 'Not Found ', $code);
    } //-- end not fount response

    //-- start request function
    public function requestValidate($request)
    {
        return $request->except(['method', 'csrf_token']);
    } //-- end requestValidate function
}//-- end ApiResponseTrait
