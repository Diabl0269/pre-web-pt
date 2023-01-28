$("documnet").ready(() => {
  console.log("window.location.search", window.location.search);
  const DEFAULT_URL =
    "https://images.unsplash.com/photo-1566847438217-76e82d383f84?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1180&q=80";
  const imageUrl = new URLSearchParams(window.location.search).get("IMAGE_URL");
  const src = imageUrl || DEFAULT_URL;
  const imageHTML = `<img width="300" alt="Image Displayer" src="${src}"/>`;

  document.querySelector("#injcet").innerHTML = imageHTML;

  $("form").on("submit", (e) => {
    e.preventDefault();

    const sanitize = (string) => {
      const map = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        "'": "&#x27;",
      };
      const reg = /[&<>']/gi;
      return string.replace(reg, (match) => map[match]);
    };

    const url = sanitize($("input").val());
    window.location.search = `IMAGE_URL=${url}`;
  });
});
