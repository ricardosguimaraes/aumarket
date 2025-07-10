<?php


namespace Tangibledesign\Framework\Widgets\General;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\AlignmentControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SocialShareControls;

/**
 * Class SocialShare
 * @package Tangibledesign\Framework\Widgets\General
 */
class SocialShareWidget extends BaseGeneralWidget
{
    use AlignmentControl;
    use SocialShareControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'social_share';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('social_share');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addShowFacebookControl();

        $this->addShowTwitterControl();

        $this->addShowWhatsAppControl();

        $this->addShowMessengerControl();

        $this->addAlignmentControl($this->getAlignmentSelector());

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    private function getAlignmentSelector(): string
    {
        return '.' . tdf_prefix() . '-social-share';
    }

}