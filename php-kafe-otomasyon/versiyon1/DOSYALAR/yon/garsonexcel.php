<?php

include_once("fonk/yonfonk.php");
$yonclas = new yonetim;

function excelal ( $filename = 'ExportExcel', $columns=array(),$data=array(),$toplamadet) {
   header('Content-Encoding: UTF-8');
   header('Content-Type: text/plain; charset=utf-8');
   header('Content-disposition: attachment; filename='.$filename.'.xls');
   echo "\xEF\xBB\xBF"; //bom
   
   @$tarih1 = $_GET["tar1"];
   @$tarih2 = $_GET["tar2"];
   
   $sayim = count($columns);
   
   // Başlık yazmak için
   
   echo '<table border = "1"><th style="background-color:#000000" colspan="2"><font color="#FDFDFD">'.$tarih1.' - '.$tarih2.'</font></th><tr>';
   
   foreach ($columns as $v):
       
       echo '<th style="background-color:#FFA500">'.trim($v).'</th>';
       
   endforeach;
   
   // Verileri yazmak için
   
    echo '</tr>';
    
    foreach ($data as $val):
        
        echo '<tr>';
        
            for ($i=0; $i<$sayim; $i++):
                
                echo '<td>'.$val[$i].'</td>';

            endfor;
        echo '</tr>';
  
   endforeach;
   
    echo '<tr style="background-color:#56d2ec">
        <td>TOPLAM</td>
        <td>'.$toplamadet.'</td>
        </tr>
        ';

}


$garsondizi=array();
$garsondata=array();


$garsondizi=array(
    'Garson Ad',
    'Adet'
);


                                $son = $yonclas->ciktiSorgusu($vt, "select * from gecicigarson order by adet desc;");
                                $Masatoplamadet = 0;

                                while ($listele = $son->fetch_assoc()):
                                   
                                    @$garsondata[]=array(
                                        $listele["garsonad"],
                                        $listele["adet"]                                      
                                    );
                                
                                        $Masatoplamadet += $listele["adet"];
                                endwhile;
                                
                                
                                excelal(date("d.m.Y"), $garsondizi, $garsondata, $Masatoplamadet);

?>





