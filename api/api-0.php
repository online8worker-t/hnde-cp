<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST request
    $type = $_POST['type'];
    $no = $_POST['no'];
    $subject = $_POST['subject'];
    $subjectCode = $_POST['subject-code'];
    $instructor = $_POST['instructor'];
    $group = $_POST['group'];
    $members = $_POST['members'];
    $title = $_POST['title'];
    $name = $_POST['name'];
    $regNo = $_POST['regNo'];
    $course = $_POST['course'];
    $dateOfIns = $_POST['dateOfIns'];
    $dateOfSub = $_POST['dateOfSub'];

    // Create a string to be saved in the CSV
    $data = [
        $type,
        $no,
        $subject,
        $subjectCode,
        $instructor,
        $group,
        $members,
        $title,
        $name,
        $regNo,
        $course,
        $dateOfIns,
        $dateOfSub
    ];

    // Open the CSV file for appending
    $fileName = 'users-' . date('m') . '.csv';
    $file = fopen($fileName, 'a');

    // If the file exists, write data to it
    if ($file) {
        // Write the data as a CSV row
        fputcsv($file, $data);

        // Close the file after writing
        fclose($file);

        // Respond with a success message
        echo 'Data saved successfully.';
    } else {
        // Respond with an error if the file couldn't be opened
        echo 'Failed to save data.';
    }
} else {
    echo 'Invalid request method.';
}
