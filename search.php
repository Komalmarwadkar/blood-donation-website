<?php
include('include/header.php');
include('include/connection.php'); 
?>

<style>
    .size {
        min-height: 0px;
        padding: 40px 0 20px 0;
    }
    h1 {
        color: white;
    }
    h3 {
        color: #e74c3c;
        text-align: center;
    }
    .red-bar {
        width: 25%;
    }
    .name {
        color: #e74c3c;
        font-size: 22px;
        font-weight: 700;
    }
    .donors_data {
        background-color: white;
        border-radius: 5px;
        margin: 20px 5px 0px 5px;
        -webkit-box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
        -moz-box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
        box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
        padding: 20px;
    }
</style>

<div class="container-fluid red-background size">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="text-center">Search Results</h1>
            <hr class="white-bar">
        </div>
    </div>
</div>

<!-- Search Results -->
<div class="container" style="padding: 20px 0;">
    <div class="row data">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
            $blood_group = mysqli_real_escape_string($connection, $_POST['blood_group']);
            $city = mysqli_real_escape_string($connection, $_POST['city']);

            $query = "SELECT DISTINCT name, blood_group, gender, dob, email, contact_no, city 
                      FROM donor 
                      WHERE city LIKE '%$city%' 
                      AND blood_group = '$blood_group' 
                      AND save_life_date != '0'";

            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <div class="col-md-3 col-sm-12 col-lg-3 donors_data">
                        <span class="name">' . htmlspecialchars($row['name']) . '</span>
                        <span><b>City:</b> ' . htmlspecialchars($row['city']) . '</span>
                        <span><b>Blood Group:</b> ' . htmlspecialchars($row['blood_group']) . '</span>
                        <span><b>Gender:</b> ' . htmlspecialchars($row['gender']) . '</span>
                        <span><b>Email:</b> ' . htmlspecialchars($row['email']) . '</span>
                        <span><b>Contact:</b> ' . htmlspecialchars($row['contact_no']) . '</span>
                    </div>';
                }
            } else {
                echo '<div class="col-md-12">
                        <div class="alert alert-danger text-center">Data not found</div>
                      </div>';
            }
        } else {
            echo '<div class="col-md-12">
                    <div class="alert alert-info text-center">Please go back and search again from Home Page</div>
                  </div>';
        }
        ?>
    </div>
</div>

<?php include('include/footer.php'); ?>