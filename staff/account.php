<?PHP
# Calling the header and connection file
include('homepage.php');
include('../connection.php');
?>

<div class='w3-row w3-margin'>
    <div class='w3-third w3-container w3-margin-bottom'>
        <div class='w3-container w3-blue '>
            <h4>Profile</h4>
        </div>
			<div class='w3-container w3-card-2 w3-white'>
				<p class='w3-margin-top'>Staff ID: <?PHP echo $_SESSION['staff_id']; ?></p>
				<p>Username: <?PHP echo $_SESSION['username']; ?></p>
			</div>
    </div>
</div>