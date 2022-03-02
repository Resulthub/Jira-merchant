<?php
//Database connection
require_once('config/config.php'); 

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $date = $_POST['date'];
    $value = $_POST['value'];
    $reason = $_POST['reason'];

    if(isset($_POST['submit'])) { 

        $sql = "INSERT INTO deposit (date, value, reason) VALUE (:date,:value,:reason)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':date', $date, PDO::PARAM_STR);
		$query->bindParam(':value', $value, PDO::PARAM_STR);
		$query->bindParam(':reason', $reason, PDO::PARAM_STR);
		$query->execute();

        if($query == TRUE){
            $msg = "<strong>Deposit!</strong> Save.";
        }else{
            $error = "<strong>Deposit!</strong> error.";
        }

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Jira Merchant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Form container -->
            <div class="col">
                <div class="container">
                <h2> ADD DEPOSIT</h2>
                <?php 
                    // Alert 
                    if($msg){
                        echo "<div class=\"alert alert-success alert-dismissible\" id=\"myAlert\"><button type=\"button\" class=\"close\">&times;</button> $msg </div>";
                    }
                    
                    if($error){
                        echo "<div class=\"alert alert-danger alert-dismissible\" id=\"myAlert\"><button type=\"button\" class=\"close\">&times;</button> $error </div>";
                    } 
                ?>        
                <form method="POST" action="" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" id="date" placeholder="Enter Date" name="date" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="value">Value:</label>
                        <input type="text" class="form-control" id="value" placeholder="Enter Value" name="value" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <textarea class="form-control" id="reason" name="reason" required></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group form-check">
                        <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember" required> Check me.
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Check this checkbox to Save.</div>
                    </label>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </form>
                </div>
            </div>
            <!-- Data table container -->
            <div class="col"> 
                <div class="table-responsive">
                    <table class="table">
                    <div class="container">
                        <h2>ALL DEPOSITS</h2>
                        <div class="table-responsive-sm">          
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Value</th>
                                    <th>Reason</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    // Query for view List of Deposit record 
                                    $sql = "SELECT * from deposit";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0){
                                    foreach($results as $result){   
                                        $date = $result->date;
                                        $value = $result->value;
                                        $reason = $result->reason;
                                ?>
                                <tr>
                                    <td><?php echo $cnt; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $value; ?></td>
                                    <td><?php echo $reason; ?></td>
                                </tr>
                                </tbody>
                                <?php $cnt+=1; }}else{
                                    echo "No Record found";
                                } ?>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</body>
<script>
// Disable form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Get the forms we want to add validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
})();

$(document).ready(function(){
    $(".close").click(function(){
        $("#myAlert").alert("close");
    });
});
</script>
</html> 