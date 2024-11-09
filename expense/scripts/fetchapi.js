const user_id = localStorage.getItem('userID');

const transactionsList = document.getElementById('transactions');
const edit = document.getElementById('edit');
const expense = document.getElementById('expense');
const income = document.getElementById('income');
const userId = document.getElementById('userId');
userId.value = user_id;

console.log(user_id);


function displayTransactions() {
  fetch(`http://localhost/expense-tracker/server/get_transactions.php?user_id=${user_id}`)
    .then(response => response.json())
    .then(function (data) {
      transactionsList.innerHTML = '';
      data.forEach(row => {
        const rowTable = document.createElement('tr');
        rowTable.innerHTML = `
        <td>${row.title}</td>
        <td>${row.amount}</td>
        <td>${row.type}</td>
        <td>${row.date}</td>
        <td>${row.notes}</td>
        <td>
          <button class="delete_btn" transaction_id=${row.id}>Delete</button>
          <button class="edit_btn" transaction_id=${row.id}>Edit</button>
        </td>
      `;
        console.log(row);
        transactionsList.appendChild(rowTable);
      });
      get_user_expense();
      get_user_income();
    }

    )
    .catch(error => console.error('Error:', error));
}

transactionsList.addEventListener('click', function (event) {
  if (event.target && event.target.classList.contains('delete_btn')) {
    console.log("Delete button clicked");

    const transactionId = event.target.getAttribute('transaction_id');
    console.log("Transaction ID:", transactionId);

    fetch(`http://localhost/expense-tracker/server/delete_transactions.php?id=${transactionId}`)
      .then(displayTransactions())
      .catch(error => {
        console.error('Error deleting transaction:', error);
      });
  }

  if (event.target && event.target.classList.contains('edit_btn')) {
    const transactionId = event.target.getAttribute('transaction_id');
    console.log("Transaction ID:", transactionId);

    edit.style.display = 'block';


    //display the data to be edited
    fetch(`http://localhost/expense-tracker/server/get_transactions.php?transaction_id=${transactionId}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('title').value = data.title;
        document.getElementById('amount').value = data.amount;
        document.getElementById('type').value = data.type;
        document.getElementById('date').value = data.date;
        document.getElementById('notes').value = data.notes;
      })
      .catch(error => {
        console.error('Error retrieving transaction:', error);
      });


    edit.addEventListener('click', () => {
      const title = document.getElementById('title').value;
      let amount = document.getElementById('amount').value;
      let type = document.getElementById('type').value;
      let date = document.getElementById('date').value;
      let notes = document.getElementById('notes').value;

      const formData = new FormData();
      formData.append("title", title);
      formData.append("type", type);
      formData.append("amount", amount);
      formData.append("date", date);
      formData.append("notes", notes);
      formData.append("id", transactionId);

      fetch("http://localhost/expense-tracker/server/edit_transactions.php", {
        method: "POST",
        body: formData
      })
        .then(response => response.text())
        .then(data => {
          console.log(data);
        })
        .catch(error => {
          console.error("Error:", error);
        });

    })

  }

});
function get_user_expense() {
  const formData = new FormData();
  formData.append("id", user_id);

  fetch("http://localhost/expense-tracker/server/getTotalExpense.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.json())
    .then(data => expense.innerText = data.total_amount + "$")
}

function get_user_income() {
  const formData = new FormData();
  formData.append("id", user_id);

  fetch("http://localhost/expense-tracker/server/getTotalIncome.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.json())
    .then(data => income.innerText = data.total_amount + "$")

}


displayTransactions();
