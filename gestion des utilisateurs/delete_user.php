<?php include('verif_delete.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Delete user</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Supprimer utilisateur</h2>
  </div>
	
  <form method="post" action="">
  	
  	<div class="input-group">
  	  <label>Nom</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>" required>
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>" required>
  	</div>
  	<div class="input-group">
  	  <label>Id</label>
  	  <input type="number" name="id" required>
  	</div>
  	
  	<div class="input-group">
		<button type="submit" class="btn" name="reg_user">Supprimer</button>
		<button class="btn btn-primary" type="reset">Reset</button>
  	</div>
  </form>
</body>
</html>