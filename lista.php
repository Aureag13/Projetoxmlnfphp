<?php

$files = scandir("xml/");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=arquivo.csv');
//header('Content-Description: File Transfer');
//header('Content-Type: application/force-download');

$resultado = fopen("php://output", "w");
$cabecalho = ['chave','numero','emitente','item','codigo','descricao','valor'];
$linhas = array();

foreach ($files as $file) {
	if(!in_array($file,[".",".."])){
		 //echo "$file <br>";
		$arquivo = "xml/".$file;
		//str_replace(".xml", "", $file);

		$xml = simplexml_load_file($arquivo);
		
		
		foreach($xml->NFe->infNFe->det as $item){
		     $novaLinha= [[
			'chave'=>str_replace("NFe", "", $xml->NFe->infNFe["Id"]),
			'numero'=>$xml->NFe->infNFe->ide->nNF,
			'emitente'=>$xml->NFe->infNFe->emit->CNPJ,
		    'item'=>$item['nItem'],
			'codigo'=>$item->prod->cProd,
			'decricao'=>$item->prod->xProd,
			'valor'=>$item->prod->vProd,
			] ];
			foreach($novaLinha as $nLinha){
				array_push($linhas, $nLinha);
			}		
		}
	}
}

fputcsv($resultado, $cabecalho,';');

foreach($linhas as $linha){
	fputcsv($resultado, $linha,';');
}

fclose($resultado);

$dir = "xml/";
$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);

foreach ( $ri as $file ) {
    $file->isDir() ?  rmdir($file) : unlink($file);
}

?>
