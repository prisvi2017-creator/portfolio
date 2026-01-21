<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
 
        <meta http-equiv="X-UA-Compatible" content="IE=chrome">
        <title>Administrateur</title>
        <link rel="icon" href="images/meetdoc2.png"  >
        <link rel="stylesheet" href="style.css">
      
    </head>
    <body>
        <!--navigation-->
        <nav class="panel">
            <ul>
            <div class="logo">
            <a href="#">
                <img src="images/meetdoc.png" width="150" height="50"  alt="">
            </a>

            <div class="profile">
        <img src="images/default-avatar.png" width="180" alt="" class="image">
     <h3 class="name"><span>Kouame</span></h3>
     <p class="role"><span>Admin</span></p>
  </div>

   <li>
   <div><a href="#" >Accueil</a></div>
            </li>

            <li>
            <div><a href="patient.php">Patient</a></div>
            </li>

            <li>
            <div><a href="medecin.php">Medecin</a></div>
            </li>

            <li>
            <div><a href="consultation.php">Consultation</a></div>
            </li>

            <li>
            <div><a href="message.php">Message</a></div>
            </li>

            <li>
            <div><a href="deconnexion.php">Deconnexion</a></div>
            </li>

            </ul> 
</nav>

<div class="top">

<div class="toggle"> 
<i class="bi bi-caret-down"></i>
</div>

<div class="search">
     <label>
        <input type="text" placeholder="Que recherchez-vous?">
        <i class="bi bi-search"></i>
     </label>
   </div>

   <a href="admin.php">Admin +</a>
  
   <div class="tableau">
    <h1>Ange Panel</h1>

    <div class="box">
        <h3>Patients</h3>
        <p>nombres</p>
        <a href="#">Details</a>
    </div>

    <div class="box">
        <h3>Medecins</h3>
        <p>nombres</p>
        <a href="#">Details</a>
    </div>

    <div class="box">
        <h3>Consultations</h3>
        <p>nombres</p>
        <a href="#">Details</a>
    </div>

    <div class="box">
        <h3>Messages</h3>
        <p>nombres</p>
        <a href="#">Details</a>
    </div>


   </div>

</div>


      
<!--Fin navigation-->

          <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        </body>
        </html>