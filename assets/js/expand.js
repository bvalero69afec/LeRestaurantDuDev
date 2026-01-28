const EXPAND_BUTTON_ACTIVE_CLASS = "active";

const expandButtons = document.querySelectorAll("button[data-toggle-expand-id]");

for (const expandButton of expandButtons) {
  expandButton.addEventListener("click", function (event) {
    expandButton.classList.toggle(EXPAND_BUTTON_ACTIVE_CLASS);

    const expandId = expandButton.dataset.toggleExpandId;
    const expandElement = document.getElementById(expandId);
    if (expandElement !== null) {
      const expandButtonActive = expandButton.classList.contains(EXPAND_BUTTON_ACTIVE_CLASS);
      if (expandButtonActive) {
        expandElement.style.height = expandElement.scrollHeight + "px";
      } else {
        expandElement.style.height = null;
      }
    }
  });
}