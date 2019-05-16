<?php include('server.php'); 

	// fetch the record to be updated
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;
		$rec = mysqli_query($db, "SELECT * FROM articles WHERE id=$id");
		$record = mysqli_fetch_array($rec);
		$name = $record['name'];
		$body = $record['body'];
		$image = $record['image'];
		$id = $record['id']; 

	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Article</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<?php if (isset($_SESSION['msg'])): ?>
		<div class="msg">
			<?php
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			?>
		</div>
	<?php endif ?>


	<form method="post" action="server.php" enctype="multipart/form-data">
	<input type="hidden" name="size" value="100000">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="input-group">
			<label>Create News Article</label><br><br>
		</div>
		<div class="input-group">
			<input type="text" name="name" placeholder="*Title" value="<?php echo $name; ?>" required>
		</div>

		<div class="input-group">
			<label>Body</label>
			<textarea type="text" name="body"><?php echo $body;?></textarea>
		</div>
		<div class="input-group">
			<label>Headline image</label>
		</div>
		<div>
			<input type="file" name="image">  <br><br>
		</div>
		<div class="input-group">	
		<?php if ($edit_state == false): ?> <br>
			<button type="submit" name="save" class="btn">Submit</button>
		<?php else: ?>
			<button type="submit" name="update" class="btn">Update</button>
		<?php endif ?>
		</div>
	</form>


	<table>
		<thead>
			<tr>
				<th>Article List</th>
				<th>Filter by</th>
				<th colspan="2"><div class="input-group"><input type="text" name="valueToSearch"></div></th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = mysqli_fetch_array($results)) { ?>
				<tr>
					<td><?php echo "<div id='img_div'>";
								echo "<img style=width:100px;height:100px; src='images/".$row['image']."' >" ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><a class="edit_btn" href="index.php?edit=<?php echo $row['id']; ?>">Edit</a></td>
					<td><a class="del_btn" href="server.php?del=<?php echo $row['id']; ?>">Delete</a></td>
				</tr>	
			<?php } ?>
		</tbody>
	</table>

</body>
</html>