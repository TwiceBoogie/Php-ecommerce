HelpModules.Util.displaySuccessMessage = function (parentElement, message) {
  $(".alert-success").remove();
  var div = "<div class='alert alert-success mb-3'>" + message + "</div>";
  parentElement.prepend(div);
};

HelpModules.Util.displayErrorMessage = function (element, message) {
  element.addClass("is-invalid").removeClass("is-valid");

  if (typeof message !== "undefined") {
    element.after($("<em class='invalid-feedback'>" + message + "</em>"));
  }
};

HelpModules.Util.removeErrorMessages = function () {
  $("form input").removeClass("is-invalid").removeClass("is-valid");
  $(".invalid-feedback").remove();
};

HelpModules.Util.showFormErrors = function (form, error) {
  $.each(error.responseJSON.errors, function (key, error) {
    HelpModules.Util.displayErrorMessage(
      $(form).find("input[name=" + key + "]"),
      error
    );
  });
};

HelpModules.Util.hash = function (value) {
  return value.length ? CryptoJS.SHA512(value).toString() : "";
};

HelpModules.Http.submit = function (form, data, success, error, complete) {
  HelpModules.Util.removeErrorMessages();

  $.ajax({
    url: "Backend/Ajax.php",
    type: "POST",
    dataType: "JSON",
    data: data,
    // This event is only called if the request was successful (no errors from the server, no errors with the data).
    success: function (response) {
      form.reset();

      if (typeof success === "function") {
        success(response);
      }
    },
    // This event is only called if an error occurred with the request (you can never have both an error and a success callback with a request).
    error:
      error ||
      function (errorResponse) {
        $(".alert.alert-success").remove();
        HelpModules.Util.showFormErrors(form, errorResponse);
      },
    // This event is called regardless of if the request was successful, or not.
    complete: complete || function () {},
  });
};

HelpModules.Http.post = function (data, success, error, complete) {
  $.ajax({
    url: "Backend/Ajax.php",
    type: "POST",
    dataType: "json",
    data: data,
    success: success || function () {},
    error: error || function () {},
    complete: complete || function () {},
  });
};
