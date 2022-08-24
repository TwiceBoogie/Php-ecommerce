/**
 * Validate and submit the login form.
 */
$("#login-form").validate({
  rules: {
    email: {
      required: true,
    },
    password: {
      required: true,
    },
  },
  submitHandler: function (form) {
    HelpModules.Http.submit(form, getLoginFormData(form), function (result) {
      window.location = result.page;
    });
  },
});

/**
 * Builds a login form JSON data that should be sent to the server.
 * @returns {{action: string, username: string, password: string}}
 */
function getLoginFormData(form) {
  return {
    action: "checkLogin",
    email: form["email"].value,
    password: HelpModules.Util.hash(form["password"].value),
  };
}
