<?php


include('./database/config.php');
// include('update_notifications.php'); // Comment out this line if not needed

if (isset($_SESSION['logged']) != "true") {
    header("Location: login.php");
    die();
}

// Fetch the number of vendors
$query = "SELECT COUNT(*) AS vendor_count FROM vendor";
$result = mysqli_query($conn, $query);
$vendor_count = mysqli_fetch_assoc($result)['vendor_count'];

// Fetch the number of SDMs
$query = "SELECT COUNT(*) AS sdm_count FROM service_delivery_manager";
$result = mysqli_query($conn, $query);
$sdm_count = mysqli_fetch_assoc($result)['sdm_count'];

// Fetch the total number of users
$query = "SELECT COUNT(*) AS user_count FROM users";
$result = mysqli_query($conn, $query);
$user_count = mysqli_fetch_assoc($result)['user_count'];

// Fetch the total number of contracts
$query = "SELECT COUNT(*) AS contract_count FROM contract";
$result = mysqli_query($conn, $query);
$contract_count = mysqli_fetch_assoc($result)['contract_count'];

// Fetch the number of contracts made today
$query = "SELECT COUNT(*) AS contract_today_count FROM contract WHERE DATE(created_at) = CURDATE()";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$contract_today_count = mysqli_fetch_assoc($result)['contract_today_count'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <style>
        .bg-primary {
            background-color: #0d6efd !important;
        }
        .bg-secondary {
            background-color: #6c757d !important;
        }
        .bg-danger {
            background-color: #dc3545 !important;
        }
        .bg-warning {
            background-color: #ffc107 !important;
        }
        .bg-info {
            background-color: #0dcaf0 !important;
        }
        .bg-success {
            background-color: #198754 !important;
        }
        .secondary-bg {
            background-color: #f8f9fa !important;
        }
        .page-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 1em;
        }
    </style>
</head>

<body>
  <div class="page-wrap">
     
     <div class="d-flex" id="wrapper">
        
        <div class="container-fluid px-4">
             <h1>All Users</h1>
            <div class="row g-3 my-2">
                <div class="col-md-3 col-sm-6">
                    <div class="p-3 bg-primary bg-gradient shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $vendor_count; ?></h3>
                            <p class="fs-5">Vendors</p>
                        </div>
                        <i class="fas fa-hotdog fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="p-3 bg-secondary bg-gradient shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $sdm_count; ?></h3>
                            <p class="fs-5">SDMs</p>
                        </div>
                        <i class="fas fa-list-alt fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="p-3 bg-danger bg-gradient shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $user_count; ?></h3>
                            <p class="fs-5">Total Users</p>
                        </div>
                        <i class="fas fa-users fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="p-3 bg-warning bg-gradient shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $contract_count; ?></h3>
                            <p class="fs-5">Contracts Made</p>
                        </div>
                        <i class="fas fa-file-contract fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="p-3 bg-info bg-gradient shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $contract_today_count; ?></h3>
                            <p class="fs-5">Contracts Made Today</p>
                        </div>
                        <i class="fas fa-calendar-day fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>


</html>