<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use \Phpanos\Github\Github;
use \Phpanos\Github\HttpClient;

$github = new GitHub(new HttpClient);

if (! empty($_GET['code'])) {
    $github->requestAccessToken($config['client_id'], $config['client_secret'], $_GET['code']);
    $user = $github->get($github->apiBaseUrl().'user');
    var_dump($user);
}

?>
<a href="<?php echo $github->authorizeUrl($config['client_id'], 'user', $config['redirect_url']); ?>">Authorize App</a>