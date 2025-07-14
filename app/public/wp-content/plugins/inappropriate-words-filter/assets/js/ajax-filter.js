jQuery(document).ready(function($) {
    $('input[type="text"], textarea').on('blur', function() {
        let field = $(this);
        let text = field.val();

        $.post(WordFilterAjax.ajax_url, {
            action: 'check_inappropriate_words',
            text: text
        }, function(response) {
            let res = JSON.parse(response);
            if (res.result !== text) {
                field.val(res.result);
                field.css('border', '2px solid red');
            } else {
                field.css('border', '2px solid green');
            }
        });
    });
});
