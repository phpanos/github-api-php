<?php
namespace Phpanos\Github;

interface HttpClientInterface
{
    public function get($url, array $options = []);

    public function post($url, array $options = []);

    public function put($url, array $options = []);

    public function delete($url, array $options = []);
}
