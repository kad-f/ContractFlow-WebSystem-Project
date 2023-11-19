<?php
include('./database/config.php');
include('update_notifications.php');
session_start();
if (isset($_SESSION['logged']) != "true") {
	header("Location: login.php");
	die();
}

$roleID = $_SESSION['role_id'];
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

?>
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="./favicon/favicon.ico" type="image/x-icon">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Normalize -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<link rel="stylesheet" href="css/table_style.css"> <!-- Resource style -->
	<link rel="stylesheet" href="css/form_style.css"> <!-- Form Styling -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->

	<title>ContractFlow</title>
	<style>
		.cd-side-nav .action-btn a {
			background-color: yellow !important;
			color: #000 !important;
		}

		.cd-side-nav .action-btn a:hover {
			background-color: #ffeb3b !important;
		}

		.cd-side-nav .count {
			background-color: yellow;
			color: #000;
		}
	</style>


</head>

<body>
	<header class="cd-main-header">
		<a href="index.php?dashboard" class="cd-logo"><img src="img/cd-logo.png" alt="Logo" height="25"></a>
		<a href="#0" class="cd-nav-trigger">Menu<span></span></a>

		<nav class="cd-nav">
			<ul class="cd-top-nav">
				<div class="cd-search is-hidden">
					<form action="#0">
						<input type="search" placeholder="Search...">
					</form>
				</div>
				<li class="has-children account">
					<a href="#0">
						<img src="img/cd-user.png" alt="avatar">
						Account
					</a>
					<ul>
						<li><a href="logout.php?logout">Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</header>

	<main class="cd-main-content">
		<nav class="cd-side-nav">
			<ul>

				<li class="cd-label">Main</li>
				
				<li class="has-children overview">
					<?php if ($roleID == 1 || $roleID == 3) : ?>
						<a href="#0">Manage Contracts</a>
						<ul>
							<li><a href="index.php?new_contract">Add New Contract</a></li>
							<li><a href="#0">Edit Contract</a></li>
							<li><a href="index.php?view_contract&category_id=1">Hardware and Software Services</a></li>
							<li><a href="index.php?view_contract&category_id=2">Network and Security Services</a></li>
							<li><a href="index.php?view_contract&category_id=3">IT Support and Maintenance</a></li>
						</ul>
					<?php endif; ?>
					<?php if ($roleID == 2) : ?>
						<a href="#0">Manage Contracts</a>
						<ul>
							<li><a href="index.php?view_contract&category_id=1">Hardware and Software Services</a></li>
							<li><a href="index.php?view_contract&category_id=2">Network and Security Services</a></li>
							<li><a href="index.php?view_contract&category_id=3">IT Support and Maintenance</a></li>
						</ul>
					<?php endif; ?>
				</li>

				<li class="has-children notifications active">
					<a href="index.php?view_all_notifications">Notifications<span class="count">
							<?php
							$get_notifications = "select * from notification";

							$result = mysqli_query($conn, $get_notifications);
							$i = 0;
							if (mysqli_num_rows($result) == 0) {
								echo "0";
							} else {
								while ($row = mysqli_fetch_array($result)) {
									$status = $row['status'];
									if ($status == 0)
										$i++;
								}
								echo $i;
							}




							?>






						</span></a>
					<ul>
						<li><a href="#0">Expiration</a></li>
						<li><a href="#0">Notice Period</a></li>
					</ul>
				</li>
				<li class="has-children comments">
					<a href="#0">Reviewer Comments</a>

					<ul>
						<li><a href="index.php?add_review">Add Review</a></li>
						<li><a href="index.php?view_all_reviews">All Reviews</a></li>
					</ul>
				</li>

				<li class="has-children comments">
					<a href="#0">Notice Periods</a>

					<ul>
						<?php if ($roleID == 1 || $roleID == 3) : ?>
							<li><a href="index.php?add_notice_period">Add Notice Period</a></li>
							<li><a href="index.php?view_all_notices">View All</a></li>
						<?php endif; ?>
						<?php if ($roleID == 2) : ?>
							<li><a href="index.php?view_all_notices">View All</a></li>
						<?php endif; ?>
					</ul>
				</li>
				<li class="cd-label">User Management</li>
				<li class="has-children bookmarks">
					<a href="#0">Users</a>
					<ul>
						<?php if ($roleID == 1 || $roleID == 3) : ?>
							<li><a href="index.php?view_all_users">View All Users</a></li>
						<?php endif; ?>
						<?php if ($roleID == 1) : ?>
							<li><a href="index.php?add_user">Add User</a></li>
						<?php endif; ?>
						<?php if ($roleID == 2) : ?>
							<li><a href="index.php?view_all_users">View All Users</a></li>
						<?php endif; ?>
					</ul>
				</li>

				<li class="has-children bookmarks">
					<a href="#0">Issues</a>
					<ul>
						<li><a href="index.php?view_all_issues">All Issues</a></li>
						<li><a href="#0">Settle Issues</a></li>
					</ul>
				</li>
			</ul>

			<ul>
				<li class="cd-label">Invoice Management</li>
				<?php if ($roleID == 1 || $roleID == 3) : ?>
					<li class="has-children bookmarks">
						<a href="index.php?attach_invoice">Attach an Invoice</a>
					</li>
				<?php endif; ?>
				<li class="has-children images">
					<a href="#0">Invoice Details</a>
				</li>
				<li class="has-children users">
					<a href="#0">Generate Report</a>
				</li>
			</ul>

			<ul>
				<li class="cd-label">Action</li>
				<li class="action-btn"><a href="#0" class="yellow-button">+ Submit an Issue</a></li>
			</ul>

		</nav>

		<div class="content-wrapper">
			<?php
			if (isset($_GET['new_contract'])) {
				include("new_contract.php");
			} else if (isset($_GET['view_contract'])) {
				// Check if the 'category_id' parameter is set
				if (isset($_GET['category_id'])) {
					$category_id = $_GET['category_id'];
					// Include JavaScript and AJAX to fetch and display 'view_contract' content for a specific category
			?>
					<div id="dynamic-content"></div>
					<script>
						$(document).ready(function() {
							$.ajax({
								type: 'GET',
								url: 'view_contract.php?category_id=<?= $category_id ?>',
								success: function(data) {
									$('#dynamic-content').html(data);
								},
								error: function() {
									$('#dynamic-content').html('<p>Error loading content.</p>');
								}
							});
						});
					</script>
			<?php
				} else {
					echo '<p>No category specified for view_contract.</p>';
				}
			} else if (isset($_GET['add_notice_period'])) {
				include("add_notice_period.php");
			} else if (isset($_GET['add_user'])) {
				include("add_user.php");
			}
			if (isset($_GET['view_all_notices'])) {
				include("view_all_notices.php");
			}
			if (isset($_GET['view_all_vendor'])) {
				include("view_all_vendor.php");
			}
			if (isset($_GET['view_all_users'])) {
				include("view_all_users.php");
			}
			if (isset($_GET['add_vendor'])) {
				include("add_vendor.php");
			}
			if (isset($_GET['edit_vendor'])) {
				include("edit_vendor.php");
			}
			if (isset($_GET['dashboard'])) {
				include("dashboard.php");
			}
			if (isset($_GET['add_review'])) {
				include("add_review.php");
			}
			if (isset($_GET['view_all_reviews'])) {
				include("view_all_reviews.php");
			}
			if (isset($_GET['view_all_issues'])) {
				include("view_all_issues.php");
			}
			if (isset($_GET['attach_invoice'])) {
				include("attach_invoice.php");
			}
			if (isset($_GET['logout'])) {
				include("logout.php");
			}
			if (isset($_GET['view_all_notifications'])) {
				include("view_all_notifications.php");
			}

			?>
		</div> <!-- .content-wrapper -->
	</main> <!-- .cd-main-content -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="js/jquery.menu-aim.js"></script>
	<script src="js/main.js"></script> <!-- Resource jQuery -->
	<script>
		$(function() {
			$("#datepicker").datepicker();
		});
		$(function() {
			$("#e-datepicker").datepicker();
		});
		$(document).ready(function() {
			$.ajax({
				type: 'GET',
				url: 'view_contract.php?category_id=<?php echo $category_id; ?>',
				success: function(data) {
					console.log(data); // Log the received data to the console
					$('#dynamic-content').html(data);
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText); // Log any errors to the console
				}
			});
		});
	</script>
</body>

</html>
