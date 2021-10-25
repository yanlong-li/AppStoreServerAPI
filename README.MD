App Store Server API / 苹果应用商店服务端 API
===
> Manage your customers’ App Store transactions from your server.
> 从服务器管理客户的应用商店事务。

## Overview

The App Store Server API is a REST API that you call from your server to request and provide information about your
customers' in-app purchases. The App Store signs the transaction and subscription renewal information that this API
returns using the [JSON Web Signature](https://datatracker.ietf.org/doc/html/rfc7515) (JWS) specification.

App Store Server API is independent of the app’s installation status on the customer’s devices. The App Store server
returns information based on the customer’s in-app purchase history regardless of whether the customer installed,
removed, or reinstalled the app on their devices.

To request transaction and subscription status information with this API, provide any original transaction identifier
that belongs to the customer. The transaction history API responds with a complete list of transactions, 20 at a time,
starting with the oldest first. The subscription status API returns the status for all of the customer’s subscriptions,
organized by their subscription group identifier.

## 概述

App Store Server API是一个REST API，您可以从服务器调用它来请求并提供有关您客户的应用内购买的信息。
应用商店将签署此API提供的交易和订阅续订信息使用[JSON Web签名](https://datatracker.ietf.org/doc/html/rfc7515)（JWS）规范返回。
应用商店服务器API独立于客户设备上的应用安装状态。 应用商店服务器根据客户的应用程序内购买历史记录返回信息，无论客户是否已安装， 已在其设备上删除或重新安装应用程序。
要使用此API请求事务和订阅状态信息，请提供任何原始事务标识符那是属于顾客的。 事务历史API响应一个完整的事务列表，每次20个，先从最老的开始。 subscription status API返回客户所有订阅的状态，由其订阅组标识符组织。

## Use

the [Send Consumption Information](https://developer.apple.com/documentation/appstoreserverapi/send_consumption_information)
endpoint to send information to the App Store when customers request a refund for a consumable in-app purchase, after
you receive the App Store server notification. Your data helps inform refund decisions.CONSUMPTION_REQUEST

## Authorize Your API Calls

Calls to the API require JSON Web Tokens (JWT) for authorization; you obtain keys to create the tokens from your
organization’s App Store Connect account.
See [Creating API Keys to Use With the App Store Server API](https://developer.apple.com/documentation/appstoreserverapi/creating_api_keys_to_use_with_the_app_store_server_api)
to create your keys.
See [Generating Tokens for API Requests](https://developer.apple.com/documentation/appstoreserverapi/generating_tokens_for_api_requests)
to generate tokens using your keys, and send API requests. After you have a complete and signed token, provide the token
in the request’s authorization header as a bearer token.

## Use the Sandbox Environment for Testing

Most App Store Server APIs are available in the sandbox environment for testing. Access the sandbox environment by
sending requests to the endpoints using the following base URL:

    https://api.storekit-sandbox.itunes.apple.com/

For example, to
call [Get Transaction History](https://developer.apple.com/documentation/appstoreserverapi/get_transaction_history) in
the sandbox environment, send a request to:

    https://api.storekit-sandbox.itunes.apple.com/inApps/v1/history/{originalTransactionId}

Note that in the path is case-sensitive./inApps

The Look Up Order ID endpoint isn’t available in the sandbox environment.

## Params 参数

### IssuerID & private key id & private key 私钥获取方式

[Creating API Keys for App Store Connect API Documentation](https://developer.apple.com/documentation/appstoreconnectapi/creating_api_keys_for_app_store_connect_api)

[创建 API Keys 的文档](https://developer.apple.com/documentation/appstoreconnectapi/creating_api_keys_for_app_store_connect_api)

    https://appstoreconnect.apple.com/access/api
    or
    https://appstoreconnect.apple.com/access/api/subs

### app bundle id 应用 bundle id
If you only manage a single application, you can pass the default settings in the constructor.

如果你仅管理单个应用，可以在构造函数中传递默认设定。

```php
new \yanlongli\AppStoreServerApi\AppStoreServerApi(
    ...
    'bundleId',
);
```

If you want to manage multiple applications at the same time, you can pass bundleid in the specific interface to override the settings in the constructor.

如果你要同时管理多个应用，可以在具体的接口中传递 bundleId 以覆盖构造函数中的设定。

```php
$example->subscriptions(...,'bundleId');
```

## Example

### Subscription Status 订阅状态查询

> 这里的订单号是app上报的订单号，较长的数字订单号。

```php
<?php
require_once 'vendor/autoload.php';

$example = new \yanlongli\AppStoreServerApi\AppStoreServerApi(
    Environment::ENDPOINT_PRODUCTION,
    'private key id',
    'private key',
    'IssuerID',
    'app bundle id',// Optional,可选的，如果仅管理单个应用可以设定默认值。
);
$example->subscriptions('originalTransactionId','app bundle id'); // app bundle id 是可选的，这里将覆盖构造函数中的设定。
```

### Order ID Lookup 订单查询

> 这里的订单号指的是 客户通过邮件等方式收到的订单号，通常为 10个字符左右： AAA11A1AA1

```php
<?php
require_once 'vendor/autoload.php';

$example = new \yanlongli\AppStoreServerApi\AppStoreServerApi(
    Environment::ENDPOINT_PRODUCTION,
    'private key id',
    'private key',
    'IssuerID',
    "app bundle id"
);
$example->lookup('customers’ receipt order id'); // ABC123
```

## Topics

### Essentials

[Creating API Keys to Use With the App Store Server API](https://developer.apple.com/documentation/appstoreserverapi/creating_api_keys_to_use_with_the_app_store_server_api)
Create API keys you use to sign JSON Web Tokens and authorize API requests.
[Generating Tokens for API Requests](https://developer.apple.com/documentation/appstoreserverapi/generating_tokens_for_api_requests)
Create JSON Web Tokens signed with your private key to authorize App Store Server API requests.

### In-App Purchase History

[Get Transaction History](https://developer.apple.com/documentation/appstoreserverapi/get_transaction_history)
Get a customer’s in-app purchase transaction history for your app.
[object HistoryResponse](https://developer.apple.com/documentation/appstoreserverapi/historyresponse)
A response that contains the customer’s transaction history for an app.
### Subscription Status
[Get All Subscription Statuses](https://developer.apple.com/documentation/appstoreserverapi/get_all_subscription_statuses)
Get the statuses for all of a customer’s subscriptions in your app.
[object StatusResponse](https://developer.apple.com/documentation/appstoreserverapi/statusresponse)
A response that contains status information for all of a customer’s subscriptions in your app.
### Consumption Information
[Send Consumption Information](https://developer.apple.com/documentation/appstoreserverapi/send_consumption_information)
Send consumption information about a consumable in-app purchase to the App Store, after your server receives a consumption request notification.
[object ConsumptionRequest](https://developer.apple.com/documentation/appstoreserverapi/consumptionrequest)
The request body containing consumption information.
### Order ID Lookup
[Look Up Order ID](https://developer.apple.com/documentation/appstoreserverapi/look_up_order_id)
Get a customer’s in-app purchases from a receipt using the order ID.
[type orderId](https://developer.apple.com/documentation/appstoreserverapi/orderid)
The customer’s order ID from an App Store receipt for in-app purchases.
[object OrderLookupResponse](https://developer.apple.com/documentation/appstoreserverapi/orderlookupresponse)
A response that includes the order lookup status and an array of signed transactions for the in-app purchases in the order.
### Refund Lookup
[Get Refund History](https://developer.apple.com/documentation/appstoreserverapi/get_refund_history)
Get a list of all refunded in-app purchases in your app for a customer.
[object RefundLookupResponse](https://developer.apple.com/documentation/appstoreserverapi/refundlookupresponse)
A response that contains an array of signed JSON Web Signature (JWS) transactions.
### Subscription Renewal Date Extension
[Extend a Subscription Renewal Date](https://developer.apple.com/documentation/appstoreserverapi/extend_a_subscription_renewal_date)
Extend the renewal date of a customer’s active subscription using the original transaction identifier.
[object ExtendRenewalDateRequest](https://developer.apple.com/documentation/appstoreserverapi/extendrenewaldaterequest)
The request body containing subscription-renewal-extension data.
[object ExtendRenewalDateResponse](https://developer.apple.com/documentation/appstoreserverapi/extendrenewaldateresponse)
A response that indicates whether the renewal-date extension succeeded and related details.
### JWS Headers and Payloads
[object JWSDecodedHeader](https://developer.apple.com/documentation/appstoreserverapi/jwsdecodedheader)
A decoded JSON Web Signature header containing transaction or renewal information.
[type JWSTransaction](https://developer.apple.com/documentation/appstoreserverapi/jwstransaction)
Transaction information, signed by the App Store, in JSON Web Signature format.
[object JWSTransactionDecodedPayload](https://developer.apple.com/documentation/appstoreserverapi/jwstransactiondecodedpayload)
A decoded payload containing transaction information.
[Transaction Data Types](https://developer.apple.com/documentation/appstoreserverapi/transaction_data_types)
Data types used in decoded transaction payloads.
[type JWSRenewalInfo](https://developer.apple.com/documentation/appstoreserverapi/jwsrenewalinfo)
Subscription renewal information signed by the App Store, in JSON Web Signature format.
[object JWSRenewalInfoDecodedPayload](https://developer.apple.com/documentation/appstoreserverapi/jwsrenewalinfodecodedpayload)
A decoded payload containing subscription renewal information.
[Subscription Renewal Data Types](https://developer.apple.com/documentation/appstoreserverapi/subscription_renewal_data_types)
Data types used in decoded renewal info payloads.
### Error Information
[Error Codes](https://developer.apple.com/documentation/appstoreserverapi/error_codes)
Error codes returned by App Store Server API responses.
