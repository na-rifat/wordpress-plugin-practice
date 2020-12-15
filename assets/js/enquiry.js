;(function($){
    $('#wedevs-enquiry-form form').on('submit', function(e){
        e.preventDefault();

        var data = $(this).serialize();

        $.post(wedevsAcademy.ajaxurl, data,
            function (data) {
                
            }
        ).fail(function(error){
            alert(wedevsAcademy.error);
        });
    });
})(jQuery);