document.addEventListener("DOMContentLoaded", function () {
  const suggestionButton = document.getElementById("submit-suggestion");

  suggestionButton.addEventListener("click", function () {
    const suggestionText = document.getElementById("suggestion-text").value.trim();

    if (!suggestionText) {
      alert("Пожалуйста, введите ваше предложение.");
      return;
    }

    // Отправка данных на сервер
    fetch("php/submit_proposal.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ suggestion: suggestionText }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);
          document.getElementById("suggestion-text").value = ""; // Очистить поле
        } else {
          alert(data.error || "Произошла ошибка.");
        }
      })
      .catch((error) => {
        console.error("Ошибка:", error);
        alert("Произошла ошибка при отправке предложения.");
      });
  });
});