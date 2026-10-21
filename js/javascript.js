document.addEventListener('DOMContentLoaded', () => {
  const feedbackButton = document.getElementById('submit-feedback');
  feedbackButton.addEventListener('click', () => {
    const feedback = document.getElementById('feedback-text').value.trim();

    if (!feedback) {
      alert('Пожалуйста, введите отзыв.');
      return;
    }

    fetch('php/feedback_submit.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ feedback }),
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          document.getElementById('feedback-text').value = '';
        } else {
          alert(data.error);
        }
      })
      .catch(error => {
        console.error('Ошибка:', error);
        alert('Ошибка при отправке отзыва.');
      });
  });
});