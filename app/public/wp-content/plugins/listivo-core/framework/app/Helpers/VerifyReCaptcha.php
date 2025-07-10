<?php


namespace Tangibledesign\Framework\Helpers;


use ReCaptcha\ReCaptcha;

/**
 * Trait VerifyReCaptcha
 * @package Tangibledesign\Framework\Helpers
 */
trait VerifyReCaptcha
{
    /**
     * @param string $action
     * @param string $token
     * @return bool
     */
    protected function verifyReCaptcha(string $action, string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        return (new ReCaptcha(tdf_settings()->getReCaptchaSecretKey()))
            ->setExpectedAction($action)
            ->setScoreThreshold(apply_filters(tdf_prefix() . '/reCaptcha/score', 0.5))
            ->verify($token)
            ->isSuccess();
    }

}