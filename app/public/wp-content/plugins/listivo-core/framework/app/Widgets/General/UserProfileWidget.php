<?php


namespace Tangibledesign\Framework\Widgets\General;


use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\UserControl;

/**
 * Class UserWidget
 * @package Tangibledesign\Framework\Widgets\General
 */
class UserProfileWidget extends BaseGeneralWidget
{
    use UserControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_profile';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('user_profile');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addUserControl();

        $this->endControlsSection();
    }

}