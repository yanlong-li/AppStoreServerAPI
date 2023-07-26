<?php

namespace yanlongli\AppStoreServerApi\errors;

use GuzzleHttp\Exception\RequestException;

/**
 *
 */
class AppStoreServerError
{
    const LIST = [
        4040001 => AccountNotFoundAppStoreServerError::class,
        4040002 => AccountNotFoundRetryableAppStoreServerError::class,
        4040003 => AppNotFoundAppStoreServerError::class,
        4040004 => AppNotFoundRetryableAppStoreServerError::class,
        5000001 => GeneralInternalRetryableAppStoreServerError::class,
        4040006 => OriginalTransactionIdNotFoundRetryableAppStoreServerError::class,
        5000000 => GeneralInternalAppStoreServerError::class,
        4000000 => GeneralBadRequestAppStoreServerError::class,
        4000002 => InvalidAppIdentifierAppStoreServerError::class,
        4000027 => InvalidEmptyStorefrontCountryCodeListAppStoreServerError::class,
        4000009 => InvalidExtendByDaysAppStoreServerError::class,
        4000010 => InvalidExtendReasonCodeAppStoreServerError::class,
        4000008 => InvalidOriginalTransactionIdAppStoreServerError::class,
        4000011 => InvalidRequestIdentifierAppStoreServerError::class,
        4000005 => InvalidRequestRevisionAppStoreServerError::class,
        4000028 => InvalidStorefrontCountryCodeAppStoreServerError::class,
        4040005 => OriginalTransactionIdNotFoundAppStoreServerError::class,
        4030004 => SubscriptionExtensionIneligibleAppStoreServerError::class,
        4030005 => SubscriptionMaxExtensionAppStoreServerError::class,
        4000016 => InvalidEndDateAppStoreServerError::class,
        4000018 => InvalidNotificationTypeAppStoreServerError::class,
        4000014 => InvalidPaginationTokenAppStoreServerError::class,
        4000015 => InvalidStartDateAppStoreServerError::class,
        4000020 => InvalidTestNotificationTokenAppStoreServerError::class,
        4000025 => InvalidExcludeRevokedAppStoreServerError::class,
        4000026 => InvalidInAppOwnershipTypeAppStoreServerError::class,
        4000023 => InvalidProductIdAppStoreServerError::class,
        4000022 => InvalidProductTypeAppStoreServerError::class,
        4000021 => InvalidSortAppStoreServerError::class,
        4000024 => InvalidSubscriptionGroupIdentifierAppStoreServerError::class,
        4000019 => MultipleFiltersSuppliedAppStoreServerError::class,
        4000017 => PaginationTokenExpiredAppStoreServerError::class,
        4040007 => ServerNotificationURLNotFoundAppStoreServerError::class,
        4000013 => StartDateAfterEndDateAppStoreServerError::class,
        4000012 => StartDateTooFarInPastAppStoreServerError::class,
        4040008 => TestNotificationNotFoundAppStoreServerError::class,

    ];
    /** @var int */
    public $errorCode;
    /** @var string */
    public $errorMessage;
    /**
     * @var array{
     *      errorCode: int,
     *      errorMessage: string,
     * }
     */
    protected $contents;

    public function __construct($contents)
    {
        if (is_string($contents)) {
            $contents = json_decode($contents, true);
        }
        $this->contents     = $contents;
        $this->errorCode    = $this->contents['errorCode'];
        $this->errorMessage = $this->contents['errorMessage'];
    }

    public static function fromException(RequestException $exception)
    {


        $contents = $exception->getResponse()->getBody()->getContents();

        if (in_array($exception->getCode(), [401, 403])) {
            return new self([
                'errorCode'    => $exception->getCode(),
                'errorMessage' => $contents,
            ]);
        }

        $contents = json_decode($contents, true);

        if (isset(self::LIST[$contents['errorCode']])) {
            $class = self::LIST[$contents['errorCode']];
            return new $class($contents);
        }
        return new self($contents);
    }

    /**
     * @return array
     */
    public function getContents(): array
    {
        return $this->contents;
    }
}