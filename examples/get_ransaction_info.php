<?php

use yanlongli\AppStoreServerApi\AppStoreServerApi;
use yanlongli\AppStoreServerApi\Environment;
use yanlongli\AppStoreServerApi\errors\AppStoreServerError;

require_once __DIR__ . '/../vendor/autoload.php';


$restClient = new \yanlongli\AppStoreServerApi\RestClient(Environment::ENDPOINT_PRODUCTION,
    'XXXXXXXXXX',
    '-----BEGIN PRIVATE KEY-----
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
-----END PRIVATE KEY-----',
    'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX',
    "com.bundle.id");

$assa = new AppStoreServerApi($restClient);


try {
    $res = $assa->getTransactionInfo('100001408074716');
    var_dump($res);
} catch (\GuzzleHttp\Exception\ClientException $exception) {
    $err = AppStoreServerError::fromException($exception);
    var_dump($err);
} catch (Exception $exception) {
    var_dump($exception->getMessage());
}
