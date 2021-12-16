<?php
	define("SITE_ADDR", "http://localhost/search");
	include("./include.php");
	$site_title = 'Moteur de recherche';
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		
		<title><?php echo $site_title; ?></title>
		
		<!-- link to the stylesheets -->
		<link rel="stylesheet" type="text/css" href="./main.css"></link>
		<style>
		
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: gray;
  
}

li {
  float: left;
  padding-left:50px;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/ Change the link color to #111 (black) on hover /
li a:hover {
  background-color: #111;
}
</style>
	</head>
	
	<body>
	<nav>
			<ul >
				<li><a href="#">Home</a></li>
				<li><a href="ajouter_mot.php">Ajouter données</a></li>
				<li><a href="indexation.php">Indexation</a></li>
				<li><a href="nuage.php">Nuage</a></li>
			</ul>
		</nav>
	<?php
	session_start();
	if (isset($_SESSION["msg"]))
	{
	?>	
	<span style="color:green"><?php echo $_SESSION["msg"] ?></span>	
	<?php
	session_destroy();
	}
	?>		
		<div id="wrapper">
			
			<div id="top_header">
				<div id="nav">
					<a href="<?php echo SITE_ADDR;?>/ajouter_mot.php">Nouvelle entrée</a>
				</div>

				<div id="logo">
					<h1><a href="<?php echo SITE_ADDR;?>">Moteur de recherche</a></h1>
				</div>
			</div>

			<div id="main" class="shadow-box"><div id="content">
				
				<center>
				<form action="" method="GET" name="">
					<table>
						<tr>
							<td><input type="text" name="k" placeholder="Rechercher quelque chose" autocomplete="off"></td>
							<td><input type="submit" name="" value="Rechercher" ></td>
						</tr>
					</table>
				</form>
				</center>

				<?php

					// VÉRIFIEZ SI LES MOTS-CLÉS ONT ÉTÉ FOURNIS
					if (isset($_GET['k']) && $_GET['k'] != ''){
						
						// Nettoyer les espaces au début et à la fin 
						$k = trim($_GET['k']);

						// Créer une requête de base et une chaîne de mots
						$query_string = "SELECT * FROM search WHERE ";
						$display_words = "";

						// séparer chacun des mots-clés
						$keywords = explode(' ', $k); 
						
						foreach($keywords as $word){
							$query_string .= " keywords LIKE '%".$word."%' OR ";
							$display_words .= $word." ";
						}
						$query_string = substr($query_string, 0, strlen($query_string) - 3);

						// se connecter à la base de données
						$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

						$query = mysqli_query($conn, $query_string);
						$result_count = mysqli_num_rows($query);

						// check to see if any results were returned
						if ($result_count > 0){
							
							// display search result count to user
							echo '<br /><div class="right">le résultat trouvé dans: <b><u>'.$result_count.'</u></b> documents  </div>';
							echo 'Votre recherche pour:  <i style="color:blue">'.$display_words.'</i> <hr /><br />';

							echo '<table class="chercher">';

							// Afficher l'occurence pour chaque mot
							echo '<tr>
									<td><h3>Mots</h3></td> <td><h3>Occurences</h3></td>
							</tr>';

							foreach($keywords as $word){
								// $query_mot = "SELECT * FROM search WHERE keywords LIKE '%".$word."%'";
								// $sql = mysqli_query($conn, $query_mot);
								$query_mot = "SELECT ROUND ( sum( LENGTH(keywords) - LENGTH( REPLACE ( keywords, '".$word."', '') ) ) / LENGTH('".$word."') ) AS count FROM search";
								$sql = mysqli_query($conn, $query_mot);
								$result=mysqli_fetch_assoc($sql);
						        $mot_count = mysqli_num_rows($sql);
								if ($mot_count > 0)
								{
								echo '<tr>
									<td><h3>'.$word.'</h3></td> <td><h3>'.$result['count'].'</h3></td>
								</tr>';
								}
							}

							echo '</table>';
						}

						else
							echo 'Aucun résultat trouvé. Veuillez rechercher autre chose.';
					}
					else
						echo '';
				?>

			</div></div>

			<div id="footer">
				<div class="left">
					<a href="https://github.com/Adrabalde" target="_blank">Abdourahamane Balde</a>
				</div>
				<div class="right">
				<span>Années 2021/2022</span>
				<span>Introduction à l'hypermédia </span>	
			     </div>
				<div class="clear"></div>
			</div>

		</div>

	</body>
</html>