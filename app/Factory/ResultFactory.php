<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 7/21/18
 * Time: 7:20 PM
 */

namespace App\Factory;


class ResultFactory
{
    public function success($object, $key = 'object', $status_code = 200)
    {
        return (object)[
            'success'  => true,
            'status_code' => $status_code,
            $key  => $object,
            'error'   => null
        ];
    }

    public function error($error, $key = 'object', $status_code = 400)
    {
        return (object)[
            'success'  => false,
            'status_code' => $status_code,
            $key   => null,
            'error'    => $error
        ];
    }
}