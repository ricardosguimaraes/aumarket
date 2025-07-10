<?php

namespace Tangibledesign\Framework\Actions\Stripe;

use Stripe\Exception\ApiErrorException;
use Tangibledesign\Framework\Models\User\User;

class CreateCustomerAction
{

    public function execute(User $user): string
    {
        try {
            $stripeCustomer = tdf_stripe()->customers->create([
                'email' => $user->getMail(),
                'name' => $user->getDisplayName(),
            ]);
        } catch (ApiErrorException $e) {
            return '';
        }

        return $stripeCustomer->id;
    }

}