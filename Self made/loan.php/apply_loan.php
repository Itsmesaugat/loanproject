<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $term = $_POST['term'];

    $sql = "INSERT INTO loans (user_id, amount, term) VALUES ('$user_id', '$amount', '$term')";
    if ($conn->query($sql) === TRUE) {
        echo "Loan application successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
