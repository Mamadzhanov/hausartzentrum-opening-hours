jQuery(document).ready(function($) {
  $('.hz-opening-time-row input[type=checkbox]').on('change', function() {
      const $row = $(this).closest('.hz-opening-time-row');
      const $inputs = $row.find('input[type=time]');
      if ($(this).is(':checked')) {
          $inputs.attr('disabled', 'disabled');
      } else {
          $inputs.removeAttr('disabled');
      }
  }).trigger('change');

  $('.hz-opening-time-row input[type=time]').on('change', function() {
      const time = $(this).val().split(':');
      const hour = parseInt(time[0], 10);
      let minute = parseInt(time[1], 10);

      // Round the minutes to the nearest 15-minute interval
      if (minute < 15) {
          minute = 0;
      } else if (minute < 30) {
          minute = 15;
      } else if (minute < 45) {
          minute = 30;
      } else {
          minute = 45;
      }

      // Format the hour and minute values as two-digit strings
      const newTime = ('0' + hour).slice(-2) + ':' + ('0' + minute).slice(-2);
      $(this).val(newTime);
  });
});
