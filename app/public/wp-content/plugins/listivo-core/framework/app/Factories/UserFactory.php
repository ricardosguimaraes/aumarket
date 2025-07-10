<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Models\User\User;
use WP_User;
use WP_User_Query;

class UserFactory
{
    /**
     * @param  WP_User|int  $user
     * @return User|null
     */
    public function create($user): ?User
    {
        $object = $this->getObject($user);
        if (!$object) {
            return null;
        }

        return new User($object);
    }

    /**
     * @param $user
     * @return WP_User|false
     */
    private function getObject($user)
    {
        if (empty($user)) {
            return false;
        }

        if ($user instanceof WP_User) {
            return $user;
        }

        if (is_int($user)) {
            return get_user_by('ID', $user);
        }

        return false;
    }

    /**
     * @param  string  $email
     * @return User|null
     */
    public function createByEmail(string $email): ?User
    {
        $user = get_user_by('email', $email);
        if (!$user) {
            return null;
        }

        return $this->create($user);
    }

    /**
     * @param  string  $key
     * @param  string  $value
     * @return User|null
     */
    public function createByMeta(string $key, string $value): ?User
    {
        $query = new WP_User_Query([
            'meta_key' => $key,
            'meta_value' => $value
        ]);

        /** @noinspection LoopWhichDoesNotLoopInspection */
        foreach ($query->get_results() as $user) {
            return $this->create($user);
        }

        return null;
    }

}