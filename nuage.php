<?php
//
$motspoids=array(
'climatiques' => 3,
'périodes' => 2,
'précipitations' => 10,
'sécheresse' => 11,
'intenses' => 4,
'vagues' => 2,
'chaleur' => 6,
'multipliées' => 6,
'dix' => 2,
'acidification' => 13,
'océans' => 12,
'développement' => 4,
'seront' => 2,
'première' => 8,
'ligne' => 2,
'notamment' => 1,
'Afrique' => 1,
'pénuries' => 1,
'eau' => 1,
'Asie' => 1,
'élévation' => 2,
'Toutefois' => 1,
'développés' => 1,
'aussi' => 1,
'touchés' => 1,
'sécheresses' => 2,
);
function indexationTEXTE ($source)
{
	$texte = file_get_contents ($source);
    $separateurs =  "’. ,…][(«»)" ;
	$tab_toks = explode($separateurs,$texte);
	return $tab_toks[0];   

} 
function indexationContenu ($contenu)
{
$tab_toks = explode(" ",$contenu);
$tab_new_mots_occurrences = array_count_values ($tab_toks);
return $tab_new_mots_occurrences;
}

//Fonction pour générer le cloud à partir des données fournies
function genererNuage( $data = array() , $minFontSize = 10, $maxFontSize = 36 )
{
	$tab_colors=array("#3087F8", "#7F814E", "#EC1E85","#14E414","#9EA0AB", "#9EA414");
		
	$minimumCount = min( array_values( $data ) );
	$maximumCount = max( array_values( $data ) );
	$spread = $maximumCount - $minimumCount;
	$cloudHTML = '';
	$cloudTags = array();
     
	$spread == 0 && $spread = 1;
	//Mélanger un tableau de manière aléatoire
	srand((float)microtime()*1000000);
	$mots = array_keys($data);
    shuffle($mots);
	
	foreach( $mots as $tag )
	{	
		$count = $data[$tag];
		
		//La couleur aléatoire
		$color=rand(0,count($tab_colors)-1); 
			
		$size = $minFontSize + ( $count - $minimumCount )
			* ( $maxFontSize - $minFontSize ) / $spread;
		$cloudTags[] ='<a style="font-size: '. 
			floor( $size ) . 
			'px' . 
			'; color:' . 
			$tab_colors[$color]. 
			'; " title="Rechercher le tag ' . 
			$tag . 
			'" href="rechercher.php?q=' . 
			urlencode($tag) .
			'">' . 
			$tag . 
			'</a>';
	}
    return join( "\n", $cloudTags ) . "\n";
}	

?>
<html>
<head>
<title>Tag Cloud</title>
        <style type="text/css">
            #tagcloud {
                width: 300px;
                background:#CFE3FF;
                color:#0066FF;
                padding: 10px;
                border: 1px solid #559DFF;
                text-align:center;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                border-radius: 4px;
            }

        </style>
</head>
     
<body>

<h1>Exemple Tag Cloud</h1>

<?php
if (isset($_POST['charger'])){
    // get all the form data
    $doc1 = isset($_POST['doc1']) ? htmlspecialchars($_POST['doc1']) : "";
    if($_FILES['fichier']['name']!="")
    {
    $fichier_name= $_FILES['fichier']['name'];
    $fichier_tmp = $_FILES["fichier"]["tmp_name"];
    move_uploaded_file($fichier_tmp, "data/".$fichier_name);

    $donnees = indexationTEXTE ("data/".$fichier_name);
    

    }
    else 
    {
    $donnees = $doc1;
    }
?>
<div id="tagcloud">
<?php echo genererNuage( indexationContenu ($donnees) ); ?>
</div>
<?php    

    
}  
else
{
?>
<div id="tagcloud">
<?php echo genererNuage( $motspoids ); ?>
</div>
<?php
    
} 
?>

<br><br><br><br>
<form action="" method="POST" name="" enctype="multipart/form-data">
					<table>
                    <tr>
                    copier/coller un text ou charger un fichier text 
  <input type="file" name="fichier" id="fichier">
                    </tr>        
						<tr>
							<td>
                          
                            <textarea id="doc1" name="doc1" rows="10" cols="80">
<?php if(isset($_POST['doc1'])) echo $_POST['doc1']; ?>
						</textarea>
                            </td>
						</tr>
							
						
						
						<tr>
							
							<td><input type="submit" name="charger" value="Charger" /></td>
						</tr>
					</table>
				</form>


</body>
</html>