const GAMES_SECRET_MESSAGES_HIDE_CLASS = "hide-visibility";

const GAMES_SECRET_MESSAGES_UNHIDE_EVENTS = [
  "game-dice-max-score-reached"
];

const GAMES_SECRET_MESSAGES_HIDE_EVENTS = [
  "game-dice-reset"
];

function setSecretMessageVisibilityFrom(visible, gameContainer) {
  const secretMessageId = gameContainer.dataset.secretMessageId;
  if (secretMessageId !== undefined) {
    const secretMessageElement = document.getElementById(secretMessageId);
    if (secretMessageElement !== null) {
      if (visible) {
        secretMessageElement.classList.remove(GAMES_SECRET_MESSAGES_HIDE_CLASS);
      } else {
        secretMessageElement.classList.add(GAMES_SECRET_MESSAGES_HIDE_CLASS);
      }
    }
  }
}

for (const unhideEvent of GAMES_SECRET_MESSAGES_UNHIDE_EVENTS) {
  document.addEventListener(unhideEvent, function(event) {
    const target = event.target;
    setSecretMessageVisibilityFrom(true, target);
  });
}

for (const hideEvent of GAMES_SECRET_MESSAGES_HIDE_EVENTS) {
  document.addEventListener(hideEvent, function(event) {
    const target = event.target;
    setSecretMessageVisibilityFrom(false, target);
  });
}