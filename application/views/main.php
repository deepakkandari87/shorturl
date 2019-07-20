<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Main</title>
	
</head>
<body>

<div id="container">
	<h3>All Short urls</h3>
	<?php 
	if(!empty($result)) {
		foreach ($result as $value) {
			?>
			<a href="<?php echo base_url() . $value['code']; ?>" target="_blank"><?php echo base_url() . $value['code']; ?></a> <br>
			<?php
		}
	}
	?>
	
</div>

</body>
</html>