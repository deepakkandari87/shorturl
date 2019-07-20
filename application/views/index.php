<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Shortern URL</title>
</head>
<body>

<div id="container">
	<?php 
	if(!empty($result)){
		?>
		<h3>Generated Short URL is:</h3>
		<a href="<?php echo base_url() . $result['code']; ?>" target="_blank"><?php echo base_url() . $result['code']; ?></a>
		<?php
	}
	?>
	<?php 
	if(!empty($error)){
		?>
		<h4></h4>
		<?php echo $error; ?>
		<?php
	}
	?>
	<h3>Create shortern URL</h3>
	<form action="" method="post">
		Please Enter the URL: <input type="url" name="url" required> <br />
		<input type="submit" name="submit" value="Submit"> 
	</form>
	Show all short links : <a href="<?php echo base_url() . 'all-short-url';?>">All Short links</a>
</body>
</html>