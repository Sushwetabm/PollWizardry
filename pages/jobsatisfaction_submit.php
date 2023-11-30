<?php
// Replace these variables with your actual database connection details
$servername = "localhost";
$username = "root";
$password = "Sush#2004";
$dbname = "pollwizardry";
$tableA = "jobsatisfactiona";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through each question
    foreach ($_POST as $key => $value) {
        // Check if the field is a question field
        if (substr($key, 0, 1) == 'q') {
            $qid = substr($key, 1); // Extract QID from the field name

            // Update the corresponding row in the JobSatisfactionA table
            $sql = "UPDATE $tableA SET Option1 = Option1 + " . ($value == 'A' ? 1 : 0) . ",
                                        Option2 = Option2 + " . ($value == 'B' ? 1 : 0) . ",
                                        Option3 = Option3 + " . ($value == 'C' ? 1 : 0) . ",
                                        Option4 = Option4 + " . ($value == 'D' ? 1 : 0) . "
                    WHERE QID = $qid";

            $conn->query($sql);
        }
    }

    echo "Survey data successfully submitted!";
} else {
    echo "Invalid request";
}

// Close connection
$conn->close();
?>
