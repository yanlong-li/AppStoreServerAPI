<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string           appAppleId         The unique identifier of an app in the App Store.
 * @property string           bundleId           The bundle identifier of an app.
 * @property string           environment        The server environment, either sandbox or production.
 * @property bool             hasMore            A Boolean value indicating whether the App Store has more transaction data.
 * @property string           revision           A token you use in a query to request the next set of transactions for the customer.
 * @property JWSTransaction[] signedTransactions JWSTransaction Transaction information, signed by the App Store, in JSON Web Signature format.
 */
class HistoryResponse
{

}
