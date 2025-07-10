<div class="tdf-app">
    <?php
    /* @var User $user */

    use Tangibledesign\Framework\Models\User\User;

    if (tdf_settings()->isUserEmailConfirmationEnabled()) {
        tdf_load_view('user/partials/confirmed', compact('user'));
    }

    tdf_load_view('user/partials/details', compact('user'));

    tdf_load_view('user/partials/social_profiles', compact('user'));

    ?>
</div>
