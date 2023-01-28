$("#logout").click(() => {
  AjaxMethod({ action: "logout" }, function () {
    document.location = "index.php";
  });
});
