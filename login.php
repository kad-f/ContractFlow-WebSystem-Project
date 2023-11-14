<?php
session_start();
include("./database/config.php");

if (isset($_SESSION['logged']) != "") {
	header("Location: index.php");
}

if (isset($_POST['login'])) {
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$select = "SELECT * FROM users WHERE email='$email'";
	$result = mysqli_query($conn, $select);

	if ($result) {
		$row = mysqli_fetch_array($result);
		if ($row['password'] == $password) {
			$_SESSION['logged'] = "true";
			$_SESSION['id'] = $row['id'];
			$_SESSION['role_id'] = $row['role_id']; // Add this line to set the role_id in the session
			header("Location: dashboard.php");
		} else {
			echo "<script>alert('Incorrect Password. Please try again.');</script>";
		}
	} else {
		echo "<script>alert('Incorrect Email Id or User does not exist!');</script>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="./favicon/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="login.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<title>Login | ContractFlow</title>
</head>

<body>
	<div class="wrapper">
		<div class="container main">
			<div class="row">
				<div class="col-md-6 side-image">
					<img src="img/cd-logo.png" alt="">
					<div class="text">
						<p>Simplicity meets efficiency for seamless business success.<i>- Contract<span>Flow</span></i>
						</p>
					</div>
				</div>

				<div class="col-md-6 right">
					<form action="" method="post" name="Login_Form" class="form-signin">
						<div class="input-box">
							<header>Contract<span>Flow</span></header>
							<div class="input-field">
								<input type="email" class="input" name="email" id="email" required=""
									autocomplete="off">
								<label for="email">Email</label>
							</div>
							<div class="input-field">
								<input type="password" class="input" name="password" id="pass" required="">
								<label for="pass">Password</label>
							</div>
							<div class="input-field">
								<input class="custom-button" name="login" value="LOGIN" type="Submit">
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>