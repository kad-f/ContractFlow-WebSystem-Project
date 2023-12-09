<style>
	th {
		background-color: yellow;
		color: #000;
	}
</style>
<div id="page-wrap">
	<h1>All Notices</h1>
	<table>
		<thead>
			<tr>
				<th>S No.</th>
				<th>Contract No.</th>
				<th>Date</th>
				<th>Description</th>
				<th>Edit</th>
				<th>Remove</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Assuming you have the user's information in the session
			$user_id = $_SESSION['id'];
			$user_role_id = $_SESSION['role_id'];

			$get_notice = "SELECT contract.contract_no, contract.vendor_id, notice_period.*
						FROM notice_period
						JOIN contract ON notice_period.contract_no = contract.contract_no";

			// Check if the user is not an admin
			if ($user_role_id != 1 && $user_role_id != 3) {
				$get_notice .= " WHERE contract.vendor_id = '$user_id'";
			}

			$result_notice = mysqli_query($conn, $get_notice);
			$i = 0;

			if (mysqli_num_rows($result_notice) == 0) {
				echo "<td>No Notice Periods found.</td>";
			} else {
				while ($row_notice = mysqli_fetch_array($result_notice)) {
					$contract_num = $row_notice['contract_no'];
					$date = $row_notice['date'];
					$description = $row_notice['description'];
					$i++;
			?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $contract_num; ?></td>
						<td><?php echo $date; ?></td>
						<td><?php echo $description; ?></td>
						<td><a href="index.php?edit_notice=<?php echo $id; ?>">Edit</a></td>
						<td><a href="delete_notice.php?delete_notice=<?php echo $id; ?>">Delete</a></td>
					</tr>
			<?php
				}
			}
			?>
		</tbody>
	</table>
</div>
