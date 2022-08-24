/**
 * Validate and submit the registration form.
 */
$("#register-form").validate({
  rules: {
    name: {
      required: true,
    },
    email: {
      required: true,
      email: true,
    },
    password: {
      required: true,
      minlength: 6,
    },
    confirmPassword: {
      required: true,
      equalTo: "#register-password",
    },
  },
  // callback for handling submittion when form is valid
  submitHandler: function (form) {
    HelpModules.Http.submit(
      form,
      getRegisterFormData(form),
      function (response) {
        HelpModules.Util.displaySuccessMessage($(form), response.message);
        setTimeout(function () {
          window.location = "./";
        }, 3000);
      }
    );
  },
});

/**
 * Get registration form data as JSON.
 * @param form
 */
function getRegisterFormData(form) {
  return {
    action: "registerUser",
    user: {
      name: form["name"].value,
      email: form["email"].value,
      password: HelpModules.Util.hash(form["password"].value),
      passwordConfirm: HelpModules.Util.hash(form["confirmPassword"].value),
    },
  };
}
