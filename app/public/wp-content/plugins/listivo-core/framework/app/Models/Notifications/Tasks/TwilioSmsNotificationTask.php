<?php

namespace Tangibledesign\Framework\Models\Notification\Tasks;

use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioSmsNotificationTask extends NotificationTask
{

    public function execute(): void
    {
        $this->setStatus(self::STATUS_IN_PROGRESS);

        $recipient = $this->getUserTo();
        if (!$recipient) {
            $this->setStatus(self::STATUS_WAITING);
            return;
        }

        if (!$recipient->hasPhone()) {
            $this->setStatus(self::STATUS_WAITING);
            return;
        }

        $notification = $this->getNotification();
        if (!$notification) {
            $this->setStatus(self::STATUS_WAITING);
            return;
        }

        $text = $notification->getSmsText();

        $success = $this->sendSms(
            $recipient->getPhoneWithCountryCode(),
            $notification->parseTags($text, $this)
        );

        if ($success) {
            $this->setStatus(self::STATUS_COMPLETED);
        } else {
            $this->setStatus(self::STATUS_WAITING);
        }
    }

    private function sendSms(string $phone, string $text): bool
    {
        $client = tdf_app('twilio_client');
        if (!$client instanceof Client) {
            return false;
        }

        try {
            $client->messages
                ->create($phone, [
                    'body' => $text,
                    'from' => tdf_settings()->getTwilioPhoneNumber(),
                ]);
        } catch (TwilioException $e) {
            $this->setStatus(self::STATUS_WAITING);

            return false;
        }

        return true;
    }

}