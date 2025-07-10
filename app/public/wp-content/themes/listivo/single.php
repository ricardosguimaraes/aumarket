<?php

if (post_password_required()) {
    echo get_the_password_form();
    return;
}

listivo_load_template('templates/blog/single');