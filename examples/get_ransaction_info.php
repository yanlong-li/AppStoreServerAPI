<?php

use yanlongli\AppStoreServerApi\errors\AppStoreServerError;

require_once __DIR__ . '/../vendor/autoload.php';

$assa = require_once 'client.php';


try {
    $res = $assa->getTransactionInfo('100000000000000');
    var_dump($res);
} catch (\GuzzleHttp\Exception\ClientException $exception) {
    $err = AppStoreServerError::fromException($exception);
    var_dump($err);
} catch (Exception $exception) {
    var_dump($exception->getMessage());
}
