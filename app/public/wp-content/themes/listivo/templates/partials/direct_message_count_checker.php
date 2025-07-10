<div class="listivo-app">
    <lst-direct-message-count-checker
            request-url="<?php echo esc_url(tdf_action_url('listivo/directMessages/checkCount')); ?>"
    >
        <div slot-scope="checker"></div>
    </lst-direct-message-count-checker>
</div>