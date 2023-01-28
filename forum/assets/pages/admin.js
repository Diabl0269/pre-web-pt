const appendElementFn = ({
  name,
  description,
  id,
}) => `<li class="list-group-item d-flex">
<div class="col-9" id="row-${id}"><span id="${id}">${name}</span>${
  description && ` - <span id="${id}Desc">${description}</span></div>`
}<div class="col-3 d-flex justify-content-end align-items-center">
<button id="edit${id}" class="btn btn-secondary btn-sm me-3" onclick="editTopic('${id}')">Edit</button>
<button class="btn btn-danger btn-sm" onclick="deleteTopic('${id}')">Delete</button></div>
</li>`;

// Get all topics on page load.
getTopics(appendElementFn);

const handleError = (err) => alert(err?.responseJSON?.data || err.responseText);

$("#form-create").on("submit", (e) => {
  e.preventDefault();

  const nameVal = $("#newName").val(),
    descriptionVal = $("#newDescription").val();

  if (!(nameVal && descriptionVal)) {
    return alert("Name and description must be filled");
  }

  AjaxMethod(
    {
      action: "createTopic",
      data: { name: nameVal, description: descriptionVal },
    },
    (res) => {
      alert("Created topic successfully");
      $("#topics").empty();
      getTopics(appendElementFn);
      $("#form-create")[0].reset();
    },
    handleError
  );
});

const editTopic = (id) => {
  // Disable Edit button
  $(`#edit${id}`).prop("disabled", true);

  // Create form
  const nameInput = `<div class="form-floating w-100">
  <input class="form-control" type="text" name="name" id="name" value="${$(
    `#${id}`
  ).text()}">
  <label for="name">Name</label>
  </div>`,
    descriptionId = `#${id}Desc`,
    descriptionInput = `<div class="form-floating w-100 mb-3">
    <textarea class="form-control" id="description" placeholder="Description" name="description">${$(
      descriptionId
    ).text()}</textarea>
    <label for="description">Description</label>
  </div>`;
  $(`#row-${id}`).html(
    `<form id="form-${id}" class="d-flex flex-column align-items-center">${nameInput} - ${descriptionInput}<button class="btn btn-primary" type="submit">Update</button></form>`
  );

  // Event handler
  $(`#form-${id}`).on("submit", (e) => {
    e.preventDefault();

    const nameVal = $("#name").val(),
      descriptionVal = $("#description").val();

    if (!(nameVal && descriptionVal)) {
      return alert("Name and Description must be filled");
    }

    // Update operation
    AjaxMethod(
      {
        action: "updateTopic",
        data: { name: nameVal, description: descriptionVal, id },
      },
      (res) => {
        alert("Updated topic successfully");
        $("#topics").empty();
        getTopics(appendElementFn);
      },
      handleError
    );
  });
};

const deleteTopic = (id) =>
  AjaxMethod(
    {
      action: "deleteTopic",
      id,
    },
    () => {
      alert("Deleted topic successfully");
      $("#topics").empty();
      getTopics(appendElementFn);
    },
    handleError
  );
