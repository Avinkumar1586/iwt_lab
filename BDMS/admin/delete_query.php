<?php
include 'conn.php';

if (isset($_GET['id'])) {
  $que_id = $_GET['id'];

  // Delete the query from the database
  $sql = "DELETE FROM contact_query WHERE query_id = {$que_id}";
  if (mysqli_query($conn, $sql)) {
    // Redirect to pending_query.php with success message
    header("Location: query.php?message=Query+Deleted+Successfully");
  } else {
    // Redirect with failure message
    header("Location: query.php?message=Failed+to+Delete+Query");
  }

  mysqli_close($conn);
}
?>
