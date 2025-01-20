(function($) {
    "use strict"
    $('.datepicker-default').pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd-mm-yyyy',
        formatSubmit: 'yyyy-mm-dd',
        hiddenName: true
      });

})(jQuery);