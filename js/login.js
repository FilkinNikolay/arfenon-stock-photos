document.addEventListener('DOMContentLoaded', () => {
  const loginButton = document.getElementById('loginButton');
  loginButton.addEventListener('click', () => {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!username || !password) {
      alert('Пожалуйста, заполните все поля.');
      return;
    }

    // Отправка данных в PHP через fetch
    fetch('php/login_submit.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ username, password }),
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
        } else {
          alert(data.error);
        }
      })
      .catch(error => {
        console.error('Ошибка:', error);
        alert('Ошибка при отправке данных.');
      });
  });
});