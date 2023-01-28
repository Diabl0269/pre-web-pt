$("#page").slideDown("slow");

const topic = new URLSearchParams(window.location.search).get("topic");

const getMessages = () => {
  if (!topic) return alert("A topic must be selected!");
  AjaxMethod(
    {
      action: "getMessages",
      topic,
    },
    (response) => {
      const topicsEl = $("#topics");
      topicsEl.empty();
      for (const data of response.data) {
        if (!(data?.displayName || data?.content)) continue;

        const name = sanitize(data.displayName),
          content = sanitize(data.content);
        if (name && content) {
          topicsEl.append(`<li class="list-group-item">
        ${name} - ${content}</li>`);
        }
      }
    }
  );
};

// Get all messages on page load.
getMessages();

$("form").on("submit", (e) => {
  e.preventDefault();

  const textAreaEl = $("textarea"),
    content = textAreaEl.val();

  if (!content) {
    return alert("A message must be supplied!");
  }

  AjaxMethod(
    {
      action: "createMessage",
      content,
      topic,
    },
    () => {
      getMessages();
      textAreaEl.val("");
    },
    () => alert("Server error")
  );
});
