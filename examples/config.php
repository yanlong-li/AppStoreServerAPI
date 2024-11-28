<?php

use yanlongli\AppStoreServerApi\Config;
use yanlongli\AppStoreServerApi\Environment;

return new Config(Environment::ENDPOINT_PRODUCTION,
    'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX',
    '-----BEGIN PRIVATE KEY-----
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
-----END PRIVATE KEY-----',
    'XXXXXXXXXX',
    "com.bundle.id");
