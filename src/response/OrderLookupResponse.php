<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property int              status             The status that indicates whether the order ID is valid.
 * 0 The orderId that you provided in the request is invalid.
 * 1 The orderId is valid.
 * @property JWSTransaction[] signedTransactions An array of in-app purchase transactions that are part of order, signed by Apple, in JSON Web Signature format.
 */
class OrderLookupResponse
{

}
