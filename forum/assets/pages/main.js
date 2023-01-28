const appendElementFn = ({ name, description }) => `<li class="list-group-item">
<a href="/topic.php?topic=${name.toLowerCase()}">${name}</a>${
  description && ` - ${description}`
}</li>`;

// Get all topics on page load.
getTopics(appendElementFn);
