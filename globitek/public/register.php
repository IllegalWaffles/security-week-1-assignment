<?php
require_once('../private/initialize.php');
require_once('../private/validation_functions.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database

    // Write SQL INSERT statement
    // $sql = "";

    // For INSERT statments, $result is just true/false
    // $result = db_query($db, $sql);
    // if($result) {
    //   db_close($db);

    //   TODO redirect user to success page

    // } else {
    //   // The SQL INSERT statement failed.
    //   // Just show the error, not the form
    //   echo db_error($db);
    //   db_close($db);
    //   exit;
    // }

	$submitted;
	
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
			
			if($errorFlag){
				
				echo 'Please fix the following errors:';
				echo '<br>';
				echo '<ul>';
				
				echo $fieldBlankError?'<li> A field is blank - make sure to enter all fields':'';
				echo $tooLongValueError?'<li> A field is too long (255 chars)':'';
				
				echo $badLastNameSize?'<li> Last name must be at least 2 characters':'';
				echo $badFirstNameSize?'<li> First name must be at least 2 characters':'';
				echo $badUsernameSize?'<li> Username must be at least 8 characters':'';
				
				echo '</ul>';
				
			}
	
		}
			
		?>

		<form method="post" action="./register.php">
		  
			First name: <br>
			<input type="text" name="first_name" value= <?php echo $submitted?$firstName:""; ?>> <br>
				
			Last name: <br>
			<input type="text" name="last_name" value= <?php echo $submitted?$lastName:""; ?>> <br>
				
			Email: <br>
			<input type="text" name="email" value= <?php echo $submitted?$email:""; ?>> <br>

			Username: <br>
			<input type="text" name="username" value= <?php echo $submitted?$username:""; ?>> <br> <br>
				
			<input type="submit" name="submit" value="Submit">
		  
		</form>

	</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
