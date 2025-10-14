<?php
include("connect.php"); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $bloodType = $_GET["bloodType"];
    $bloodPints = $_GET["bloodPints"];

    // Check if the blood type does not have any sign (+ or -)
    if (strpos($bloodType, '+') === false && strpos($bloodType, '-') === false) {
        // Add a positive sign (+) if it doesn't have any sign
        $bloodType = $bloodType . '+';
    }

    // Use prepared statement for security
    $availableQuery = "SELECT SUM(blood_pints) AS available_pints FROM blood_stock WHERE blood_type = ?";
    $stmt = $con->prepare($availableQuery);
    $stmt->execute([$bloodType]);
    $result = $stmt->fetch();

    if (!$result) {
        // Handle database query error
        echo 0; // Return 0 to indicate an error
    } else {
        $availablePints = (int)$result['available_pints'];
        echo $availablePints;
    }
}

mysqli_close($con);
?>
