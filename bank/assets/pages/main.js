$("#page").slideDown("slow");

const getTransactions = () =>
  AjaxMethod({ action: "get_all_transactions" }, (data) =>
    $("#transaction_history").html(data.data)
  );

// Get all transactions on page load.
getTransactions();

$("#logout").click(() => {
  AjaxMethod({ action: "logout" }, function () {
    document.location = "index.php";
  });
});

$("#send_transaction").click((e) => {
  e.preventDefault();

  // Validate fields are not empty
  if (!(user_to_name.value && amount.value)) {
    return $("#error").text("Please fill all fields.");
  }

  AjaxMethod(
    {
      action: "new_transaction",
      data: {
        user_to_name: user_to_name.value,
        amount: amount.value,
      },
    },
    () => {
      getTransactions();
      $("#form").trigger("reset");
    },
    () => $("#error").text("Failed to send transaction.")
  );
});
