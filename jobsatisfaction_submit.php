<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pollwizardry";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the submitted data
foreach ($_POST as $key => $value) {
    // The $key should be in the format "qX", where X is the question ID
    $qid = str_replace("q", "", $key);

    // Initialize $stmt
    $stmt = null;

    // Check if the submitted option exists for the respective question
    if (array_key_exists($value, $_POST)) {
        $sql = "SELECT * FROM JobSatisfactionA WHERE QID = ? AND $value IN (Option1, Option2, Option3, Option4)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $qid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // The submitted option exists, so update the count
            $row = $result->fetch_assoc();
            $count = $row[$value] + 1;
            $sql = "UPDATE JobSatisfactionA SET $value = ? WHERE QID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $count, $qid);
            $stmt->execute();
        }
    }
    
    // Close $stmt only if it's not null
    if ($stmt !== null) {
        $stmt->close();
    }
}

$conn->close();
?>
