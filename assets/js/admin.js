(function ($) {
  $("table.wp-list-table.contacts").on("click", "a.submitdelete", function (e) {
    e.preventDefault();

    if (!confirm(wedevsAcademy.confirm)) {
      return;
    }

    var self = $(this),
      id = self.data("id");

    wp.ajax.send("wd-academy-delete-contact", {
      data: {
        id: id,
        _wpnonce: wedevsAcademy.nonce,
      }        
    }).done(function (response) {
        self.closest('tr').css({
            backgroundColor: 'red'
        }).hide(400, function() {
            $(this).remove();
        })
    })
    .fail(function (error) {alert(wedevsAcademy.error)});
  });
})(jQuery);
