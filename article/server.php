<?php
	session_start();
	// initialize variables
	$name = "";
	$body = "";
	$id = 0;
	$edit_state = false;
	$upld = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'article');

	// if save button is clicked
	if (isset($_POST['save'])) {
		$name = $_POST['name'];
		$body = $_POST['body'];
		$target_path = "images/";
		$target = $target_path . basename($_FILES['image']['name']);
		$image = $_FILES['image']['name'];
		$query = "INSERT INTO articles (name, body, image) VALUES ('$name', '$body', '$image')";
		mysqli_query($db, $query);

		// Move uploaded image
		if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
			$upld = "Image uploaded";
		}
		else {
			$upld = "Uploading failed";
			}

		$_SESSION['msg'] = "Article saved";
		header('location: index.php'); // redirect to index page after inserting
		
	}

	// update records
	if (isset($_POST['update'])) {
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$body = mysqli_real_escape_string($db, $_POST['body']);
		$image = mysqli_real_escape_string($db, $_POST['image']);
		$id = mysqli_real_escape_string($db, $_POST['id']);

		if (move_uploaded_file($_FILES['image']['name'], $target)) {
			$upld = "Image uploaded";
		}
		else {
			$upld = "Uploading failed";
			}

		mysqli_query($db, "UPDATE articles SET name='$name', body='$body', image='$image' WHERE id=$id");

		$_SESSION['msg'] = "Updating successfully";
		header('location: index.php');
	}

	// delete records
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		mysqli_query($db, "DELETE FROM articles WHERE id=$id");
		$_SESSION['msg'] = "Record Deleted";
		header('location: index.php');
	}




	// retrieve records
	$results = mysqli_query($db, "SELECT * FROM articles");


?> 