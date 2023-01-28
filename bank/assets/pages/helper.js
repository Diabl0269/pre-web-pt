function AjaxMethod(parameters, successCallback, errorCallback) {
  $.ajax({
    type: "POST",
    url: "./api.php",
    data: JSON.stringify(parameters),
    contentType: "application/json;",
    dataType: "json",
    success: successCallback,
    error: function (xhr, textStatus, errorThrown) {
      errorCallback?.(xhr, textStatus, errorThrown);
      console.error("can't process the request ", xhr, textStatus, errorThrown);
    },
  });
}
