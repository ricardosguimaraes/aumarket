<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use Tangibledesign\Framework\Models\User\User;

class QueryUsers extends Query
{
    protected array $roleNotIn = [];

    protected string $username = '';

    protected string $email = '';

    protected string $keyword = '';

    protected string $phone = '';

    protected array $meta = [];

    protected string $search = '';

    protected function parseArgs(): array
    {
        return [
            'number' => $this->limit,
            'offset' => $this->offset,
            'include' => $this->in,
            'role__not_in' => $this->roleNotIn,
            'user_email' => $this->email,
            'search' => '*' . esc_attr($this->keyword) . '*',
            'meta_query' => $this->meta,
        ];
    }

    /**
     * @param array|string $roles
     * @return $this
     */
    public function roleNotIn($roles): self
    {
        $this->roleNotIn = is_array($roles) ? $roles : [$roles];

        return $this;
    }

    public function email(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function keyword(string $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function get(): Collection
    {
        return tdf_collect(get_users($this->parseArgs()))
            ->map(function ($user) {
                return tdf_user_factory()->create($user);
            })
            ->filter(static function ($user) {
                return $user !== false;
            });
    }

    public function lastActive(int $minutes): self
    {
        $this->meta[] = [
            'key' => UserSettingKey::LAST_ACTIVITY,
            'compare' => '<=',
            'value' => date('Y-m-d H:i:s', strtotime('-' . $minutes . ' minutes'))
        ];

        return $this;
    }

    public function where(string $metaKey, string $metaValue): self
    {
        $this->meta[] = [
            'key' => $metaKey,
            'value' => $metaValue,
            'compare' => '=',
        ];

        return $this;
    }

    public function whereStripeCustomerId(string $stripeCustomerId): self
    {
        return $this->where(UserSettingKey::STRIPE_CUSTOMER_ID, $stripeCustomerId);
    }

    public function wherePhone(string $phone): self
    {
        return $this->where(UserSettingKey::PHONE, $phone);
    }
}