<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string autoRenewProductId     The identifier of the product that renews at the next billing period.
 * @property string autoRenewStatus        The renewal status of the auto-renewable subscription.
 * @property string currency               The currency code for the renewalPrice of the subscription.
 * @property string[] eligibleWinBackOfferIds  The list of win-back offer IDs that the customer is eligible for.
 * @property string environment            The server environment, either sandbox or production.
 * @property string expirationIntent       The reason the subscription expired.
 * @property string gracePeriodExpiresDate The time when the grace period for subscription renewals expires.
 * @property string isInBillingRetryPeriod The Boolean value that indicates whether the App Store is attempting to automatically renew an expired subscription.
 * @property string offerDiscountType The payment mode of the discount offer.
 * @property string offerIdentifier        The promo code or the promotional offer identifier.
 * @property string offerType              The type of the promotional offer.
 * @property string originalTransactionId  The transaction identifier of the original purchase associated with this transaction.
 * @property string priceIncreaseStatus    The status indicating whether a customer has approved a subscription price increase.
 * @property string productId              The unique identifier of the product.
 * @property string recentSubscriptionStartDate The earliest start date of an auto-renewable subscription in a series of subscription purchases that ignores all lapses of paid service that are 60 days or less.
 * @property string renewalDate The UNIX time, in milliseconds, that the most recent auto-renewable subscription purchase expires.
 * @property int renewalPrice The renewal price, in milliunits, of the auto-renewable subscription that renews at the next billing period.
 * @property string signedDate             The UNIX time, in milliseconds, that the App Store signed the JSON Web Signature data.
 */
#[\AllowDynamicProperties]
class JWSRenewalInfoDecodedPayload
{
    const OFFER_TYPE_INTRODUCTORY = 1;
    const OFFER_TYPE_PROMOTIONAL = 2;
    const OFFER_TYPE_SUBSCRIPTION_OFFER_CODE = 3;

    const PRICE_INCREASE_STATUS_HAS_NOT_RESPONDED = 0;
    const PRICE_INCREASE_STATUS_CONSENTED = 1;

    public function __get($name)
    {
        return null;
    }
}
