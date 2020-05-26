#!/usr/bin/php
<?php

//Kreiranje klase poligon,koja sadrzi 2 polja i 2 funkcije

class Poligon{

public $koordinate = array();				//polje koordinata predstavlja poligon koji prosledjujemo konstruktoru pri kreiranju instance
public $obim;						

function __construct($koordinate)
{
	$this->koordinate = $koordinate;		//konstruktor inicijalizuje samo polje koordinate
}

function set_obim($obim)
{
	$this->obim=$obim;				//ovoj funkciji se prosledjuje vrednost obima poligona,koja se dalje upisuje u polje te instance
}


//funkcija racuna obim tako sto od date 2 koordinate, oduzme vrednosti x jednu od druge, kvadrira,analogno uradi za y i upise u vrednost obima

function Obim($koordinate)
{
 	$obim = 0;
 	$keys = array_keys($koordinate);			//u promenljivoj keys se cuva vrednost indeksa koordinate	

 	for($i=0;$i<count($keys);++$i)				
		{
		if($i !=count($keys)-1)
		{
		$obim += sqrt(pow(($koordinate[$i]["x"]-$koordinate[$i+1]["x"]),2) + pow(($koordinate[$i]["y"]-$koordinate[$i+1]["y"]),2));
		}
		else
		{
		$obim += sqrt(pow(($koordinate[$i]["x"]-$koordinate[0]["x"]),2) + pow(($koordinate[$i]["y"]-$koordinate[0]["y"]),2));
		}
	}
 	return $obim;

	}
}

//funkcija koja poredi dva poligona po vrednosti obima

function cmp($a,$b)
{
	if($a->obim == $b->obim)
	{
		return 0;
	}
	return ($a->obim < $b->obim) ? -1 : 1;
}

$emptyArray = array();

$poligoniJson = file_get_contents('poligoni.json');			
$poli = json_decode($poligoniJson,true);				//otvaranje json file-a, dekodiranje i upis date strukture u promenljivu poli


$brojac=0;


// prolaz kroz strukturu poli pri cemu se za svaki poligon kreira instanca klase Poligon u koju se upisuju koordinate,racuna obim, i kao takve instance ubacuju u prazan niz

foreach($poli['poligoni'] as $i){
	foreach($i as $key=>$value){
	array_push($emptyArray,new Poligon($value));
	$emptyArray[$brojac]->set_obim($emptyArray[$brojac]->Obim($value));
	++$brojac;
	
}
}

usort($emptyArray,"cmp");		//poziv sort funkcije koja sortira poligone u odnosu na vrednost obima 

//kreiranje novog json file-a u koji se upisuju sortirani poligoni 

$jason = json_encode($emptyArray);
$myfile = fopen("sortpolo.json","w");
fwrite($myfile,$jason);
fclose($myfile);




?>










