<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Framework\Models\Template\TemplateType\PostSingleTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\UserTemplateType;
use Tangibledesign\Framework\Models\User\User;
use WP_Post;

trait HasUser
{
    public function getUser(): ?User
    {
        if (is_singular(tdf_prefix() . '_template')) {
            return $this->getUserByTemplateType();
        }

        if (is_author()) {
            global ${tdf_short_prefix() . 'User'};
            return ${tdf_short_prefix() . 'User'};
        }

        if (is_singular()) {
            global $post;
            if (!$post instanceof WP_Post) {
                return null;
            }

            return tdf_user_factory()->create((int)$post->post_author);
        }

        return null;
    }

    private function getUserByTemplateType(): ?User
    {
        $templateType = tdf_template_type_factory()->getCurrent();

        if ($templateType instanceof PostSingleTemplateType) {
            global ${tdf_short_prefix() . 'BlogPost'};

            if (!${tdf_short_prefix() . 'BlogPost'} instanceof BlogPost) {
                return null;
            }

            return tdf_user_factory()->create(${tdf_short_prefix() . 'BlogPost'}->getUserId());
        }

        if ($templateType instanceof UserTemplateType) {
            global ${tdf_short_prefix() . 'User'};
            return ${tdf_short_prefix() . 'User'};
        }

        return apply_filters(tdf_prefix() . '/templateType/user', null, $templateType);
    }

    public function linkUser(): bool
    {
        if (is_author()) {
            return false;
        }

        if (!is_singular(tdf_prefix() . '_template')) {
            return true;
        }

        return !tdf_template_type_factory()->getCurrent() instanceof UserTemplateType;
    }
}