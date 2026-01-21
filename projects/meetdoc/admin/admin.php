<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
           
        <meta http-equiv="X-UA-Compatible" content="IE=chrome">
        <title>Administrateur</title>
        <link rel="icon" href="images/meetdoc2.png"  >
        <link rel="stylesheet" href="style.css">
      
    </head>
    <body>
        <!--navigation-->
        <nav>
            <div class="logo">
            <a href="#">
                <img src="images/meetdoc.png" width="150" height="50"  alt="">
            </a>
         
            </div>

        <div class="inscription">
  
    <form action="#" method="post">

    <label for="email">Nom:</label>
  <input type="text" id="nom" name="nom" required>

      <label for="email">Prenom:</label>
     <input type="text" id="prenom" name="prenom" required>

     <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">

     <label class="use">Type d'utilisateur:</label>
     
		  <select class="user"
		          name="role" 
		          aria-label="Default select example">
			  <option selected value="utilisateur">Utilisateur</option>
			  <option value="admin">Admin</option>
		  </select>
  
        <label for="email">E-mail :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="password">Confirmation :</label>
  <input type="password" id="password" name="confirme" required>


  <button type="submit">Inscription</button>

        
    </form>
    </div>
<!--Fin navigation-->

          <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        </body>
        </html>