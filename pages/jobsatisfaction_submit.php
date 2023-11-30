<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Satisfaction Survey</title>
    <!-- Add Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 200px;
            max-height: 200px;
            width: auto;
            height: auto;
        }
    </style>
</head>
<body>

<?php
// Replace these variables with your actual database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pollwizardry";
$tableQ = "jobsatisfactionq";
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
}

// Fetch questions and options from JobSatisfactionQ
$sql = "SELECT * FROM $tableQ";
$result = $conn->query($sql);

// Check if any data is available
if ($result->num_rows > 0) {
    // Display data in tables and pie charts
    while ($row = $result->fetch_assoc()) {
        $qid = $row['QID'];
        $question = $row['Question'];
        $option1 = $row['Option1'];
        $option2 = $row['Option2'];
        $option3 = $row['Option3'];
        $option4 = $row['Option4'];

        // Fetch count of each option from JobSatisfactionA
        $countSql = "SELECT Option1, Option2, Option3, Option4 FROM $tableA WHERE QID = $qid";
        $countResult = $conn->query($countSql);

        if ($countResult->num_rows > 0) {
            // Display question and options in a table
            echo "<h2>$question</h2>";
            echo "<table border='1'>";
            echo "<tr><th>$option1</th><th>$option2</th><th>$option3</th><th>$option4</th></tr>";

            // Display counts for each option
            $countRow = $countResult->fetch_assoc();
            echo "<tr><td>{$countRow['Option1']}</td><td>{$countRow['Option2']}</td><td>{$countRow['Option3']}</td><td>{$countRow['Option4']}</td></tr>";

            echo "</table>";

            // Create a canvas for the pie chart with reduced size
            echo "<canvas id='chart$qid' width='200' height='200'></canvas>";
            echo "<script>
                    var ctx = document.getElementById('chart$qid').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['$option1', '$option2', '$option3', '$option4'],
                            datasets: [{
                                data: [{$countRow['Option1']}, {$countRow['Option2']}, {$countRow['Option3']}, {$countRow['Option4']}],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                ],
                            }],
                        },
                        options: {
                            legend: {
                                position: 'right', // Set legend position to the right
                            },
                        },
                    });
                  </script><br>";
        } else {
            echo "No data available for question: $question";
        }
    }
} else {
    echo "No questions available.";
}

// Close connection
$conn->close();
?>

</body>
</html>
