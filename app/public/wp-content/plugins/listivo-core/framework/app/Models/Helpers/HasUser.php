<?php

namespace Tangibledesign\Framework\Models\Helpers;

use Tangibledesign\Framework\Models\User\User;

trait HasUser
{
    abstract public function getUserId(): int;

    public function getUser(): ?User
    {
        return tdf_user_factory()->create($this->getUserId());
    }
}