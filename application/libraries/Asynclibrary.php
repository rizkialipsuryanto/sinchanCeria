<?php


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class Asynclibrary
{

    private $_client;
    private $_header;
    private $_config;
    private $_dataid = BASE_DATAID;
    private $_secretKey = BASE_SECRET;
    private $_url = BASE_URL_PRODUCTION;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->_client = new Client();
    }

    function do_in_background($url, $params)
    {
        $post_string = http_build_query($params);
        $parts = parse_url($url);
        $errno = 0;
        $errstr = "";

        //Use SSL & port 443 for secure servers
        //Use otherwise for localhost and non-secure servers
        //For secure server
        //$fp = fsockopen('ssl://' . $parts['host'], isset($parts['port']) ? $parts['port'] : 443, $errno, $errstr, 30);

        //For localhost and un-secure server
        $fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);
        if (!$fp) {
            echo "Something Went Wrong";
        }
        $out = "POST " . $parts['path'] . " HTTP/1.1\r\n";
        $out .= "Host: " . $parts['host'] . "\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "Content-Length: " . strlen($post_string) . "\r\n";
        $out .= "Connection: Close\r\n\r\n";
        if (isset($post_string)) $out .= $post_string;
        fwrite($fp, $out);
        fclose($fp);
    }

    public function _send($method, $path, $payload = null)
    {
        try {
            $config['base_uri'] = site_url('api'); //$this->_url;
            // $config['headers'] = $this->_header;
            // $config['verify'] = false;
            $config['timeout'] = 5;

            switch ($method) {
                case "GET":
                    break;
                case "POST":
                    $config['json'] = $payload;
                    break;
                case "DELETE":
                    break;
                case "PUT":
                    $config['json'] = $payload;
                    break;
                default:
            }

            $response = $this->_client->request($method, $path, $config);
            $result = json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $result["error"] = 1;
            $result["message"] = json_decode($response, true);
        } catch (GuzzleHttp\Exception\ServerException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $result["message"] = json_decode($responseBodyAsString, true);
            $result["error"] = 1;
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $result["message"] = json_decode($responseBodyAsString, true);
            $result["error"] = 1;
        } catch (GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $result["message"] = json_decode($responseBodyAsString, true);
            $result["error"] = 1;
        }

        return $result;
    }
}
