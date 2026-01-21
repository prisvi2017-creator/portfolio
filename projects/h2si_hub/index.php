<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>H2SI HUB</title>
  <link rel="icon" href="images/icone.png">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <!-- Navigation -->
  <header>
    <nav>
      <div class="logo"><img src="images/H2SI Hub.png" alt=""></div>
      <ul class="menu">
        <li><a href="#">Accueil</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#guide">Guide</a></li>
        <li><a href="#contact">Contacts</a></li>
      </ul>
    </nav>
  </header>

  <!-- Section présentation -->
<section class="hero">
  <h1 class="fade-in">Bienvenue sur <span class="highlight">H2SI Hub</span></h1>
  <p class="fade-in delay">
    <strong>H2SI Hub</strong> est le centre numérique du Groupe H2SI, qui réunit en un seul espace 
    tous les services de l’entreprise.<br><br>
    Nous accompagnons les <b>étudiants</b>, les <b>agents de santé</b> et les 
    <b>clients professionnels</b> dans le domaine médical et scientifique.
  </p>

  <!-- Services sous forme de cartes -->
  <div class="services-hero fade-in delay2">
    <div class="service-card">
      <img src="images/diplome-unscreen.gif" alt="Formation">
      <h3>Formations</h3>
      <p>Nous formons des étudiants et des agents de santé en hygiène, sécurité sanitaire et environnementale.</p>
    </div>

    <div class="service-card">
      <img src="images/microscope-unscreen.gif" alt="Équipements de laboratoire">
      <h3>Équipements</h3>
      <p>Nous proposons du matériel, des réactifs et des solutions complètes pour laboratoires et hôpitaux.</p>
    </div>

    <div class="service-card">
      <img src="images/poignee-de-main-1--unscreen.gif" alt="Accompagnement">
      <h3>Accompagnement</h3>
      <p>Nous offrons un soutien professionnel aux structures médicales et hospitalières.</p>
    </div>
  </div>
</section>



  <!-- Services -->
  <section class="user fade-in delay3" id="services">
    <div class="use" onclick="this.classList.toggle('flipped')">
      <div class="card-face front">
        <img src="images/studennnt.png" alt="">
        <p>Vous êtes étudiant ?</p>
      </div>
      <div class="card-face back">
        <p>Nous formons des cadres et agents compétents en matière d’hygiène, 
          de sécurité sanitaire et environnementale.</p>
        <a href="connexion_etudiant.php">Cliquez-ici</a>
      </div>
    </div>

    <div class="use" onclick="this.classList.toggle('flipped')">
      <div class="card-face front">
        <img src="images/clientss.png" alt="">
        <p>Vous êtes client ?</p>
      </div>
      <div class="card-face back">
        <p>Nous faisons la promotion et la distribution du matériel et réactifs 
           pour laboratoires et hôpitaux.</p>
        <a href="eqconnect.php">Voir la boutique</a>
      </div>
    </div>
  </section>

  <!-- Guide -->
  <section class="guide fade-in delay4" id="guide">
    <h2>Guide d’utilisation</h2>
    <ol>
      <li>Choisissez votre profil (Étudiant ou Client).</li>
      <li>Accédez aux services correspondants via les cartes interactives.</li>
      <li>Profitez de nos formations et de nos solutions en laboratoire.</li>
    </ol>
  </section>

  <!-- Contacts -->
  <section class="contact fade-in delay5" id="contact">
    <h2>Nous contacter</h2>
    <p><b>Téléphone :</b> +225 01 61 04 52 91 / +225 27 23 41 40 33</p>
    <p><b>Email :</b> <a href="mailto:groupeh2si@gmail.com">groupeh2si@gmail.com</a></p>
    <p><b>Adresse :</b> Abidjan-Yopougon Sopim, Ancien Bel Air,<br>
       au-dessus de la pharmacie Nickibel</p>
  </section>

  <!-- Pied de page -->
  <footer>
    <p>&copy; 2025 H2SI Hub - Tous droits réservés</p>
  </footer>
</body>
</html>
