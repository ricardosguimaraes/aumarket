<?php


namespace Tangibledesign\Framework\Providers;


use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\ContactForm;
use Tangibledesign\Framework\Queries\QueryContactForms;
use WPCF7_ContactForm;

/**
 * Class ContactFormServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class ContactFormServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['query_contact_forms'] = $this->container->factory(static function () {
            return new QueryContactForms();
        });

        $this->container['contact_forms'] = static function ($c) {
            /** @var QueryContactForms $queryContactForms */
            $queryContactForms = $c['query_contact_forms'];

            return $queryContactForms->get();
        };

        $this->container['contact_form_list'] = static function () {
            $list = [];

            foreach (tdf_app('contact_forms') as $contactForm) {
                /* @var ContactForm $contactForm */
                $list[$contactForm->getId()] = $contactForm->getName();
            }

            return $list;
        };
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/api/contactForms', static function () {
            $forms = [];

            foreach (tdf_contact_forms() as $contactForm) {
                $forms[] = [
                    'id' => $contactForm->getId(),
                    'name' => $contactForm->getName(),
                ];
            }

            if (isset($_REQUEST['include'])) {
                $id = is_numeric($_REQUEST['include']) ? (int)$_REQUEST['include'] : (string)$_REQUEST['include'];

                $forms = array_filter($forms, static function ($option) use ($id) {
                    return $option['id'] === $id;
                });
            }

            echo json_encode($forms, JSON_THROW_ON_ERROR);
        });

        add_action('wpcf7_before_send_mail', [$this, 'sendMail']);
        add_filter('shortcode_atts_wpcf7', [$this, 'params'], 10, 3);
        add_filter('wpcf7_autop_or_not', '__return_false');
        add_filter('wpcf7_form_elements', static function ($content) {
            return preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i',
                '\2', $content);
        });
    }

    /**
     * @param  array  $out
     * @param  array  $pairs
     * @param  array  $atts
     *
     * @return array
     * @noinspection PhpUnusedParameterInspection
     * @noinspection PhpMissingParamTypeInspection
     */
    public function params($out, $pairs, $atts): array
    {
        $attr = tdf_prefix().'-user-id';

        if (isset($atts[$attr])) {
            $out[$attr] = $atts[$attr];
        }

        return $out;
    }

    /**
     * @param  WPCF7_ContactForm  $contactForm
     */
    public function sendMail(WPCF7_ContactForm $contactForm): void
    {
        $key = tdf_prefix().'-user-id';
        if (!isset($_POST[$key])) {
            return;
        }

        $userId = (int)$_POST[$key];
        $user = tdf_user_factory()->create($userId);

        if (!$user) {
            return;
        }

        $properties = $contactForm->get_properties();
        $properties['mail']['recipient'] = $user->getMail();

        $contactForm->set_properties($properties);
    }

}