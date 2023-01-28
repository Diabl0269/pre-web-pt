const errorClass = "text-danger";
const successClass = "text-success";

/**
 * @param {string} class1 - Class to add
 * @param {string} class2 - Class to remove
 */
const toggleHelper = (class1, class2) => {
  const el = $("#helper");
  if (!el.hasClass(class1)) {
    el.addClass(class1);
  }
  el.removeClass(class2);
};

$("#update_profile").click((e) => {
  e.preventDefault();

  if (!username.value) {
    toggleHelper(errorClass, successClass);
    return $("#helper").text("Username is required");
  }

  AjaxMethod(
    {
      action: "update_profile",
      data: {
        username: username.value,
        password: password.value,
      },
    },
    (res) => {
      $("#helper").text(res.data.data);
      console.log("res", res);
      if (res.success) {
        $("#name").text(username.value);
        toggleHelper(successClass, errorClass);
      }
    },
    (resRaw) => {
      const res = resRaw.responseJSON;
      $("#helper").text(res.data);
      toggleHelper(errorClass, successClass);
    }
  );
});
