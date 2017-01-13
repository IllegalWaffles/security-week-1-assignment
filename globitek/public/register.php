<?php
	require_once('../private/initialize.php');
	require_once('../private/validation_functions.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

	$submitted = null;
	
	$firstName;
	$lastName;
	$email;
	$username;
	
	// Error flags
	$errorFlag = false;
	
	$fieldBlankError = false;
	$tooLongValueError = false;
	
	$badFirstNameSize = false;
	$badLastNameSize = false;
	$badUsernameSize = false;
	$badEmailFormat = false;
	
	
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

	<div id="main-content">
		<h1>Register</h1>
		<p>Register to become a Globitek Partner.</p>

		<?php
		
		$submitted = isset($_POST["submit"]);
		
		// Was it submitted?
		if($submitted){
	
			$firstName =	$_POST["first_name"];
			$lastName =		$_POST["last_name"];
			$email = 		$_POST["email"];
			$username = 	$_POST["username"];
			
			if(is_blank($firstName) || is_blank($lastName) || is_blank($username) || is_blank($email)) {
				
				$fieldBlankError = true;
				$errorFlag = true;
				
			}

			if(strlen($firstName) > 255 || strlen($lastName) > 255 || strlen($username) > 255 || strlen($email) > 255){
				
				$tooLongValueError = true;
				$errorFlag = true;
				
			}
			
			if(!has_length($firstName, array(2,255))){
				
				$badFirstNameSize = true;
				$errorFlag = true;
				
			}
			
			if(!has_length($lastName, array(2,255))){
				
				$badLastNameSize = true;
				$errorFlag = true;
				
			}
			
			if(!has_length($username, array(8,255))){
				
				$badUsernameSize = true;
				$errorFlag = true;
				
			}
			
			if(!has_valid_email_format($email)){
				
				$badEmailFormat = true;
				$errorFlag = true;
				
			}
			
			// If there are any errors, don't mess with the SQL. 
			// Display error feedback instead.
			if($errorFlag){
				
				echo 'Please fix the following errors:';
				echo '<br>';
				echo '<ul>';
				
				echo $fieldBlankError?'<li> A field is blank - make sure to enter all fields':'';
				echo $tooLongValueError?'<li> A field is too long (255 chars)':'';
				
				echo $badLastNameSize?'<li> Last name must be at least 2 characters':'';
				echo $badFirstNameSize?'<li> First name must be at least 2 characters':'';
				echo $badUsernameSize?'<li> Username must be at least 8 characters':'';
				echo $badEmailFormat?'<li> Email is not of proper format':'';
				
				echo '</ul>';
				
			}else{
			// No errors. Everything is fine, insert into database, and redirect to confirmation page.
				// Write SQL INSERT statement

				$date = date('Y-m-d H:i:s');
				
				if(!$stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, username, created_at) VALUES (?, ?, ?, ?, ?)")){
					
					echo "Prepare failed: (" . $db->errno . ") " . $db->error;
					
				}
				
				if(!$stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $date)){
					
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
					
				}
				
				
				// For INSERT statments, $result is just true/false
				$result = $stmt->execute();
				if($result) {
					
					db_close($db);
				
					header('Location: registration_success.php');
					exit;
				  
				} else {
					// The SQL INSERT statement failed.
					// Just show the error, not the form
					
					echo db_error($db);
					db_close($db);
					exit;
					
				}
				
			}
	
		}
			
		?>

		<form method="post" action="./register.php">
		  
			First name: <br>
			<input type="text" name="first_name" value= <?php echo $submitted?h($firstName):""; ?>> <br>
				
			Last name: <br>
			<input type="text" name="last_name" value= <?php echo $submitted?h($lastName):""; ?>> <br>
				
			Email: <br>
			<input type="text" name="email" value= <?php echo $submitted?h($email):""; ?>> <br>

			Username: <br>
			<input type="text" name="username" value= <?php echo $submitted?h($username):""; ?>> <br> <br>
				
			<input type="submit" name="submit" value="Submit">
		  
		</form>

	</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
