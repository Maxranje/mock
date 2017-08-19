<?php

include ('mpdf.php');
$content = "hello 王学文";
$mpdf=new mPDF('UTF-8','A4','','',15,15,44,15);  
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;


$mpdf->SetDisplayMode('fullpage');


$mpdf->WriteHTML($content); 
$mpdf->Output(); 

?>