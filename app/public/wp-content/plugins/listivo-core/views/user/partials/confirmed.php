<?php

use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use Tangibledesign\Framework\Models\User\User;

/* @var User $user */
?>
<table class="form-table" role="presentation">
    <tr class="user-first-name-wrap">
        <th>
            <label for="<?php echo esc_attr(UserSettingKey::CONFIRMED); ?>">
                <?php esc_html_e('Confirmed', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(UserSettingKey::CONFIRMED); ?>"
                    name="<?php echo esc_attr(UserSettingKey::CONFIRMED); ?>"
                    type="checkbox"
                    value="1"
                <?php if ($user->isConfirmed()) : ?>
                    checked
                <?php endif; ?>
            >
        </td>
    </tr>
</table>