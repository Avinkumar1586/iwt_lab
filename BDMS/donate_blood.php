<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <?php
  $active = 'donate';
  include('head.php') ?>

  <div id="page-container" style="margin-top:50px; position: relative;min-height: 84vh;">
    <div class="container">
      <div id="content-wrap" style="padding-bottom:50px;">
        <div class="row">
          <div class="col-lg-6">
            <h1 class="mt-4 mb-3">Donate Blood</h1>
          </div>
        </div>
        <!-- Form submission triggers modal -->
        <form id="donorForm" name="donor" action="savedata.php" method="post">
          <div class="row">
            <div class="col-lg-4 mb-4">
              <div class="font-italic">Full Name<span style="color:red">*</span></div>
              <div><input type="text" name="fullname" class="form-control" required></div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="font-italic">Mobile Number<span style="color:red">*</span></div>
              <div><input type="text" name="mobileno" class="form-control" required></div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="font-italic">Email Id</div>
              <div><input type="email" name="emailid" class="form-control"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 mb-4">
              <div class="font-italic">Age<span style="color:red">*</span></div>
              <div><input type="text" name="age" class="form-control" required></div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="font-italic">Gender<span style="color:red">*</span></div>
              <div><select name="gender" class="form-control" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              </div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="font-italic">Blood Group<span style="color:red">*</span></div>
              <div><select name="blood" class="form-control" required>
                <option value="" selected disabled>Select</option>
                <?php
                  include 'conn.php';
                  $sql= "select * from blood";
                  $result=mysqli_query($conn,$sql) or die("query unsuccessful.");
                  while($row=mysqli_fetch_assoc($result)){
                ?>
                <option value=" <?php echo $row['blood_id'] ?>"> <?php echo $row['blood_group'] ?> </option>
                <?php } ?>
              </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 mb-4">
              <div class="font-italic">Address<span style="color:red">*</span></div>
              <div><textarea class="form-control" name="address" required></textarea></div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 mb-4">
              <div><input type="submit" name="submit" class="btn btn-primary" value="Submit" style="cursor:pointer"></div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php include('footer.php') ?>
  </div>

  <!-- Bootstrap Modal -->
  <div class="modal fade" id="submissionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Submission Successful</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Thank you for submitting your details. We will reach out to you soon!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript to handle form submission using AJAX -->
  <script>
    $(document).ready(function() {
      $("#donorForm").on("submit", function(event) {
        event.preventDefault(); // Prevent form from submitting normally
        
        // Send form data using AJAX
        $.ajax({
          url: "savedata.php", // PHP file to handle data submission
          type: "POST",
          data: $(this).serialize(), // Serialize form data
          success: function(response) {
            // Show the modal with success message
            $('#submissionModal').modal('show');
            
            // Optional: Refresh the page after the modal is closed
            $('#submissionModal').on('hidden.bs.modal', function () {
              location.reload();
            });
          },
          error: function(xhr, status, error) {
            alert("An error occurred. Please try again.");
          }
        });
      });
    });
  </script>

</body>

</html>
