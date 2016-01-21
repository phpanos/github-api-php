<?php
namespace Phpanos\Github;

class GitHub
{
    private $httpClient;

    /**
     * Inject http client (cURL maybe?)
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function apiBaseUrl()
    {
        return 'https://api.github.com/';
    }

    /**
     * Get request wrapper from our http client
     * @param  [type] $url
     * @param  array  $data
     * @return [type]
     */
    public function get($url, array $data = [])
    {
        return json_decode($this->httpClient->get($url, $data));
    }

    /**
     * Post request wrapper from our http client
     * @param  [type] $url
     * @param  array  $data
     * @return [type]
     */
    public function post($url, array $data = [])
    {
        return json_decode($this->httpClient->post($url, $data));
    }

    /**
     * Create authorize url for github
     * @param  [type] $client_id
     * @param  string $scope
     * @return [type]
     */
    public function authorizeUrl($client_id, $scope = '', $redirectUrl = '')
    {
        return 'https://github.com/login/oauth/authorize?' . http_build_query([
            'client_id' => $client_id,
            'scope' =>  $scope,
            'redirect_url' => $redirectUrl,
        ]);
    }

    public function requestAccessToken($clientId, $clientSecret, $code)
    {
        $token = $this->post('https://github.com/login/oauth/access_token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code'  => $code
        ]);

        $this->setAuthToken($token);

        return $token;
    }

    private function setAuthToken($token)
    {
        $this->httpClient->headers(["Authorization: token {$token->access_token}"]);
    }
}
