// link to top page
$(document).ready(function() {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('#back-to-top').tooltip('show');

});
// jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });

// ajax submitter start
    var form = $('#contactForm');
    $(form).submit(function(e) {
        e.preventDefault();
        var formData = $(form).serialize();
        $.ajax({
            url: '/bin/notifier.php',
            method: 'POST',
            cache: false,
            data: formData,

            beforeSend: function () {
                $(form).fadeOut(); $('#loader').show().fadeIn();
            },
            success: function(msg) {
                $('#form-div').html(msg).show('slow');
                setTimeout( function() {
                        window.location.href = "/";
                    }, 5000);

            },
             error: function() {
                window.location.href = "/#contact";
            }
        });

        return false;
    });
// ajax submitter stop
});

