<?php


namespace Tangibledesign\Framework\Widgets\User;


use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;
use Tangibledesign\Framework\Widgets\Helpers\PostSingleWidget;

/**
 * Class UserAddressWidget
 * @package Tangibledesign\Framework\Widgets\User
 */
class UserAddressWidget extends BaseUserWidget implements PostSingleWidget
{
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_address';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('user_address');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextControls($this->getSelector());

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    protected function getSelector(): string
    {
        return '.' . tdf_prefix() . '-address';
    }

}