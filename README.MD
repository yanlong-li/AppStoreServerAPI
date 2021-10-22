App Store Server API
===
> Manage your customers’ App Store transactions from your server.



Overview The App Store Server API is a REST API that you call from your server to request and provide information about
your customers' in-app purchases. The App Store signs the transaction and subscription renewal information that this API
returns using the [JSON Web Signature](https://datatracker.ietf.org/doc/html/rfc7515) (JWS) specification.

App Store Server API is independent of the app’s installation status on the customer’s devices. The App Store server
returns information based on the customer’s in-app purchase history regardless of whether the customer installed,
removed, or reinstalled the app on their devices.

To request transaction and subscription status information with this API, provide any original transaction identifier
that belongs to the customer. The transaction history API responds with a complete list of transactions, 20 at a time,
starting with the oldest first. The subscription status API returns the status for all of the customer’s subscriptions,
organized by their subscription group identifier.

Use
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
