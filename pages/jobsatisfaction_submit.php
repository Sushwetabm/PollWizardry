<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Satisfaction Survey</title>
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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pollwizardry";
$tableQ = "jobsatisfactionq";
$tableA = "jobsatisfactiona";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    foreach ($_POST as $key => $value) {
        
        if (substr($key, 0, 1) == 'q') {
            $qid = substr($key, 1); 

            
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


$sql = "SELECT * FROM $tableQ";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $qid = $row['QID'];
        $question = $row['Question'];
        $option1 = $row['Option1'];
        $option2 = $row['Option2'];
        $option3 = $row['Option3'];
        $option4 = $row['Option4'];

        
        $countSql = "SELECT Option1, Option2, Option3, Option4 FROM $tableA WHERE QID = $qid";
        $countResult = $conn->query($countSql);

        if ($countResult->num_rows > 0) {
            
            echo "<h2>$question</h2>";
            echo "<table border='1'>";
            echo "<tr><th>$option1</th><th>$option2</th><th>$option3</th><th>$option4</th></tr>";

            /
            $countRow = $countResult->fetch_assoc();
            echo "<tr><td>{$countRow['Option1']}</td><td>{$countRow['Option2']}</td><td>{$countRow['Option3']}</td><td>{$countRow['Option4']}</td></tr>";

            echo "</table>";

            
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

$conn->close();
?>

</body>
</html>
