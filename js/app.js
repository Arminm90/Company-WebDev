console.log('JavaScript file is loaded and running.');

// ##############################
async function is_email_available() {
  const frm = event.target.form;
  const conn = await fetch('api/api-is-email-available.php', {
    method: 'POST',
    body: new FormData(frm)
  });
  if (!conn.ok) {
    // everything that is not a 2xx
    console.log('email not available');
    document
      .querySelector('#msg_email_not_available')
      .classList.remove('hidden');
    return;
  }
  console.log('email available');
}

// ##############################
async function delete_user() {
  const frm = event.target;
  console.log(frm);
  const conn = await fetch('/api/api-admin-delete-user.php', {
    method: 'POST',
    body: new FormData(frm)
  });
  const response = await conn.json();
  console.log(response);
  frm.parentElement.remove();
}

// ##############################
async function toggle_blocked(user_id, user_is_blocked) {
  console.log('user_id', user_id);
  console.log('user_is_blocked', user_is_blocked);

  if (user_is_blocked == 0) {
    event.target.innerHTML = 'blocked';
  } else {
    event.target.innerHTML = 'unblocked';
  }

  const conn = await fetch(
    `http://localhost:8888/api/api-toggle-user-blocked.php?user_id=${user_id}&user_is_blocked=${user_is_blocked}`
  );
  const data = await conn.text();
  console.log(data);
}
async function signup() {
  const frm = event.target;
  console.log(frm);

  const conn = await fetch('/api/api-signup.php', {
    method: 'POST',
    body: new FormData(frm)
  });

  const data = await conn.json(); // Parse the JSON response

  console.log(data);

  if (data.success === true) {
    // Check if registration was successful
    // Redirect to the login page after successful signup
    window.location.href = '/views/login.php';
  } else {
    // Handle any errors or display appropriate message
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: data.message || 'Something went wrong!',
      footer: '<a href="">Why do I have this issue?</a>'
    });
  }
}

async function login() {
  const frm = event.target; // Get the form element
  try {
    const conn = await fetch('/api/api-login.php', {
      method: 'POST',
      body: new FormData(frm)
    });

    const responseData = await conn.json();
    console.log('Response Data:', responseData);

    if (conn.ok && responseData.status === 'success') {
      console.log('User Role:', responseData.user_role);

      window.location.href = '/views/user.php';

      switch (responseData.user_role.toLowerCase()) {
        case 'admin':
          console.log('Redirecting to Admin Page');
          window.location.href = '/views/admin.php';
          break;
        case 'partner':
          console.log('Redirecting to Partner Page');
          window.location.href = '/views/partner.php';
          break;
        case 'user':
          console.log('Redirecting to User Page'); // Ensure you see this log
          window.location.href = '/views/user.php';
          break;

        default:
          console.log('Unknown user role:', responseData.user_role);
          break;
      }
    } else {
      console.error('Failed to login');
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Failed to login. Please try again.',
        footer: '<a href="">Why do I have this issue?</a>'
      });
    }
  } catch (error) {
    console.error('An error occurred:', error);
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'An error occurred. Please try again.',
      footer: '<a href="">Why do I have this issue?</a>'
    });
  }
}

document.addEventListener('DOMContentLoaded', (event) => {
  const formElement = document.querySelector('#updateFormUser');

  if (formElement) {
    formElement.addEventListener('submit', async function (event) {
      event.preventDefault();
      await update_user();
    });
  } else {
    console.log('Form with ID "updateFormUser" not found.');
  }
});

async function update_user() {
  const frm = document.querySelector('#updateFormUser');
  const formData = new FormData(frm);
  console.log('Sending form data:', formData);

  try {
    const conn = await fetch('/company2/api/api-update.php', {
      method: 'POST',
      body: formData
    });

    if (!conn.ok) {
      throw new Error(`Failed to fetch: ${conn.statusText}`);
    }

    let responseData;
    try {
      responseData = await conn.json();
    } catch (jsonError) {
      console.error('Error parsing JSON:', jsonError);
      throw new Error('Invalid JSON response');
    }

    console.log('Response Data:', responseData);

    if (responseData && responseData.success) {
      alert('User updated successfully');
      console.log('User updated successfully');
    } else {
      console.error(
        'Failed to update user:',
        responseData ? responseData.message : 'Unknown error'
      );
    }
  } catch (error) {
    console.error('An error occurred:', error);
    if (error.message.includes('Invalid JSON response')) {
      console.error(
        'Unexpected server response. Redirecting or displaying a message...'
      );
    } else {
    }
  }
}
function confirmDelete() {
  if (
    confirm(
      'Are you sure you want to delete your account? This action cannot be undone.'
    )
  ) {
    window.location.href = '/company2/views/delete.php';
  }
}

document.querySelector('#frm_search').addEventListener('submit', function (event) {
  event.preventDefault();

  const query = document.querySelector('#search_query').value;
  const searchUrl = `/company2/api/api-search-employees.php?query=${query}`;

  // Fetch search results from API
  fetch(searchUrl)
    .then((response) => response.text())
    .then((q) => {
      // Display search results if query is not empty
      const queryResults = document.querySelector('#query_results');
      if (query.trim() !== '') {
        queryResults.innerHTML = q;
        queryResults.style.display = 'block'; // Show the search results
      } else {
        queryResults.innerHTML = ''; // Clear the search results
        queryResults.style.display = 'none'; // Hide the search results
      }
    })
    .catch((error) => {
      console.error('Error fetching search results:', error);
      document.querySelector('#query_results').innerHTML =
        '<div>Error fetching search results</div>';
    });
});
document.querySelector('#frm_search').addEventListener('submit', function (event) {
  event.preventDefault();

  const query = document.querySelector('#search_query').value;
  const searchUrl = `/company2/api/api-search-admin.php?query=${query}`; // Update the API endpoint to reflect the new backend script for admin search

  // Fetch search results from API
  fetch(searchUrl)
    .then((response) => response.text())
    .then((q) => {
      // Display search results if query is not empty
      const queryResults = document.querySelector('#query_results');
      if (query.trim() !== '') {
        queryResults.innerHTML = q;
        queryResults.style.display = 'block'; // Show the search results
      } else {
        queryResults.innerHTML = ''; // Clear the search results
        queryResults.style.display = 'none'; // Hide the search results
      }
    })
    .catch((error) => {
      console.error('Error fetching search results:', error);
      document.querySelector('#query_results').innerHTML =
        '<div>Error fetching search results</div>';
    });
});

