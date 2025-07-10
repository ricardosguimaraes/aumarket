<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetPolicyLabel
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetPolicyLabel
{
    use Setting;

    /**
     * @param $policyLabel
     */
    public function setPolicyLabel($policyLabel): void
    {
        $this->setSetting(SettingKey::POLICY_LABEL, $policyLabel);
    }

    /**
     * @return string
     */
    public function getPolicyLabel(): string
    {
        return (string)$this->getSetting(SettingKey::POLICY_LABEL);
    }

}