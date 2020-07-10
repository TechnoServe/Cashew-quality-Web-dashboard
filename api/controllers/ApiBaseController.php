<?php

namespace api\controllers;

use yii\rest\Controller;

class ApiBaseController extends Controller
{

    public function response($code, $data = '')
    {
        $response = array();
        $message = $this->getStatusCodeMessage($code);
        if (!empty($message)) {
            //$response = array("status" => false, "message" => $message, "data" => $data, "code" => $code);
            $response = array("status" => true, "data" => $data);
        }
        $this->setHeader($code);

        echo json_encode($response);
        die;
    }

    private function getStatusCodeMessage($status)
    {
        $codes = array(
            // Success 2xx
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            // Client Error 4xx
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            // Server Error 5xx
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            509 => 'Bandwidth Limit Exceeded',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }


    private function setHeader($status)
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
        $content_type = "application/json; charset=utf-8";
        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "WantCode <WantCode.in>");
    }

    public function authenticate($params)
    {
        // If IS_AUTH is set in constant then required to check header
        if ('IS_AUTH') {
            $encodeData = json_encode($params);
            $msg = array('response' => false, "message" => "Invalid token credentials");
            $hash = hash_hmac('sha256', $encodeData, Yii::$app->params['ApiTokenKey']);
            if (!isset($_SERVER['HTTP_X_API_TOKEN'])) {
                $this->setHeader(401);
                $this->response(401, $msg);
            }

            if ($_SERVER['HTTP_X_API_TOKEN'] != $hash) {
                $this->setHeader(401);
                $this->response(401, $msg);
            }
        }
    }

}