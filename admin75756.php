<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="./favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            background-color: #fff;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ffffffff;
            color: #000;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .status-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .status-pending {
            background-color: rgba(228, 228, 228, 1);
            color: #000;
        }

        .status-allowed {
            background-color: #000000ff;
            color: #fff;
        }

        .message-box {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 4px;
            display: none;
            text-align: center;
            position: fixed;
            top: 1rem;
            left: 1rem;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .receipt-link {
            color: #000000ff;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container">
        <div id="loading" style="text-align: center; font-style: italic;">Loading data...</div>
        <div id="messageBox" class="message-box"></div>
        <table id="dataTable" style="display:none;">
            <thead>
                <tr>
                    <th>Reg. No.</th>
                    <th>Key</th>
                    <th>Full Name</th>
                    <th>Course</th>
                    <th>TID</th>
                    <th>Status</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody id="dataBody"></tbody>
        </table>
    </div>

    <script>
        const dataBody = document.getElementById('dataBody');
        const dataTable = document.getElementById('dataTable');
        const loading = document.getElementById('loading');
        const messageBox = document.getElementById('messageBox');

        // Function to display a message to the user
        function showMessage(type, text) {
            messageBox.style.display = 'block';
            messageBox.className = `message-box ${type}`;
            messageBox.textContent = text;
            setTimeout(() => {
                messageBox.style.display = 'none';
            }, 5000); // Hide message after 5 seconds
        }

        // Function to fetch and display data from the server
        async function fetchData() {
            loading.style.display = 'block';
            dataTable.style.display = 'none';
            dataBody.innerHTML = ''; // Clear existing data

            try {
                const response = await fetch('api/admin_panel.php');
                const data = await response.json();

                if (data.error) {
                    showMessage('error', `Error fetching data: ${data.error}`);
                    loading.style.display = 'none';
                    return;
                }

                if (data.length === 0) {
                    loading.textContent = 'No registrations found.';
                    return;
                }

                data.forEach(user => {
                    const row = document.createElement('tr');

                    // Display user information
                    row.innerHTML = `
                        <td>${user.registration_number}</td>
                        <td>${user.unique_key}</td>
                        <td>${user.full_name}</td>
                        <td>${user.course}</td>
                        <td>${user.email}</td>
                        <td>
                            <button 
                                class="status-btn status-${user.status.toLowerCase()}" 
                                data-key="${user.unique_key}" 
                                data-status="${user.status.toLowerCase()}"
                            >
                                ${user.status.charAt(0).toUpperCase() + user.status.slice(1)}
                            </button>
                        </td>
                        <td>
                            ${user.payment_receipt_path 
                                ? `<a href="receipt?file=${user.payment_receipt_path}" target="_blank" class="receipt-link">View Receipt</a>`
                                : 'N/A'
                            }
                        </td>
                    `;
                    dataBody.appendChild(row);
                });

                loading.style.display = 'none';
                dataTable.style.display = 'table';

            } catch (error) {
                showMessage('error', 'Network error. Could not connect to the server.');
                loading.style.display = 'none';
            }
        }

        // Function to handle status update requests
        async function updateStatus(uniqueKey, currentStatus) {
            const newStatus = currentStatus === 'pending' ? 'allowed' : 'pending';
            const formData = new FormData();
            formData.append('unique_key', uniqueKey);
            formData.append('status', newStatus);

            try {
                const response = await fetch('api/update_status.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showMessage('success', result.message);
                    fetchData(); // Refresh the table
                } else {
                    showMessage('error', `Update failed: ${result.message}`);
                }
            } catch (error) {
                showMessage('error', 'Network error. Could not update status.');
            }
        }

        // Event listener for the data table to handle status button clicks
        dataBody.addEventListener('click', (event) => {
            const target = event.target;
            if (target.classList.contains('status-btn')) {
                const uniqueKey = target.getAttribute('data-key');
                const currentStatus = target.getAttribute('data-status');
                updateStatus(uniqueKey, currentStatus);
            }
        });

        // Fetch data when the page loads
        fetchData();
    </script>
</body>

</html>