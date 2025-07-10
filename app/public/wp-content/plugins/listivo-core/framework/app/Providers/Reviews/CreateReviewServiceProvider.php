<?php

namespace Tangibledesign\Framework\Providers\Reviews;

use Tangibledesign\Framework\Actions\Reviews\CreateReviewAction;
use Tangibledesign\Framework\Core\ServiceProvider;

class CreateReviewServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/reviews/create', [$this, 'create']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/reviews/create', [$this, 'create']);
    }

    public function create(): void
    {
        if (!$this->validateNonce()) {
            return;
        }

        if (!$this->validateRequest()) {
            return;
        }

        $this->createReview();

        if (tdf_settings()->isReviewsModerationEnabled()) {
            $this->successJsonResponse([
                'title' => tdf_string('review_awaiting_moderation_title'),
                'message' => tdf_string('review_awaiting_moderation_text'),
            ]);
            return;
        }

        $this->successJsonResponse([
            'title' => tdf_string('review_submission_success_title'),
            'message' => tdf_string('review_submission_success_text'),
        ]);
    }

    private function validateNonce(): bool
    {
        if (wp_verify_nonce($_POST['nonce'], tdf_prefix() . '/reviews/create')) {
            return true;
        }

        $this->errorJsonResponse([
            'title' => tdf_string('nonce_verification_failed_title'),
            'message' => tdf_string('nonce_verification_failed_text'),
        ]);

        return false;
    }

    private function validateRequest(): bool
    {
        if (!is_user_logged_in() && !tdf_settings()->reviewsAllowGuests()) {
            $this->errorJsonResponse([
                'title' => tdf_string('review_submission_require_login_title'),
                'message' => tdf_string('review_submission_require_login_text'),
            ]);

            return false;
        }

        if (!empty(tdf_settings()->getReviewMinLength()) && mb_strlen($_POST['review'], 'UTF-8') < tdf_settings()->getReviewMinLength()) {
            $this->errorJsonResponse([
                'title' => tdf_string('review_min_length_title'),
                'message' => str_replace('%d', tdf_settings()->getReviewMinLength(), tdf_string('review_min_length_text')),
            ]);

            return false;
        }

        if (!empty(tdf_settings()->getReviewMaxLength()) && mb_strlen($_POST['review'], 'UTF-8') > tdf_settings()->getReviewMaxLength()) {
            $this->errorJsonResponse([
                'title' => tdf_string('review_max_length_title'),
                'message' => str_replace('%d', tdf_settings()->getReviewMaxLength(), tdf_string('review_max_length_text')),
            ]);

            return false;
        }

        if (empty($_POST['rating']) || empty($_POST['modelId']) || empty($_POST['reviewType'])) {
            $this->errorJsonResponse([
                'title' => tdf_string('review_submission_invalid_request_title'),
                'message' => tdf_string('review_submission_invalid_request_text'),
            ]);

            return false;
        }

        return true;
    }

    private function createReview(): void
    {
        (new CreateReviewAction())->execute($_POST);
    }
}