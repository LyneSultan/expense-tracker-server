const login_user = document.getElementById('login_user');
const sign_user = document.getElementById('sign_user');


function create_user() {
  const uname = document.getElementById('name').value;
  const password = document.getElementById('password').value;

  fetch(`http://localhost/expense-tracker/server/create_user.php?name=${encodeURIComponent(uname)}&password=${encodeURIComponent(password)}`)
    .then(response => response.text())
    .then(userID => {
      if (userID) {
        console.log(userID);
        localStorage.setItem("userID", userID);
        window.location.href = `index.html`;
      } else {
        console.error('User creation failed or returned invalid ID');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

function login() {
  const uname = document.getElementById('name').value;
  const password = document.getElementById('password').value;

  fetch(`http://localhost/expense-tracker/server/login.php?name=${encodeURIComponent(uname)}&password=${encodeURIComponent(password)}`)
    .then(response => response.json())
    .then(userID => {
      if (userID != "Invalid password") {
        console.log(userID["id"]);
        localStorage.setItem("userID", userID["id"]);
        window.location.href = `index.html`;
      } else {
        console.error('User creation failed or returned invalid ID');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

login_user.addEventListener("click", () => {
  login();
});
sign_user.addEventListener("click", () => {
  create_user();
});
