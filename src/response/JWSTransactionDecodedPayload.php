<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string appAccountToken             The UUID an app optionally generates to map a customer’s in-app purchase with its resulting App Store transaction.
 * @property string bundleId                    The bundle identifier of the app.
 * @property string currency                    The three-letter ISO 4217 currency code associated with the price parameter. This value is present only if price is present.
 * @property string environment                 The server environment, either sandbox or production.
 * @property string expiresDate                 The UNIX time, in milliseconds, the subscription expires or renews.
 * @property string inAppOwnershipType          A string that describes whether the transaction was purchased by the user, or is available to them through Family Sharing.
 * @property string isUpgraded                  The Boolean value that indicates whether the user upgraded to another subscription.
 * @property string offerDiscountType           The payment mode you configure for the subscription offer, such as Free Trial, Pay As You Go, or Pay Up Front.
 * @property string offerIdentifier             The identifier that contains the promo code or the promotional offer identifier.
 * @property string offerType                   A value that represents the promotional offer type.
 * @property string originalPurchaseDate        The UNIX time, in milliseconds, that represents the purchase date of the original transaction identifier.
 * @property string originalTransactionId       The transaction identifier of the original purchase.
 * @property string int       An integer value that represents the price multiplied by 1000 of the in-app purchase or subscription offer you configured in App Store Connect and that the system records at the time of the purchase. For more information, see price. The currency parameter indicates the currency of this price.
 * @property string productId                   The unique identifier of the product.
 * @property string purchaseDate                The UNIX time, in milliseconds, that the App Store charged the user’s account for a purchase, restored product, subscription, or subscription renewal after a lapse.
 * @property string quantity                    The number of consumable products the user purchased.
 * @property string revocationDate              The UNIX time, in milliseconds, that Apple Support refunded a transaction.
 * @property string revocationReason            The reason that the App Store refunded the transaction or revoked it from family sharing.
 * @property string signedDate                  The UNIX time, in milliseconds, that the App Store signed the JSON Web Signature (JWS) data.
 * @property string storefront                  The three-letter code that represents the country or region associated with the App Store storefront for the purchase.
 * @property string storefrontId                An Apple-defined value that uniquely identifies the App Store storefront associated with the purchase.
 * @property string subscriptionGroupIdentifier The identifier of the subscription group the subscription belongs to.
 * @property string transactionId               The unique identifier of the transaction.
 * @property string transactionReason           The reason for the purchase transaction, which indicates whether it’s a customer’s purchase or a renewal for an auto-renewable subscription that the system initates.
 * @property string type                        The type of the in-app purchase.
 * @property string webOrderLineItemId          A unique ID that identifies subscription purchase events across devices, including subscription renewals.
 */
#[\AllowDynamicProperties]
class JWSTransactionDecodedPayload
{

    const IN_APP_OWNERSHIP_TYPE_PURCHASED = 'PURCHASED';
    const IN_APP_OWNERSHIP_TYPE_FAMILY_SHARED = 'FAMILY_SHARED';

    const TYPE_AUTO_RENEWABLE_SUBSCRIPTION = 'Auto-Renewable Subscription';
    const TYPE_NON_CONSUMABLE = 'Non-Consumable';
    const TYPE_CONSUMABLE = 'Consumable';
    const TYPE_NON_RENEWING_SUBSCRIPTION = 'Non-Renewing Subscription';


    public function __get($name)
    {
        return null;
    }
}
