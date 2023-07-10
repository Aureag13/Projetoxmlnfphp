<?php

$diretorio = "xml/";

if(!is_dir($diretorio)){
	echo "Pasta $diretorio nao encontrada!";
}else{

	$arquivo  = isset($_FILES['arquivo']) ? $_FILES['arquivo']:FALSE;

	for ($i=0; $i <count($arquivo['name']) ; $i++) { 
		$destino = $diretorio."/".$arquivo['name'][$i];
		if(move_uploaded_file($arquivo['tmp_name'][$i],$destino)){
			//echo "Upload realizado com sucesso!";
		}else{
			echo "Erro ao realizar upload!";
		}
	}

    $arquivos = glob("$diretorio{*.xml}", GLOB_BRACE);

    //echo "Total de A" . count($arquivos);
	echo "Upload de ". count($arquivos)." arquivos realizado com sucesso!<br><br>";
	echo "<a href=lista.php>Converter os XMLS em CSV <a/>";
}
	
?>