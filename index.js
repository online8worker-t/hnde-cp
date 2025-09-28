// const name = `A.B.C.PERERA`;
// const regNo = `COL/CE/2020/F/030`;
// const memberFormat = regNo.slice(0, -3);
// const memberFormat = '';
// const course = `HNDCE`;


function generatePDF() {
    const {
        jsPDF
    } = window.jspdf;

    // Get form values
    const type = document.getElementById("type").value.toUpperCase();
    const no = document.getElementById("no").value.toUpperCase();
    const subject = document.getElementById("subject").value.toUpperCase();
    const subjectCode = document.getElementById("subject-code").value.toUpperCase();
    const instructor = document.getElementById("instructor").value.toUpperCase();
    const group = document.getElementById("group").value.toUpperCase();
    const members = document.getElementById("members").value.toUpperCase();
    const title = document.getElementById("title").value.toUpperCase();
    const name = document.querySelector("#name").value.toUpperCase();
    let regNo = document.querySelector("#regNo").value.toUpperCase();
    const course = document.querySelector("#course").value.toUpperCase();
    const dateOfIns = document.getElementById("dateOfIns").value.toUpperCase();
    const dateOfSub = document.getElementById("dateOfSub").value.toUpperCase();

    const memberFormat = regNo.slice(0, -3);

    // Create PDF document
    const doc = new jsPDF();

    doc.setFont("serif", "normal");
    doc.setFontSize(20);

    // Add content to the PDF
    doc.text(`${type} NO: ${no}`, 110, 20);
    const wrappedText1 = doc.splitTextToSize(subject, 87);
    let myPos1 = 28;
    wrappedText1.forEach(line => {
        doc.text(line, 110, myPos1); // Position at x=30, y position increases after each member
        myPos1 += 8; // Increase y position to avoid overlapping
    });
    doc.text(subjectCode, 110, myPos1);



    // members
    // Split the string into an array of individual member values
    const memberArray = members.split(',');

    // Create an array with the desired format
    let formattedMembers = memberArray.map(member => `${memberFormat}${member}`);


    // Set the starting position for the first member

    let text2 = '';

    // Title
    let yPos = 135;
    doc.setFontSize(30);
    const wrappedText2 = doc.splitTextToSize(`${title}`, 150);
    // let yPos = 125;
    wrappedText2.forEach(line => {
        doc.text(line, 110, yPos, {
            align: "center",
            underline: true,
        });
        const textWidth = doc.getTextWidth(line);

        // Draw the underline: Line starts at xPos, yPos + 2 (below the text)
        doc.setLineWidth(0.5); // Adjust line thickness as needed
        doc.line(110 - textWidth / 2, yPos + 2, 110 + textWidth / 2, yPos + 2);
        yPos += 13; // Adjust vertical position
    });


    let myPos = yPos + 8.35; // Adjust as needed for positioning
    
    if (formattedMembers != memberFormat) {
        text2 = `GROUP MEMBERS: `;
        doc.setFontSize(11);
        formattedMembers.forEach(member => {
            doc.text(member, 66, myPos); // Position at x=30, y position increases after each member
            myPos += 5; // Increase y position to avoid overlapping
        });
    } else {
        text2 = ``
        formattedMembers = ``
    }

    let text3 = '';
    if (instructor === '') {
        text3 = ``;
    } else {
        text3 = `INSTRUCTED BY: ${instructor}`;
    }

    let text4 = '';
    if (group === '') {
        text4 = ``;
    } else {
        text4 = `GROUP: ${group}`;
    }

    

    let text1 = `
${text3}
${text4}
${text2}
`;

    doc.setFontSize(11);
    doc.text(text1, 30, yPos - 5);

    doc.setFontSize(11);
    doc.text(`REG NO: ${regNo} `, 110, 260);
    doc.text(`NAME: ${name} `, 110, 265);
    doc.text(`COURSE: ${course} `, 110, 270);
    doc.text(`DATE OF INS: ${dateOfIns} `, 110, 275);
    doc.text(`DATE OF SUB: ${dateOfSub}`, 110, 280);

    // Add border and styling
    doc.setLineWidth(0.3);
    doc.rect(25, 10, 175, 277); // Outer border of the page

    // Save PDF
    doc.save(`${name}.pdf`);
}

// ================================================================
// =================================================================
document.getElementById("form").addEventListener("submit", function (e) {
    e.preventDefault();

    // Validation regNo function
    function validateRegNo(regNo) {
        let regExPattern = /^(?:[A-Z]{3}\/[A-Z]{2}\/[0-9]{4}\/[A-Z]\/[0-9]{3}|[A-Z]{3}\/[A-Z]{3}\/[0-9]{4}\/[A-Z]\/[0-9]{3})$/;
        return regExPattern.test(regNo);
    }

    regNo2 = document.getElementById("regNo").value.toUpperCase().trim();

    // Check if the registration number matches the required pattern
    if (!validateRegNo(regNo2)) {
        event.preventDefault(); // Prevent form submission
        alert("Invalid Registration Number! Please follow the format: XXX/XX/XXXX/X/XXX or XXX/XXX/XXXX/X/XXX");
    } else {
        generatePDF();
    }



    // Collect form data
    const type = document.getElementById("type").value;
    const no = document.getElementById("no").value;
    const subject = document.getElementById("subject").value;
    const subjectCode = document.getElementById("subject-code").value;
    const instructor = document.getElementById("instructor").value;
    const group = document.getElementById("group").value;
    const members = document.getElementById("members").value;
    const title = document.getElementById("title").value;
    const name = document.getElementById("name").value;
    const regNo = document.getElementById("regNo").value;
    const course = document.getElementById("course").value;
    const dateOfIns = document.getElementById("dateOfIns").value;
    const dateOfSub = document.getElementById("dateOfSub").value;

    // Prepare data to be sent to the server
    const formData = new FormData();
    formData.append('type', type);
    formData.append('no', no);
    formData.append('subject', subject);
    formData.append('subjectCode', subjectCode);
    formData.append('instructor', instructor);
    formData.append('group', group);
    formData.append('members', members);
    formData.append('title', title);
    formData.append('name', name);
    formData.append('regNo', regNo);
    formData.append('course', course);
    formData.append('dateOfIns', dateOfIns);
    formData.append('dateOfSub', dateOfSub);

    // Send data to PHP using Fetch API
    fetch('api/api-0.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text()) // Handle response from server
        .then(data => { })
        .catch(error => { });
});