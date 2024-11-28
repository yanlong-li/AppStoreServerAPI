<?php

namespace yanlongli\AppStoreServerApi\response;
/**
 * @property SendAttemptItem[]             sendAttempts 首次发送结果 <br/>
 *  <p> SUCCESS
 *  App Store 服务器在向您的服务器发送通知时收到成功响应。
 * TIMED_OUT
 * App Store 服务器未从您的服务器获得响应，因此超时。检查您的服务器是否未按顺序处理邮件。
 * SSL_ISSUE
 * App Store 服务器无法建立 TLS 会话或验证您的证书。检查您的服务器是否具有有效的证书并支持传输层安全性 （TLS） 协议版本 1.2 或更高版本。
 * CIRCULAR_REDIRECT
 * App Store 服务器检测到持续重定向。检查服务器的重定向是否为循环重定向循环。
 * NO_RESPONSE
 * App Store 服务器未从您的服务器收到有效的 HTTP 响应。
 * SOCKET_ISSUE
 * 网络错误导致通知尝试失败。
 * UNSUPPORTED_CHARSET
 * App Store 服务器不支持提供的字符集。
 * INVALID_RESPONSE
 * App Store 服务器从您的服务器收到无效响应。
 * PREMATURE_CLOSE
 * 在发送过程中，App Store 服务器与服务器的连接已关闭。
 * OTHER
 * 发生另一个错误，阻止服务器接收通知。 </p>
 * @property JWSNotificationResponseBodyV2 signedPayload
 */
#[\AllowDynamicProperties]
class NotificationHistoryResponseItem
{
    public function __construct($signedPayload, $sendAttempts)
    {
        $this->signedPayload = new JWSNotificationResponseBodyV2($signedPayload);

        foreach ($sendAttempts as $sendAttempt) {
            $this->sendAttempts[] = new SendAttemptItem($sendAttempt['attemptDate'], $sendAttempt['sendAttemptResult']);
        }
    }
}
