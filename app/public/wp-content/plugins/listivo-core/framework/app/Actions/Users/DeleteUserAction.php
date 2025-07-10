<?php

namespace Tangibledesign\Framework\Actions\Users;

use Tangibledesign\Framework\Models\User\User;

class DeleteUserAction
{

    public function execute(int $userId): void
    {
        $this->deleteUser($userId);

        $this->deleteUserContent($userId);

        $this->deleteSubscription($userId);
    }

    private function deleteSubscription(int $userId): void
    {
        $user = tdf_user_factory()->create($userId);
        if (!$user instanceof User || !$user->getUserSubscription()) {
            return;
        }

        do_action('tdf/userSubscription/cancel', $user->getUserSubscription());
    }

    private function deleteUser(int $userId): void
    {
        wp_delete_user($userId);
    }

    private function deleteUserContent(int $userId): void
    {
        $posts = get_posts([
            'posts_per_page' => -1,
            'post_type' => 'any',
            'author' => $userId
        ]);

        if (empty($posts)) {
            return;
        }

        foreach ($posts as $post) {
            wp_delete_post($post->ID, true);
        }
    }

}