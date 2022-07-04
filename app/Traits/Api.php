<?php

namespace App\Traits;

use GuzzleHttp\Client;
use App\Helpers\MyHelper;
use GuzzleHttp\Exception\RequestException;

trait Api {

    public $client = null;

    public function __init_request_api($request, $param = array(), $debug = array()) { 
        if (isset($param['uri']) && !empty($param['uri'])) {
            $url = $param['uri'];
            if (isset($debug['url']) && !empty($debug['url']) && $debug['url'] == true) {
                dd($param['uri']);
            }
            $method = $param['method'];
            $this->client = new Client();
            try {
                $headers = [
                    'accept' => '*/*',
                    'ip' => MyHelper::getIp(),
                    'Content-Type' => 'application/json',
                    'browser' => MyHelper::getBrowser()['userAgent'],
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods' => $method
                ];
                $header_auth = array();
                if (isset($param['auth']) && $param['auth'] == true) {
                    $header_auth = array('token' => $this->__init_token($request));
                }
                $headers_1 = array_merge($headers, $header_auth);
                $header_cust = array();
                if (isset($param['header']) && !empty($param['header'])) {
                    $header_cust = $param['header'];
                }
                $headers_all = array_merge($headers_1, $header_cust);
                if (isset($debug['header']) && !empty($debug['header']) && $debug['header'] == true) {
                    dd($headers_all);
                }
                $options = [
                    'headers' => $headers_all
                ];
                if (isset($param['body']) && !empty($param['body'])) {
                    $body = ['body' => \GuzzleHttp\json_encode($param['body'])];
                    $options = array_merge($options, $body);
                }
                if (isset($debug['param']) && !empty($debug['param']) && $debug['param'] == true) {
                    dd($options);
                }
                $response = $this->client->request($method, $url, $options);
                if (isset($debug['response']) && !empty($debug['response']) && $debug['response'] == true) {
                    dd($response);
                }
                $results = json_decode($response->getBody());
                if (isset($debug['result']) && !empty($debug['result']) && $debug['result'] == true) {
                    dd($results);
                }
            } catch (RequestException $e) {
                dd($e->getMessage());
                if ($e->getResponse() != null && $e->getResponse()->getStatusCode() == 401) {
                    // refresh token
                    $param_request_new_token = [
                        'auth' => false,
                        'uri' => config('app.url') . '/api/v1/auth/refresh_token',
                        'body' => [
                            'refresh_token' => MyHelper::getCookie(['name' => '_token_refresh'])
                        ],
                        'method' => 'POST'
                    ];
                    $refresh = $this->__init_request_api($request, $param_request_new_token, ['param' => false]);
                    if ($refresh->data && $refresh->is_ok == true) {
                        if (MyHelper::getCookie(['name' => '_token_user'])) {
                            unset($_COOKIE['_token_user']);
                            MyHelper::setCookie(['name' => '_token_user', 'value' => '']);
                        }
                        $headers = [
                            'ip' => MyHelper::getIp(),
                            'Content-Type' => 'application/json',
                            'browser' => MyHelper::getBrowser()['userAgent'],
                            'Access-Control-Allow-Origin' => '*',
                            'Access-Control-Allow-Methods' => $method
                        ];
                        $header_auth = array();
                        if (isset($param['auth']) && $param['auth'] == true) {
                            $header_auth = array('token' => $this->__init_token($request));
                        }
                        $headers_1 = array_merge($headers, $header_auth);
                        $header_cust = array();
                        if (isset($param['header']) && !empty($param['header'])) {
                            $header_cust = $param['header'];
                        }
                        $headers_all = array_merge($headers_1, $header_cust);
                        $options = [
                            'setEncodingType' => false,
                            'verify' => false,
                            'headers' => $headers_all
                        ];
                        if (isset($param['body']) && !empty($param['body'])) {
                            $body = ['body' => \GuzzleHttp\json_encode($param['body'])];
                            $options = array_merge($options, $body);
                        }
                        MyHelper::setCookie(['name' => '_token_user', 'value' => $refresh->data->token]);
                        $param_re_init_request = [
                            'auth' => false,
                            'uri' => $url,
                            'header' => [
                                'token' => $refresh->data->token
                            ],
                            'body' => $param['body'],
                            'method' => $method
                        ];
                        $results = $this->__init_request_api($request, $param_re_init_request);
                    }
                }
                $results['data'] = [];
                $results['status']['code'] = $e->getResponse()->getStatusCode();
                $results['status']['message_server'] = $e->getResponse()->getReasonPhrase();
                $results['status']['message_client'] = $e->getResponse()->getReasonPhrase();
                $results = json_decode(json_encode($results, JSON_HEX_QUOT | JSON_HEX_TAG));
            }
            return $results;
        }
    }

    function __init_upload_file($request, $params = array(), $debug = array()) {
        $client = new Client();
        $url = $params['uri'];
        $results = [];
        try {
            $response = $client->request($params['method'], $url, [
                'headers' => [
                    'token' => $this->__init_token($request),
                    'website' => config('app.url'),
                    'website_key' => "KWI",
                    'ip' => MyHelper::getIp(),
                    'browser' => MyHelper::getBrowser()['userAgent'],
                ],
                'multipart' => [
                    [
                        // 'headers' => [
                        //     'Content-Type' => 'multipart/form-data'
                        // ],
                        'name' => 'file',
                        'filename' => $request->file('file_name')->getClientOriginalName(),
                        'contents' => fopen($request->file('file_name')->getPathname(), 'r'),
                    ],
                    [
                        'name' => 'type',
                        'contents' => 'pushnotif'
                    ]
                ]
            ]);
            $results['data'] = json_decode($response->getBody());
            $results['status']['code'] = $response->getStatusCode();
            $results['status']['message_server'] = $response->getReasonPhrase();
            $results['status']['message_client'] = $response->getReasonPhrase();
            $results = json_decode(json_encode($results, JSON_HEX_QUOT | JSON_HEX_TAG));
        } catch (RequestException $e) {
            if ($e->getResponse() == null) {
                $results = array(
                    'status' => 502,
                    'message' => 'Connection to Api is shutdown, please reconnect server connection'
                );
                return json_decode(json_encode($results, JSON_HEX_QUOT | JSON_HEX_TAG));
            }
            if ($e->getResponse()->getStatusCode() == 401) {
                // refresh token
                $param_request_new_token = [
                    'auth' => true,
                    'uri' => config('app.base_api_auth') . '/refresh_token',
                    'body' => [
                        'refresh_token' => $request->cookie('r_token_user')
                    ],
                    'method' => 'POST'
                ];
                $refresh = $this->__init_request_api($request, $param_request_new_token);
                if ($refresh->data && $refresh->data->is_ok == true) {
                    if ($request->cookie('_token_user')) {
                        unset($_COOKIE['_token_user']);
                        $request->cookie('_token_user', '');
                    }
                    setcookie('_token_user', $refresh->data->data->token, null, '/');
                    $param_re_init_request = [
                        'auth' => false,
                        'uri' => $url,
                        'header' => [
                            'token' => $refresh->data->data->token
                        ],
                        'body' => $param['body'],
                        'method' => $method
                    ];
                    $results = $this->__init_request_api($request, $param_re_init_request);
                }
            }
            $results['data'] = [];
            $results['status']['code'] = $e->getResponse()->getStatusCode();
            $results['status']['message_server'] = json_decode($e->getResponse()->getBody());
            $results['status']['message_client'] = json_decode($e->getResponse()->getBody());
            $results = json_decode(json_encode($results, JSON_HEX_QUOT | JSON_HEX_TAG));
        }
        return $results;
    }

    public function __init_curl_api($request, $param) {
        $uuid = $request->session()->get('_uuid');
        $curl = curl_init();
        $key = '';
        if ($param['auth'] && $param['auth'] == true) {
            $key = $this->__init_token($request);
        }
        try {
            curl_setopt_array($curl, array(
                CURLOPT_URL => $param['uri'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => isset($param['method']) ? $param['method'] : 'GET',
                CURLOPT_POSTFIELDS => isset($param['data']) ? $param['data'] : "",
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: " . $key,
                    "Cookie: PHPSESSID=" . $uuid
                ),
            ));
            $response = curl_exec($curl);
            if ($response === false) {
                throw new \Exception(curl_error($curl), curl_errno($curl));
            }
            curl_close($curl);
            return $response;
        } catch (Exception $e) {
            trigger_error(sprintf('Curl failed with error #%d: %s', $e->getCode(), $e->getMessage()), E_USER_ERROR);
        }
    }

}
