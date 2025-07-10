<?php


namespace Tangibledesign\Framework\Helpers;


/**
 * Trait VerifyNonce
 * @package Tangibledesign\Framework\Helpers
 */
trait VerifyNonce
{
    /**
     * @param string $nonce
     * @param string $action
     * @return bool
     */
    public function verifyNonce(string $nonce, string $action): bool
    {
        return wp_verify_nonce($nonce, $action) !== false;
    }

}