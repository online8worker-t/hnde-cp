<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HNDE Report Helper</title>
    <?php include_once('group-links.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
</head>

<body>

    <style>
        .message {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 4px;
        }

        .success {
            background-color: #00a868ff;
            color: #ffffffff;
            font-size: 1.3em;
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            margin: 1rem auto;
            width: 600px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 20px 100vh rgba(0, 0, 0, 0.6);
        }

        .error {
            background-color: #ff0066;
            color: #fff;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.8em;
            margin-top: 0;
            display: none;
        }

        .key .cover {
            width: 210px;
        }

        .key .discount {
            background: var(--font-color-2);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            background: linear-gradient(135deg, #0097ee, #d60076);
            z-index: -1;
            color: #fff;
            width: fit-content;
            text-align: center;
        }

        .buy-key {
            padding: 0.5rem 1rem;
            border: 1px solid var(--background-color-1);
            border-radius: 2rem;
            width: fit-content;
            margin-top: 0.5rem;
        }

        ul li a {
            color: var(--background-color-1);
            text-decoration: underline;
        }

        @media screen and (max-width: 600px) {
            .success {
                width: 340px;
                height: 270px;
            }
        }
    </style>

    <section class="key">
        <img src="./assets/hnde-triangle-3.png?v=1.0.0" class="logo" alt="">
        <div class="container">
            <h1>Register now to create unlimited cover pages.</h1>
            <!-- <h2 class="buy-key">XXXX-XXXX-XXXX-XXXX</h2> -->
            <img class="cover" src="./assets/cover-1.png" alt="">
            <br>
            <p class="discount">For Unlimited Access</p>
            <h1 class="price">Rs. 200.00 <span></span></h1>
        </div>
        <form id="registrationForm">
            <div>
                <label for="registration_number">Your Registration Number</label>
                <input type="text" id="registration_number" name="registration_number" placeholder="COL/CE/2020/F/XXX">
                <span class="error-message" id="regNoError"></span>
            </div>
            <div>
                <label for="full_name">Your Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="A.B.C.Perera">
                <span class="error-message" id="fullNameError"></span>
            </div>
            <div>
                <label for="course">Course</label>
                <select name="course" id="course">
                    <option value="HNDCE">HNDCE</option>
                    <option value="HNDQS">HNDQS</option>
                    <option value="HNDME">HNDME</option>
                    <option value="HNDBSE">HNDBSE</option>
                    <option value="HNDEEE">HNDEEE</option>
                </select>
            </div>
            <!-- <div>
                <label for="whatsapp">WhatsApp</label>
                <input type="text" id="whatsapp" name="whatsapp" placeholder="07XXXXXXXX">
                <span class="error-message" id="whatsappError"></span>
            </div> -->
            <div>
                <h3>Payment methods</h3>
                <br>
                <p><b>1. eZ Cash</b></p>
                <p>076 539 5434</p>
                <br>
                <p>— OR —</p>
                <br>
                <p><b>2. Reload</b></p>
                <p>076 539 5434</p>
                <br>
                <p>— OR —</p>
                <br>
                <p><b>3. Bank Deposit</b></p>
                <p>K Ravindu Madhushanka</p>
                <p>3430898</p>
                <p>B.O.C. (Bank of Ceylon)</p>
                <p>Beliatta Branch</p>
                <br>
                <p>Put your registration number as the description. (Online payments)</p>
                <p>Example: <b>COLCE2020FXXX</b></p>
                <br>
                <div>
                    <label for="payment_receipt">Upload your Payment Proof (screenshot/pdf/photo)</label>
                    <input type="file" id="payment_receipt" name="payment_receipt">
                    <span class="error-message" id="paymentError"></span>
                </div>
                <div>
                    <label for="email">Remark (Optional)</label>
                    <input type="text" id="email" name="tr_id" placeholder="Reference No/Mobile/Other">
                    <span class="error-message" id="emailError"></span>
                </div>
                <br>
                <br>
                <h3>We will check your transaction within 24 hours, and you will be allowed to create cover pages.</h3>
                <br>
                <h3>If your transaction is found to be invalid, we will remove your registration number without prior notice. Please try again.</h3>
                <br>
            </div>
            <div id="responseMessage" class="message" style="display:none;"></div>
            <input class="btn btn-0" id="submit-btn" type="submit" value="Register Now">
        </form>
    </section>

    <?php include_once('footer.php') ?>


    <script>
        const form = document.getElementById('registrationForm');
        const responseMessageDiv = document.getElementById('responseMessage');

        // Client-side validation function
        const validateForm = () => {
            let isValid = true;
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');

            const regNo = document.getElementById('registration_number').value.toUpperCase();
            const regNoPattern = /^(?:[A-Z]{3}\/[A-Z]{2}\/[0-9]{4}\/[A-Z]\/[0-9]{3}|[A-Z]{3}\/[A-Z]{3}\/[0-9]{4}\/[A-Z]\/[0-9]{3})$/;
            if (!regNo || !regNoPattern.test(regNo)) {
                document.getElementById('regNoError').textContent = 'Invalid format. BBB/MM/YYYY/F/XXX.';
                document.getElementById('regNoError').style.display = 'block';
                isValid = false;
            }

            const fullName = document.getElementById('full_name').value.toUpperCase();
            if (!fullName) {
                document.getElementById('fullNameError').textContent = 'Full name is required.';
                document.getElementById('fullNameError').style.display = 'block';
                isValid = false;
            }

            const email = document.getElementById('email').value;
            // const emailPattern = /[0-9]|[A-Z]/;
            // if (!email || !emailPattern.test(email)) {
            //     document.getElementById('emailError').textContent = 'Field is required.';
            //     document.getElementById('emailError').style.display = 'block';
            //     isValid = false;
            // }

            // const whatsapp = document.getElementById('whatsapp').value;
            // const whatsappPattern = /^07[0-9]{8}$/;
            // if (!whatsapp || !whatsappPattern.test(whatsapp)) {
            //     document.getElementById('whatsappError').textContent = 'Invalid WhatsApp number format. Use 07XXXXXXXX.';
            //     document.getElementById('whatsappError').style.display = 'block';
            //     isValid = false;
            // }

            const paymentReceipt = document.getElementById('payment_receipt').files[0];
            if (!paymentReceipt) {
                document.getElementById('paymentError').textContent = 'Payment receipt is required.';
                document.getElementById('paymentError').style.display = 'block';
                isValid = false;
            }

            return isValid;
        };

        const generatePDF = (data, uniqueKey) => {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            const title = "HNDE Report Helper";
            const contacts = "www.gdoop.us/hnde-cp";
            const tableData = [
                ['Your Key', uniqueKey],
                ['Registration Number', data.get('registration_number')],
                ['Full Name', data.get('full_name')],
                ['Course', data.get('course')],
            ];

            doc.setFontSize(22);
            doc.text(title, 105, 20, null, null, 'center');

            doc.setFontSize(12);
            doc.text("Thank you for your registration. Please keep this receipt for your records.", 10, 40);

            doc.autoTable({
                startY: 50,
                head: [
                    ['Property', 'Value']
                ],
                body: tableData,
                theme: 'striped',
                headStyles: {
                    fillColor: [0, 0, 0]
                }
            });

            doc.setFontSize(10);
            doc.text(contacts, 105, doc.lastAutoTable.finalY + 10, null, null, 'center');

            doc.save(`Receipt__${data.get('registration_number')}__Report_Helper.pdf`);
        };

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!validateForm()) {
                responseMessageDiv.style.display = 'block';
                responseMessageDiv.className = 'message error';
                responseMessageDiv.innerHTML = 'Please use correct information to proceed.';
                return;
            }

            const formData = new FormData(form);

            try {
                const response = await fetch('api/api-1.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    document.querySelector('#submit-btn').disabled = true;
                    responseMessageDiv.style.display = 'block';
                    responseMessageDiv.className = 'message success';
                    responseMessageDiv.innerHTML = `<p>${result.message}</p><br>
                    <p>Receipt has downloaded.</p>
                    <p><b>Please check your Downloads folder.</b></p><br>
                    <a style="color: #000; background: #fff; padding: 0.5rem; border-radius: 5px; font-size: 16px; margin-right: 0.5rem;" href="login?c=<?php echo uniqid('') ?>">Log in</a><a style="color: #000; background: #fff; padding: 0.5rem; border-radius: 5px; font-size: 16px; cursor: pointer;" id="downloadToken">Download again</a>`;

                    //<p><b style="font-size: 1.3em;">${result.key}</b></p><br>

                    document.getElementById("downloadToken").addEventListener("click", () => {
                        generatePDF(formData, result.key);
                    });

                    // Generate and download PDF
                    generatePDF(formData, result.key);



                    // form.reset();
                    document.querySelector('#submit-btn').disabled = false;
                } else {
                    responseMessageDiv.style.display = 'block';
                    responseMessageDiv.className = 'message error';
                    responseMessageDiv.innerHTML = `${result.message}`;
                }
            } catch (error) {
                responseMessageDiv.style.display = 'block';
                responseMessageDiv.className = 'message error';
                responseMessageDiv.innerHTML = `Could not connect to the server.`;
            }

        });
    </script>

    <!-- <script>
        window.addEventListener('beforeunload', function(e) {
            // Modern browsers ignore custom messages
            e.preventDefault(); // Required for Chrome
            e.returnValue = ''; // Required for legacy compatibility
            // The actual message is ignored in most modern browsers
        });
    </script> -->
</body>

</html>