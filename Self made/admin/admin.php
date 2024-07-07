<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loan_id = $_POST['loan_id'];
    $action = $_POST['action'];

    $status = $action === 'approve' ? 'Approved' : 'Rejected';
    $sql = "UPDATE loans SET status='$status' WHERE id='$loan_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Loan application $status!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT loans.id, users.username, loans.amount, loans.term, loans.status 
        FROM loans 
        JOIN users ON loans.user_id = users.id 
        WHERE loans.status = 'Pending'";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "Loan ID: " . $row['id'] . " - User: " . $row['username'] . " - Amount: " . $row['amount'] . " - Term: " . $row['term'] . " months - Status: " . $row['status'];
    echo "<form method='post' action='admin.php'>
            <input type='hidden' name='loan_id' value='" . $row['id'] . "'>
            <button type='submit' name='action' value='approve'>Approve</button>
            <button type='submit' name='action' value='reject'>Reject</button>
          </form>";
}

$conn->close();
?>
