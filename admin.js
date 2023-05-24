jQuery(document).ready(function ($) {
  $(".hz-opening-time-row input[type=checkbox]")
    .on("change", function () {
      const $row = $(this).closest(".hz-opening-time-row");
      const $inputs = $row.find("input[type=time]");
      if ($(this).is(":checked")) {
        $inputs.attr("disabled", "disabled");
      } else {
        $inputs.removeAttr("disabled");
      }
    })
    .trigger("change");
});
