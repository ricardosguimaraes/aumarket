<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Helpers\HasUser;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\AlignmentClassControl;

/**
 * Class UserProfileButtonWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class UserProfileButtonWidget extends BaseModelSingleWidget
{
    use HasUser;
    use AlignmentClassControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_profile_button';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('User Profile Button', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addButtonTextControl();

        $this->addAlignmentClassControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addButtonTextControl(): void
    {
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('view_profile'),
            ]
        );
    }

    /**
     * @return string
     */
    public function getButtonText(): string
    {
        $buttonText = (string)$this->get_settings_for_display('button_text');

        if (empty($buttonText)) {
            return tdf_string('view_profile');
        }

        return $buttonText;
    }

    /**
     * @return string
     */
    public function getButtonUrl(): string
    {
        $user = $this->getUser();

        if (!$user) {
            return '';
        }

        return $user->getUrl();
    }

}