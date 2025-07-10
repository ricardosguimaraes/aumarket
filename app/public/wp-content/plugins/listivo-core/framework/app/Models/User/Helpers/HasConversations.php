<?php

namespace Tangibledesign\Framework\Models\User\Helpers;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\DirectMessage\Conversation;

trait HasConversations
{
    /**
     * @return int
     */
    abstract public function getId(): int;

    /**
     * @return Collection|Conversation[]
     */
    public function getConversations(): Collection
    {
        return Conversation::getUserIds($this->getId())->map(static function ($userId) {
            return Conversation::make($userId);
        })->toValues();
    }

    /**
     * @return int
     */
    public function getNotSeenConversationNumber(): int
    {
        return $this->getConversations()->filter(static function ($conversation) {
            /* @var Conversation $conversation */
            return !$conversation->seen();
        })->count();
    }

}