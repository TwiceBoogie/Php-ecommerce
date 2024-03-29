jQuery.validator.setDefaults({
  errorElement: "em",
  errorPlacement: function (error, element) {
    error.addClass("invalid-feedback");

    element.prop("type") === "checkbox"
      ? error.insertAfter(element.next("label"))
      : error.insertAfter(element);
  },
  highlight: function (element, errorClass, validClass) {
    $(element).addClass("is-invalid");
  },
  unhighlight: function (element, errorClass, validClass) {
    $(element).removeClass("is-invalid");
  },
});

var HelpModules = {
  Util: {},
  Http: {},
};
