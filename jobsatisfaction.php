<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Satisfaction and Fulfillment Survey</title>
  <link rel="stylesheet" href="jobsatisfaction.css">
</head>

<body>

<?php
  // Replace these variables with your actual database connection details
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "pollwizardry";
  $table = "jobsatisfactionq";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Fetch questions and options from the database
  $sql = "SELECT * FROM $table";
  $result = $conn->query($sql);
?>

  <form action="jobsatisfaction_submit.php" method="post">
    <h1>Job Satisfaction and Fulfillment</h1>

<?php
  if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["Question"] . "</td>";
      echo "<td>";
      echo "<label><input type='radio' name='q" . $row["QID"] . "' value='A'> A) " . $row["Option1"] . "</label>";
      echo "<label><input type='radio' name='q" . $row["QID"] . "' value='B'> B) " . $row["Option2"] . "</label>";
      echo "<label><input type='radio' name='q" . $row["QID"] . "' value='C'> C) " . $row["Option3"] . "</label>";
      echo "<label><input type='radio' name='q" . $row["QID"] . "' value='D'> D) " . $row["Option4"] . "</label>";
      echo "</td>";
      echo "</tr>";
    }
  } else {
    echo "0 results";
  }

  // Close connection
  $conn->close();
?>


    </table>
    <br/>
    <input type="submit" value="Submit">
  </form>

</body>
</html>
