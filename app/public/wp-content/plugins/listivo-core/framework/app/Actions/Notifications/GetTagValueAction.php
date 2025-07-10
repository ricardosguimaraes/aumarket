<?php

namespace Tangibledesign\Framework\Actions\Notifications;

use Tangibledesign\Framework\Models\DirectMessage\DirectMessage;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Review;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

class GetTagValueAction
{

    public function execute(
        string         $tag,
        array          $additional,
        ?Model         $model,
        ?User          $user,
        ?DirectMessage $directMessage,
        ?Review        $review
    ): string
    {
        if ($user && strpos($tag, 'user') !== false) {
            return $this->getUserTagValue($tag, $user);
        }

        if ($model && strpos($tag, 'ad') !== false) {
            return $this->getModelTagValue($tag, $model);
        }

        if ($directMessage && strpos($tag, 'message') !== false) {
            return $this->getMessageTagValue($tag, $directMessage);
        }

        if ($directMessage && strpos($tag, 'review') !== false) {
            return $this->getReviewTagValue($tag, $review);
        }

        if ($tag === '{declineReason}') {
            return $this->getDeclineReasonTagValue($additional);
        }

        return '';
    }

    private function getReviewTagValue(string $tag, Review $review): string
    {
        if ($tag === '{reviewText}') {
            return $review->getContent();
        }

        return '';
    }

    private function getUserTagValue(string $tag, User $user): string
    {
        if ($tag === '{userDisplayName}') {
            return $user->getDisplayName();
        }

        if ($tag === '{userDisplayNameWithLink}') {
            return '<a href="' . $user->getUrl() . '">' . $user->getDisplayName() . '</a>';
        }

        if ($tag === '{userAccountType}') {
            return $user->getDisplayAccountType();
        }

        if ($tag === '{userFirstName}') {
            return $user->getFirstName();
        }

        if ($tag === '{userLastName}') {
            return $user->getLastName();
        }

        if ($tag === '{userMail}') {
            return $user->getMail();
        }

        if ($tag === '{userUrl}') {
            return $user->getUrl();
        }

        if ($tag === '{userPhone}') {
            return $user->getPhone();
        }

        if ($tag === '{userCompanyInformation}') {
            return $user->getCompanyInformation();
        }

        return '';
    }

    private function getModelTagValue(string $tag, Model $model): string
    {
        if ($tag === '{adName}') {
            return $model->getName();
        }

        if ($tag === '{adUrl}') {
            return $model->getUrl();
        }

        return '';
    }

    private function getMessageTagValue(string $tag, DirectMessage $directMessage): string
    {
        if ($tag === '{messageSenderDisplayName}') {
            return $this->getMessageSenderDisplayNameTagValue($directMessage);
        }

        if ($tag === '{messageSenderDisplayNameWithUrl}') {
            return $this->getMessageSenderDisplayNameWithUrlTagValue($directMessage);
        }

        if ($tag === '{messageSenderUrl}') {
            return $this->getMessageSenderUrl($directMessage);
        }

        if ($tag === '{messageText}') {
            return $directMessage->getMessage();
        }

        if ($tag === '{messageReplyUrl}') {
            return $this->getMessageReplyUrlTagValue($directMessage);
        }

        return '';
    }

    private function getMessageReplyUrlTagValue(DirectMessage $directMessage): string
    {
        $userFrom = $directMessage->getUserFrom();
        if (!$userFrom) {
            return '';
        }

        return PanelWidget::getUrl(PanelWidget::ACTION_MESSAGES) . '?' . tdf_slug('user') . '=' . $userFrom->getId();
    }

    private function getMessageSenderDisplayNameTagValue(DirectMessage $directMessage): string
    {
        $user = $directMessage->getUserFrom();
        if (!$user) {
            return '';
        }

        return $user->getDisplayName();
    }

    private function getMessageSenderDisplayNameWithUrlTagValue(DirectMessage $directMessage): string
    {
        $user = $directMessage->getUserFrom();
        if (!$user) {
            return '';
        }

        return '<a href="' . $user->getUrl() . '">' . $user->getDisplayName() . '</a>';
    }

    private function getMessageSenderUrl(DirectMessage $directMessage): string
    {
        $user = $directMessage->getUserFrom();
        if (!$user) {
            return '';
        }

        return $user->getUrl();
    }

    private function getDeclineReasonTagValue(array $additional): string
    {
        return $additional['message'] ?? '';
    }

}