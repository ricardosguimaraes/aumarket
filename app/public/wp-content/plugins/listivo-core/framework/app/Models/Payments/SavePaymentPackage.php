<?php

namespace Tangibledesign\Framework\Models\Payments;

interface SavePaymentPackage
{
    /**
     * @param array $data
     */
    public function setData(array $data): void;

    /**
     * @return void
     */
    public function setDefaultData(): void;

    /**
     * @return string
     */
    public function getType(): string;

}