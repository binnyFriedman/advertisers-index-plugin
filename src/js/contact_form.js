jQuery(document).ready(function($) {

    $('.wordpress-ajax-form').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);

        $.post($form.attr('action'), $form.serialize(), function(data) {
            alert('This is data returned from the server ' + data);
        }, 'json');
    });

});