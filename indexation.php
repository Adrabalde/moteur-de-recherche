<?php

$source = "data/source.txt";
indexationTEXTE ($source);

function indexationTEXTE ($source)
{
	
	// 1
	//lecture du fichier sous forme d'une seule
	//chaine de caractères
	$texte = file_get_contents ($source);
	//echo $texte;
	// 2
	//les séparateurs à enrichir pour la fragmentation du texte
	//avec le filtrage des mots <=2 et tous les les éléments vides (mots)
	$separateurs =  "’. ,…][(«»)" ;
	$tab_toks = explode($separateurs,$texte);
    $tab_toks = explode(" ",$tab_toks[0]);
    //var_dump($tab_toks);
	// 4
	//filtrage les doublons par calcule les occurrences
	$tab_new_mots_occurrences = array_count_values ($tab_toks);
    //var_dump($tab_new_mots_occurrences);
	// 5
	//ici on affihe juste les résultats du traitement précédent / ou à mettre dans  une BDD
	//on a : le nom de la source (document) et  les mots-clés_occurrences	
	
	// 6
	//affichage des traces de l'indexation en tableau/résumé
	//print_datas($source,$tab_mots_occurrences ) ;
	foreach ($tab_new_mots_occurrences  as $indice => $valeur)
	{
		echo "$indice : $valeur", '<br>';
	}

} 

?>


