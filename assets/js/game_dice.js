const GAME_DICE_DIE_FACE_COUNT = 10;
const GAME_DICE_MAX_ROLL = 5;

const GAME_DICE_SHOW_LEADERBOARD_DELAY_MS = 2 * 1000;

const GAME_DICE_HIDE_CLASS = "hide-display";

const gameDiceMaxScore = GAME_DICE_MAX_ROLL * GAME_DICE_DIE_FACE_COUNT;

let gameDicePlayers;

const gameDiceContainer = document.querySelector("#game-dice-container");
const gameDiceStartForm = document.querySelector("#game-dice-start-form");
const gameDicePlayerCards = document.querySelector("#game-dice-player-cards");
const gameDicePlayerCardTemplate = document.querySelector("#game-dice-player-card-template");
const gameDiceLeaderboardElement = document.querySelector("#game-dice-leaderboard");
const gameDiceLeaderboardBody = document.querySelector("#game-dice-leaderboard-body");
const gameDiceLeaderboardRowTemplate = document.querySelector("#game-dice-leaderboard-row-template");

let gameDiceShowLeaderboardTimeoutId;

function gameDiceInitializePlayers(playerCount) {
  gameDicePlayers = [];
  for (let i = 0; i < playerCount; ++i) {
    gameDicePlayers[i] = {
      name: `Joueur ${i + 1}`,
      score: 0,
      roll: 0
    };
  }
}

function gameDiceUpdatePlayerScoreElement(playerScoreElement, playerId) {
  playerScoreElement.textContent = gameDicePlayers[playerId].score.toString();
}

function gameDiceUpdatePlayerCurrentRollNumberElement(playerCurrentRollNumberElement, playerId) {
  playerCurrentRollNumberElement.textContent = gameDicePlayers[playerId].roll.toString();
}

function gameDiceAddPlayerCards() {
  for (let i = 0; i < gameDicePlayers.length; ++i) {
    const playerCardTemplate = document.importNode(gameDicePlayerCardTemplate.content, true);

    const playerCard = playerCardTemplate.querySelector(".game-dice-player-card");
    playerCard.setAttribute("data-player", i.toString()); //Identify the card element with the player id

    const playerCardName = playerCardTemplate.querySelector(".game-dice-player-card-name");
    playerCardName.textContent = gameDicePlayers[i].name;

    const playerScore = playerCardTemplate.querySelector(".game-dice-player-score");
    gameDiceUpdatePlayerScoreElement(playerScore, i);

    const playerCurrentRollNumber = playerCardTemplate.querySelector(".game-dice-player-current-roll-number");
    gameDiceUpdatePlayerCurrentRollNumberElement(playerCurrentRollNumber, i);

    gameDicePlayerCards.appendChild(playerCardTemplate);
  }
}

function getRandomIntInclusive(min, max) {
  const minCeiled = Math.ceil(min);
  const maxFloored = Math.floor(max);
  return Math.floor(Math.random() * (maxFloored - minCeiled + 1) + minCeiled);
}

function gameDiceCreateLeaderboard() {
  const leaderboard = [];

  //Add player name and score entries to the leaderboard
  for (let i = 0; i < gameDicePlayers.length; ++i) {
    const player = gameDicePlayers[i];
    leaderboard[i] = {
      name: player.name,
      score: player.score
    };
  }

  //Sort the leaderboard by score in descending order. If tie, sort lexicographically by name
  leaderboard.sort(function (a, b) {
    if (a.score === b.score) {
      return a.name.localeCompare(b.name);
    }
    return b.score - a.score;
  });

  //Calculate the rank (competition ranking system, for example "1,2,2,4") of each player
  //Track the previous rank and score while iterating on the sorted leaderboard to determine the next rank
  let previousRank = null;
  let previousScore = null;
  for (let i = 0; i < leaderboard.length; ++i) {
    const leaderboardEntry = leaderboard[i];
    const score = leaderboardEntry.score;

    let rank;
    //Check if it's not a tie with the player above
    if (score !== previousScore) {
      rank = i + 1; //Set the rank to the player index from the sorted leaderboard + 1
    } else {
      rank = previousRank; //Set the rank to the same as the player above since it's a tie
    }

    leaderboardEntry.rank = rank;

    previousRank = rank;
    previousScore = score;
  }

  return leaderboard;
}

function gameDiceAddLeaderboardRows(leaderboard) {
  for (const leaderboardEntry of leaderboard) {
    const leaderboardRowTemplate = document.importNode(gameDiceLeaderboardRowTemplate.content, true);

    const leaderboardRowRankDataText = leaderboardRowTemplate.querySelector(".game-dice-leaderboard-data-rank-text");
    leaderboardRowRankDataText.textContent = `${leaderboardEntry.rank}.`;

    const leaderboardRowNameDataText = leaderboardRowTemplate.querySelector(".game-dice-leaderboard-data-name-text");
    leaderboardRowNameDataText.textContent = leaderboardEntry.name;

    const playerScore = leaderboardRowTemplate.querySelector(".game-dice-player-score");
    playerScore.textContent = leaderboardEntry.score.toString();

    gameDiceLeaderboardBody.appendChild(leaderboardRowTemplate);
  }
}

function gameDiceHandleGameEnd() {
  const leaderboard = gameDiceCreateLeaderboard();

  gameDiceAddLeaderboardRows(leaderboard);

  //Wait
  gameDiceShowLeaderboardTimeoutId = setTimeout(function () {
    gameDicePlayerCards.classList.add(GAME_DICE_HIDE_CLASS); //Hide player card container

    //Show and scroll to the leaderboard element
    gameDiceLeaderboardElement.classList.remove(GAME_DICE_HIDE_CLASS);
    gameDiceLeaderboardElement.scrollIntoView({ behavior: "smooth" });
  }, GAME_DICE_SHOW_LEADERBOARD_DELAY_MS);
}

function gameDiceOnPlayerCardsClick(event) {
  const target = event.target;
  //Check if a roll button element is clicked inside the player card container
  if (target.classList.contains("game-dice-player-card-roll-button")) {
    const playerCard = target.closest(".game-dice-player-card"); //Retrieve the player card element of the roll button
    const playerId = Number.parseInt(playerCard.dataset.player); //Retrieve the player id from the card element

    //Roll a die and update the new player total score
    const rollScore = getRandomIntInclusive(1, GAME_DICE_DIE_FACE_COUNT);
    gameDicePlayers[playerId].score += rollScore;
    const playerScore = playerCard.querySelector(".game-dice-player-score");
    gameDiceUpdatePlayerScoreElement(playerScore, playerId);

    //Increment the number of rolls of the player and update its text
    gameDicePlayers[playerId].roll++;
    const playerCurrentRollNumber = playerCard.querySelector(".game-dice-player-current-roll-number");
    gameDiceUpdatePlayerCurrentRollNumberElement(playerCurrentRollNumber, playerId);
    //Disable the button if we reached the roll limit
    if (gameDicePlayers[playerId].roll >= GAME_DICE_MAX_ROLL) {
      target.disabled = true;
    }

    //Dispatch an event if the player reached max score
    if (gameDicePlayers[playerId].score >= gameDiceMaxScore) {
      const gameDiceMaxScoreReachedEvent = new Event("game-dice-max-score-reached", { bubbles: true });
      gameDiceContainer.dispatchEvent(gameDiceMaxScoreReachedEvent);
    }

    //Check if all players reached the roll limit to end the game
    let gameEnded = true;
    for (const player of gameDicePlayers) {
      if (player.roll < GAME_DICE_MAX_ROLL) {
        gameEnded = false;
        break;
      }
    }

    if (gameEnded) {
      gameDiceHandleGameEnd();
    }
  }
}

function gameDiceGameStart(settings) {
  gameDiceInitializePlayers(settings.playerCount);

  gameDicePlayerCards.classList.remove(GAME_DICE_HIDE_CLASS);
  gameDiceAddPlayerCards();

  //Add a global click event listener on the player card container for all roll buttons
  gameDicePlayerCards.addEventListener("click", gameDiceOnPlayerCardsClick);
}

function gameDiceReset() {
  gameDicePlayerCards.removeEventListener("click", gameDiceOnPlayerCardsClick);
  clearTimeout(gameDiceShowLeaderboardTimeoutId);
  gameDiceShowLeaderboardTimeoutId = null;
  gameDiceLeaderboardElement.classList.add(GAME_DICE_HIDE_CLASS);
  gameDiceLeaderboardBody.replaceChildren();
  gameDicePlayerCards.classList.add(GAME_DICE_HIDE_CLASS);
  gameDicePlayerCards.replaceChildren();
  gameDicePlayers = null;

  const gameDiceResetEvent = new Event("game-dice-reset", { bubbles: true });
  gameDiceContainer.dispatchEvent(gameDiceResetEvent);
}

gameDiceStartForm.addEventListener("submit", function (event) {
  event.preventDefault();

  const formData = new FormData(gameDiceStartForm);

  const playerCount = Number.parseInt(formData.get("game-dice-setting-input-player-count"));
  if (Number.isNaN(playerCount) || playerCount < 1) {
    return;
  }

  const settings = {};
  settings.playerCount = playerCount;

  gameDiceReset();
  gameDiceGameStart(settings);
});