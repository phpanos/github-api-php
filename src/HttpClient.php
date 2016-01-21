<?php
namespace Phpanos\Github;

class HttpClient implements \Phpanos\Github\HttpClientInterface
{
    private $handle;

    private $headers = [
        'User-Agent: Github Leaderboard',
        'Accept: application/json'
    ];

    private $options = [];

    public function __construct()
    {
        // set the curl handler
        $this->handle = curl_init();
    }

    /**
     * Run a GET request
     * @param  [type] $url
     * @param  array  $options
     * @return [type]
     */
    public function get($url, array $options = [])
    {
        return $this->makeRequest($url, $options);
    }

    /**
     * Run a POST request
     * @param  [type] $url
     * @param  array  $options
     * @return [type]
     */
    public function post($url, array $options = [])
    {
        // set post options
        $this->options = [
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $this->buildOptions($options),
        ];

        return $this->makeRequest($url, 'post');
    }

    /**
     * Set headers
     * @param  array  $headers
     * @return [type]
     */
    public function headers(array $headers = [])
    {
        if (! empty($headers)) {
            foreach ($headers as $header) {
                $this->headers[] = $header;
            }
        }

        return $this->headers;
    }

    /**
     * Execute request
     * @param  String $url
     * @return [type]
     */
    private function makeRequest($url, $type = '')
    {
        // set required options
        $this->options = $this->options + [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_RETURNTRANSFER => true,
        ];

        // save required options
        $this->curlOptArray($this->options);

        return $this->sendRequest();
    }

    /**
     * Convert array options to query string
     * @param  array  $options
     * @return String
     */
    private function buildOptions(array $options = [])
    {
        if (empty($options)) {
            return false;
        }

        return http_build_query($options);
    }

    /**
     * Execute the request
     * @return [type]
     */
    private function sendRequest()
    {
        $output = curl_exec($this->handle);

        curl_reset($this->handle);

        // clear options
        $this->options = [];

        return $output;
    }

    /**
     * Set curlOpt option and values
     * @param  Const $option
     * @param  Mixed $value
     * @return [type]
     */
    private function curlOpt($option, $value)
    {
        return curl_setopt($this->handle, $option, $value);
    }

    /**
     * Save curl options as array
     * @param  array  $options
     * @return [type]
     */
    private function curlOptArray(array $options = [])
    {
        return curl_setopt_array($this->handle, $options);
    }
}
