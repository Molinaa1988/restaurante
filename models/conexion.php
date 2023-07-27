<?php
class Conexion{
	public function conectar(){
		// $link = new PDO("mysql:host=zafisoft.com;dbname=zafisoft_1","zafisoft","youtube92");
		   $link = new PDO("mysql:host=localhost;dbname=restaurante","root","");
		// $link = new PDO("mysql:host=gpoaviles.com;dbname=gpoavil1_pirramar","gpoavil1_admin","h=&3Rg!XuCj2");
		return $link;
	}
}
