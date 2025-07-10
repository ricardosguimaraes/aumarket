<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait HasContactForm
{
    use Control;

    protected function addContactFormControl(): void
    {
        $this->add_control(
            'contact_form',
            [
                'label' => tdf_admin_string('contact_form'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/api/contactForms'),
            ]
        );
    }

    public function getContactFormId(): int
    {
        return (int)$this->get_settings_for_display('contact_form');
    }

    public function hasContactForm(): bool
    {
        return !empty($this->getContactFormId());
    }

    public function displayContactForm(?int $userId = null): void
    {
        echo do_shortcode('[contact-form-7
        ' . ($userId ? tdf_prefix() . '-user-id="' . $userId . '"' : '') . ' 
        id="' . $this->getContactFormId() . '"][/contact-form-7]');
    }
}