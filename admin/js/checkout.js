$("#checkout-form").validate({
  rules: {
    name: {
      required: true,
    },
    email: {
      required: true,
    },
  },
});
