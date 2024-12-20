<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>
    #sidebar {
      position: relative;
      margin-top: -20px;
    }
    #content {
      position: relative;
      margin-left: 210px;
    }
    @media screen and (max-width: 600px) {
      #content {
        position: relative;
        margin-left: auto;
        margin-right: auto;
      }
    }
    #he {
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
      padding: 3px 7px;
      color: #fff;
      text-decoration: none;
      border-radius: 3px;
      text-align: center;
    }
  </style>
</head>

<body style="color:black">
<?php
  include 'conn.php';
  include 'session.php';

  // Ensure user is logged in
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    echo '<div class="alert alert-danger"><b>Please Login First To Access Admin Portal.</b></div>';
    echo '<form method="post" action="login.php" class="form-horizontal">';
    echo '<div class="form-group"><div class="col-sm-8 col-sm-offset-4" style="float:left">';
    echo '<button class="btn btn-primary" name="submit" type="submit">Go to Login Page</button></div></div></form>';
    exit();
  }

  // Mark query as read if the link is clicked
  if (isset($_GET['id'])) {
    $que_id = $_GET['id'];
    $sql1 = "UPDATE contact_query SET query_status='1' WHERE query_id={$que_id}";
    mysqli_query($conn, $sql1);
  }
?>

<div id="header">
  <?php include 'header.php'; ?>
</div>

<div id="sidebar">
  <?php $active="query"; include 'sidebar.php'; ?>
</div>

<div id="content">
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 lg-12 sm-12">
          <h1 class="page-title">Pending Query</h1>
        </div>
      </div>
      <hr>

      <?php
        // Pagination logic
        $limit = 10;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $count = $offset + 1;

        // Fetch pending queries
        $sql = "SELECT * FROM contact_query WHERE query_status = 0 LIMIT {$offset}, {$limit}";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
      ?>
      <div class="table-responsive">
        <table class="table table-bordered" style="text-align:center">
          <thead>
            <tr>
              <th>S.no</th>
              <th>Name</th>
              <th>Email Id</th>
              <th>Mobile Number</th>
              <th>Message</th>
              <th>Posting Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $row['query_name']; ?></td>
              <td><?php echo $row['query_mail']; ?></td>
              <td><?php echo $row['query_number']; ?></td>
              <td><?php echo $row['query_message']; ?></td>
              <td><?php echo $row['query_date']; ?></td>
              <td>
                <?php if ($row['query_status'] == 1) { ?>
                  <span>Read</span>
                <?php } else { ?>
                  <a href="pending_query.php?id=<?php echo $row['query_id']; ?>">Pending</a>
                <?php } ?>
              </td>
              <td>
                <a style="background-color:aqua" href='delete_query.php?id=<?php echo $row['query_id']; ?>'>Delete</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <?php
        } else {
          echo '<div class="alert alert-danger">No pending queries found.</div>';
        }
      ?>

      <div class="table-responsive" style="text-align:center;">
        <?php
          // Pagination display
          $sql1 = "SELECT * FROM contact_query WHERE query_status = 0";
          $result1 = mysqli_query($conn, $sql1);
          $total_records = mysqli_num_rows($result1);

          if ($total_records > 0) {
            $total_page = ceil($total_records / $limit);

            echo '<ul class="pagination admin-pagination">';
            if ($page > 1) {
              echo '<li><a href="pending_query.php?page='.($page - 1).'">Prev</a></li>';
            }
            for ($i = 1; $i <= $total_page; $i++) {
              $active = ($i == $page) ? 'active' : '';
              echo '<li class="'.$active.'"><a href="pending_query.php?page='.$i.'">'.$i.'</a></li>';
            }
            if ($total_page > $page) {
              echo '<li><a href="pending_query.php?page='.($page + 1).'">Next</a></li>';
            }
            echo '</ul>';
          }
        ?>
      </div>
    </div>
  </div>
</div>

</body>
</html>
