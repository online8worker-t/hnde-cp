<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Make a cover page for your assignments, practicals or experiments. A cover page can be generated for assignments, practicals and experiments. Made for HNDE students in Sri Lanka.">
    <meta name="keywords" content="HNDE, hnde, cover page, ravindu, madhushankha, gdoop, assignments, practicals, experiments">
    <link rel="canonical" href="https://gdoop.us/hnde-cp/">
    <title>Log in - HNDE Report Helper</title>
    <?php include_once('group-links.php'); ?>
</head>

<style>
    .error {
        color: #ff0066;
        padding-bottom: 1.2rem;
    }

    .wa-msg {
        padding: 0.3rem;
        color: #fff;
        background: #00cf9bff;
    }

    .buy-key {
        padding: 0.5rem 1rem;
        border: 1px solid var(--background-color-1);
        border-radius: 2rem;
        width: 100%;
    }

    form p {
        text-align: left !important;
        margin-bottom: 0.2rem;
        font-size: 14px;
    }
</style>

<body>
    <section class="login">
        <div class="container">
            <img src="./assets/hnde-triangle-3.png?v=1.0.0" class="logo" alt="">
            <h2>Report Helper</h2>
        </div>
        <form id="loginForm">
            <p for="">Your Registration Number</p>
            <input type="text" id="keyInput" placeholder="COL/BSE/2020/F/XXX">
            <input class="btn btn-4" type="submit" value="Log in">
            <div class="error" id="message"></div>
            <a class="buy-key" href="key?c=<?php echo uniqid('') ?>">I'm New</a><br><br>
            <a style="font-size: 14px; text-decoration: underline;" href="https://gdoop.us/hnde-triangle/contact?c=<?php echo uniqid('') ?>">Any Problem? Contact Us</a>
        </form>
        <div id="messageBox" class="message-box"></div>
        <div class="covers">
            <img class="cover" src="./assets/cover-2.png?c=<?php echo uniqid('') ?>" alt="">
            <img class="cover" src="./assets/cover-1.png?c=<?php echo uniqid('') ?>" alt="">
        </div>

        <?php include_once('footer.php') ?>

    </section>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const key = document.getElementById('keyInput').value.trim();
            const messageDiv = document.getElementById('message');

            if (!key) {
                messageDiv.textContent = "Please enter your Reg Number.";
                return;
            }

            try {
                const response = await fetch('api/api-2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        key
                    })
                });

                const result = await response.json();

                if (!result.success) {
                    if (result.status === 'pending') {
                        messageDiv.innerHTML = `Your are not activated yet.<br>Can't wait? <a target="_blank" href="https://wa.me/94765395434?text=[Enter_your_REG_NO]%20My%20key%20is%20not%20activated%20yet." style="padding: 0.3rem;color: #00a37aff;border-radius: 5px;text-decoration: underline;font-weight: bold;">WhatsApp us</a>`;
                    } else {
                        messageDiv.textContent = result.error || "Login failed.";
                    }
                } else {
                    // Save user data in sessionStorage and redirect
                    sessionStorage.setItem('userData', JSON.stringify(result.data));
                    localStorage.setItem('userData', JSON.stringify(result.data));
                    window.location.href = `app?c=<?php echo uniqid('') ?>`;
                }
            } catch (err) {
                messageDiv.textContent = err + "Server error. Please try again.";
            }
        });
    </script>

    <script>
        // Get the unique_key from localStorage
        const userData = JSON.parse(localStorage.getItem('userData') || '{}');
        const uniqueKey = userData.registration_number;

        document.querySelector('#keyInput').value = uniqueKey;

        // If not found, redirect to login page
        if (!uniqueKey) {
            document.querySelector('#keyInput').value = '';
        }

    </script>


</body>

</html>