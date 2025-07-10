<?php

namespace Tangibledesign\Framework\Models\Notification\Tasks;

class MailNotificationTask extends NotificationTask
{

    public function execute(): void
    {
        $this->setStatus(self::STATUS_IN_PROGRESS);

        $recipient = $this->getUserTo();
        if (!$recipient) {
            $this->setStatus(self::STATUS_WAITING);
            return;
        }

        $notification = $this->getNotification();
        if (!$notification) {
            $this->setStatus(self::STATUS_WAITING);
            return;
        }

        $success = $this->sendMail(
            $recipient->getMail(),
            $notification->parseTags($notification->getMailTitle(), $this),
            $notification->parseTags($notification->getMailText(), $this)
        );

        if ($success) {
            $this->setStatus(self::STATUS_COMPLETED);
        } else {
            $this->setUserTo(self::STATUS_WAITING);
        }
    }

    private function sendMail(string $mail, string $title, string $rawMessage): bool
    {
        ob_start();

        get_template_part('templates/mail/base', null, [
            'title' => $title,
            'message' => $rawMessage,
            'cta' => false,
        ]);

        return wp_mail($mail, $title, ob_get_clean(), [
            'Content-Type: text/html; charset=UTF-8'
        ]);
    }

}