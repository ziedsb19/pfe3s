<?php include('verif_add.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Add user</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Ajouter utilisateur</h2>
  </div>
	
  <form method="post">
  	
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>" required>
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>" required>
  	</div>
  	<div class="input-group">
  	  <label>Mot de passe</label>
  	  <input type="password" name="password_1" required>
  	</div>
  	<div class="input-group">
  	  <label>Confirmer Mot de passe</label>
  	  <input type="password" name="password_2" required>
  	</div>
  	<div class="input-group">
		<button type="submit" class="btn" name="reg_user">Ajouter</button>
		<button class="btn btn-primary" type="reset">Annuler</button>
  	</div>
  </form>
</body>
</html>