$("#page").slideDown("slow");

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

const sanitize = (input) => {
  if (!input) {
    return console.error("Input must be provided");
  }
  return DOMPurify.sanitize(input);
};

const getTopics = (appendElementFn) =>
  AjaxMethod({ action: "getTopics" }, (response) => {
    for (const d of response.data) {
      if (!d.name) continue;

      const name = sanitize(d.name),
        description = sanitize(d.description);
      if (name) {
        $("#topics").append(appendElementFn({ name, description, id: d.id }));
      }
    }
  });
