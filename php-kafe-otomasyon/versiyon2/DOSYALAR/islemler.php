<?php ob_start(); session_start(); 

include("fonksiyon/tema3fonk.php"); 

@$masaid=$_GET["masaid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="dosya/jqu.js"></script>
<link rel="stylesheet" href="dosya/boost.css" >
<link rel="stylesheet" href="dosya/tema3.css" >

<script>
$(document).ready(function() {	

		$('#degistirform').hide();
		$('#birlestirform').hide();
		$('#iskontoform').hide();
		$('#parcaform').hide();
		
				$('#btnn').click(function() {		
				$.ajax({			
					type : "POST",
					url :'islemler.php?islem=hesap',
					data :$('#hesapform').serialize(),			
					success: function(donen_veri){
					$('#hesapform').trigger("reset");
						window.location.reload();
					},			
				})		
			})

		$('#yakala a').click(function() {			
			var sectionId =$(this).attr('sectionId');
			var sectionId2 =$(this).attr('sectionId2');				
		$.post("islemler.php?islem=sil",{"urunid":sectionId,"masaid":sectionId2},function(post_veri){		
			window.location.reload();
			
		});			
		});			
		
		$('#degistir a').click(function() { 
	$('#birlestirform').slideUp();
	$('#degistirform').slideDown();
	
	});	
	
		$('#birlestir a').click(function() { 
	$('#degistirform').slideUp();
	$('#birlestirform').slideDown();
	
	
	});		
	
		$('#degistirbtn').click(function() {		
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=masaislem',
			data :$('#degistirformveri').serialize(),			
			success: function(donen_veri){
			$('#degistirformveri').trigger("reset");
				window.location.reload();
			},			
		})		
	});
	
		$('#birlestirbtn').click(function() {		
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=masaislem',
			data :$('#birlestirformveri').serialize(),			
			success: function(donen_veri){
			$('#birlestirformveri').trigger("reset");
				window.location.reload();
			},			
		})		
	});
	
		$('#kapa1').click(function() {		
		$('#degistirform').slideUp();	
	});
		
				
			$('#kapa2').click(function() {		
		$('#birlestirform').slideUp();	
	});
	
	
		
			$('#bildirimlink a').click(function() {	
					
			var sectionId =$(this).attr('sectionId');		
			
				
		$.post("islemler.php?islem=hazirurunsil",{"id":sectionId},function(){	
			window.location.reload();	
			$('#uy'+sectionId).hide();
			
			$("#bekleyenler").load("islemler.php?islem=garsonbilgigetir");
			
		 });			
		});		
		
		
		$('#rezervelistem a').click(function() {	
					
			var sectionId =$(this).attr('sectionId');		
			
				
		$.post("islemler.php?islem=rezervekaldir",{"id":sectionId},function(){	
			window.location.reload();	
			$('#mas'+sectionId).hide();
			
			$("#rezervelistesi").load("islemler.php?islem=rezervelistesi");
			
		 });			
		});	
		
		
	$('#iskontoAc a').click(function() { 
	
	
	$('#iskontoform').slideToggle();
	
	
	});	
	
	
			$('#iskontobtn').click(function() {
				
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=iskontoUygula',
			data :$('#iskontoForm').serialize(),			
			success: function(donen_veri){
			$('#iskontoForm').trigger("reset");
				window.location.reload();
			},			
		})		
	});
	
	
	$('#parcaHesapAc a').click(function() { 
	
	
	$('#parcaform').slideToggle();
	
	
	});	
		
		
		
		
			$('#parcabtn').click(function() {
				
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=parcaHesapOde',
			data :$('#parcaForm').serialize(),			
			success: function(donen_veri){
			$('#parcaForm').trigger("reset");
				window.location.reload();
			},			
		})		
	});
	
	
		
		
				
});


var popupWindow=null;

function ortasayfa(url,winName,w,h,scroll) {

LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;	
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;	
settings='height='+h+',	width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'

popupWindow=window.open(url,winName,settings)
	
}
</script>
<title>Restaurant Sipari?? Sistemi</title>
</head>
<body>


<?php


function benimsorum2($vt,$sorgu,$tercih) {				
					$a=$sorgu;
					$b=$vt->prepare($a);
					$b->execute();
					if ($tercih==1):
					return $c=$b->get_result();				
					endif;	
					
}

function uyari($mesaj,$renk) {	
echo '<div class="alert alert-'.$renk.' mt-4 text-center">'.$mesaj.'</div>';	
}

function formgetir($masaid,$db,$baslik,$durum,$btnvalue,$btnid,$formvalue) {
	
	
	echo '<div class="card border-success m-3 mx-auto" style="max-width:18rem;">
	<div class="card-header">'.$baslik.'</div><div class="card-body text-success">
	
	<form id="'.$formvalue.'"> 
						 
						 <input type="hidden" name="mevcutmasaid" value="'.$masaid.'" />
						 
						 <select name="hedefmasa" class="form-control">'; 
						 
						
						$masadeg=benimsorum2($db,"select * from masalar where durum=$durum",1); 
						
						while ($son = $masadeg->fetch_assoc()):
						
						if ($masaid!=$son["id"]) :
						echo '<option value="'.$son["id"].'">'.$son["ad"].'</option>';
						endif;
						
						
						
						endwhile;
						 
						 
						 
						    
                       echo'</select> <input type="button" id="'.$btnid.'" value="'.$btnvalue.'"  class="btn btn-success btn-block mt-2" /> </form></div></div>';	
	
}

function garsonbilgi($db) {
		
		$siparisler=benimsorum2($db,"select * from mutfaksiparis where durum=1 order by masaid desc",1);
		
				

				
										
						
		
			
		echo '<table class="table table-bordered table-striped bg-white text-center mt-1 anasayfaTablo p-0" id="bildirimlink">
		
		<tbody>
		<tr class="font-weight-bold">
		
		<td>MASA</td>
		<td>??R??N</td>
		<td>ADET</td>
		<td>????LEM</td>
		
		
		
		
		</tr>';
		
		while ($geldiler=$siparisler->fetch_assoc()) :
		$masaid=$geldiler["masaid"];
		
						$masaad=benimsorum2($db,"select * from masalar where id=$masaid",1);
						$masabilgi=$masaad->fetch_assoc();
						
						
				echo '	<tr>
                    
						<td class="text-center border-0 mx-auto  p-0 m-0">
						'.$masabilgi["ad"].'
						</td>
						
						<td class="text-center border-0 mx-auto  p-0 m-0">
						'.$geldiler["urunad"].'
						</td>
						
						<td class="text-center border-0 mx-auto  p-0 m-0">
						'.$geldiler["adet"].'
						</td>
						
						<td class="text-center border-0 mx-auto  p-0 m-0">
						<a class="fas fa-check  m-1 text-danger" sectionId="'.$geldiler["id"].'" style="font-size:20px;" id="uy'.$geldiler["id"].'"></a>
						</td>
						
				
									
						</tr>';		
		
		
		
		
  
  
			endwhile;
  
  
  
 echo '</tbody></table>';	
		
	}
	
	function iskontogetir($masaid) {
	
	
	echo '<div class="card border-success m-3 mx-auto" style="max-width:18rem;">
	<div class="card-header">??SKONTO UYGULA</div><div class="card-body text-success">
	
	<form id="iskontoForm"> 
						 
						 <input type="hidden" name="masaid" value="'.$masaid.'" />
						 
						 <select name="iskontoOran" class="form-control">
						 
						 <option value="5">5</option>
						 <option value="10">10</option>
						 <option value="15">15</option>
						 <option value="20">20</option>
						 <option value="25">25</option>
						 
						 </select> <input type="button" id="iskontobtn" value="UYGULA"  class="btn btn-success btn-block mt-2" /> </form></div></div>';	
	
}


	function parcagetir($masaid) {
	
	
	echo '<div class="card border-success m-3 text-center mx-auto" style="max-width:18rem;">
	<div class="card-header">PAR??A HESAP AL</div><div class="card-body text-success">
	
	<form id="parcaForm"> 
						 
						 <input type="hidden" name="masaid" value="'.$masaid.'" />
						 
						 <input type="text" name="tutar"  />
						 
									 
						 
						 <input type="button" id="parcabtn" value="??DE"  class="btn btn-success btn-block mt-2" /> </form></div></div>';	
	
} // par??a hesap




@$islem=$_GET["islem"];

switch ($islem) :

case "iskontoUygula":

$iskontoOran=$_POST["iskontoOran"];
$masaid=$_POST["masaid"];


$verilericek=benimsorum2($db,"select * from anliksiparis where masaid=$masaid",1);
			
			while($don=$verilericek->fetch_assoc()):
		  	$urunid=$don["urunid"];
			$urunhesap=($don["urunfiyat"] / 100) * $iskontoOran; // 0.50
			$sonfiyat=$don["urunfiyat"]-$urunhesap;     // 4.50
			
	benimsorum2($db,"update anliksiparis set urunfiyat=$sonfiyat where urunid=$urunid",1); 		
			
		
			endwhile;	




break;


case "parcaHesapOde":

$tutar=$_POST["tutar"];
$masaid=$_POST["masaid"];

if (!empty($tutar)) :




$verilericek=benimsorum2($db,"select * from masabakiye where masaid=$masaid",1);

	if ($verilericek->num_rows==0) :
	//insert
	benimsorum2($db,"insert into masabakiye (masaid,tutar) VALUES($masaid,$tutar)",1);

	else:
	$mevcutdeger=$verilericek->fetch_assoc();	
	$sontutar=$mevcutdeger["tutar"] + $tutar;
	benimsorum2($db,"update masabakiye set tutar=$sontutar where masaid=$masaid",1); 
	// 
		
	
	endif;
	
	
	endif;
	
			
		


break;


case "masaislem":

$mevcutmasaid=$_POST["mevcutmasaid"];
$hedefmasa=$_POST["hedefmasa"];


benimsorum2($db,"update anliksiparis set masaid=$hedefmasa where masaid=$mevcutmasaid",1); 



				 /* MASANIN DURUMUNU G??NCELLEYECE????M*/				 
				 $ekleson2=$db->prepare("update masalar set durum=0 where id=$mevcutmasaid");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU G??NCELLEYECE????M*/
				  
				  	 /* MASANIN DURUMUNU G??NCELLEYECE????M*/				 
				 $ekleson2=$db->prepare("update masalar set durum=1 where id=$hedefmasa");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU G??NCELLEYECE????M*/



break; // MASA TA??IMA

case "hesap":

		if (!$_POST):
		
		echo "Posttan gelmiyosun";
		
		else:
		
			$masaid=htmlspecialchars($_POST["masaid"]);
			
			$verilericek=benimsorum2($db,"select * from anliksiparis where masaid=$masaid",1);
			
			while($don=$verilericek->fetch_assoc()):
			$a=$don["masaid"];
			$b=$don["urunid"];
			$c=$don["urunad"];
			$d=$don["urunfiyat"];
			$e=$don["adet"];
			$garsonid=$don["garsonid"];			
			$bugun = date("Y-m-d");
			
			$raporekle="insert into rapor (masaid,garsonid,urunid,urunad,urunfiyat,adet,tarih) VALUES($a,$garsonid,$b,'$c',$d,$e,'$bugun')";
			
			$raporekles=$db->prepare($raporekle);		
			$raporekles->execute();
			endwhile;	
	
			
			$silme=$db->prepare("delete from anliksiparis where masaid=$masaid");		
			$silme->execute();
			
			
			$silme2=$db->prepare("delete from masabakiye where masaid=$masaid");		
			$silme2->execute();
			
				 /* MASANIN DURUMUNU G??NCELLEYECE????M*/				 
				 $ekleson2=$db->prepare("update masalar set durum=0 where id=$masaid");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU G??NCELLEYECE????M*/
				  
				  
				   /* MASANIN LOG KAYDI*/		
				 	 
				 $ekleson23=$db->prepare("update masalar set saat=0, dakika=0 where id=$masaid");
				 $ekleson23->execute();				 
				  /* MASANIN LOG KAYDI*/
				
				
		
		endif;

break;

case "sil":

		if (!$_POST):		
		echo "Posttan gelmiyosun";		
		else:		
		$urunid=htmlspecialchars($_POST["urunid"]);
		$masaid=htmlspecialchars($_POST["masaid"]);
			
		$sorgu="delete from anliksiparis where urunid=$urunid and masaid=$masaid";
		$silme=$db->prepare($sorgu);		
		$silme->execute();	
		
		$sorgu2="delete from mutfaksiparis where urunid=$urunid and masaid=$masaid";
		$silme2=$db->prepare($sorgu2);		
		$silme2->execute();			
		endif;

break; // S??LME

 case "goster":					
					
 
 					$id=htmlspecialchars($_GET["id"]);
 
 					
				$d=benimsorum2($db,"select * from anliksiparis where masaid=$id",1);
				
	$verilericek=benimsorum2($db,"select * from masabakiye where masaid=$id",1);
		
					
					
					if ($d->num_rows==0) :					
					uyari("Hen??z sipari?? yok","danger");
					 /* MASANIN DURUMUNU G??NCELLEYECE????M*/				 
				 $ekleson2=$db->prepare("update masalar set durum=0 where id=$id");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU G??NCELLEYECE????M*/
					
					 /* MASANIN LOG KAYDI*/		
				 	 
				 $ekleson2=$db->prepare("update masalar set saat=0, dakika=0 where id=$id");
				 $ekleson2->execute();				 
				  /* MASANIN LOG KAYDI*/
					
					
																	
					else:
					
					echo '<table class=" table table-bordered table-striped bg-white text-center ">
					<tbody>
					<tr class="font-weight-bold">
					<td  class="p-2" >??r??n Ad??</td>
					<td  class="p-2">Adet</td>
					<td  class="p-2">Tutar</td>
					<td  class="p-2">????lem</td>
					</tr>';
					$adet=0;
					$sontutar=0;
						while ($gelenson=$d->fetch_assoc()) :
						
						$tutar = $gelenson["adet"] * $gelenson["urunfiyat"];
						
						$adet +=$gelenson["adet"];
						$sontutar +=$tutar;
						$masaid=$gelenson["masaid"];
						
						
						
						echo '<tr>
						<td class="p-2">'.$gelenson["urunad"].'</td>
						<td class="p-2">'.$gelenson["adet"].'</td>
						<td class="p-2">'.number_format($tutar,2,'.',',').'</td>	
	<td id="yakala" class="p-2"><a class="btn btn-danger mt-2 text-white" sectionId="'. $gelenson["urunid"].'" sectionId2="'.$masaid.'"><i class="fas fa-trash-alt"></i></a></td>				
						</tr>';						
						endwhile;						
						echo '
						<tr class="bg-light text-dark text-center">
						<td class="font-weight-bold">TOPLAM</td>					
						<td class="font-weight-bold text-danger">'.$adet.'</td>
						<td colspan="2" class="font-weight-bold text-danger ">';
						
							if ($verilericek->num_rows!=0) :
		
							$masaninBakiyesi=$verilericek->fetch_assoc();
							
							$odenenTutar=$masaninBakiyesi["tutar"];
							$kalanTutar=$sontutar-$odenenTutar;
							
		echo '<p class="text-danger m-0 p-0"><del>'.number_format($sontutar,2,'.',','). " </del> | 
							
	<font class='text-success'>" . number_format($odenenTutar,2,'.',',')."</font>
	<font class='text-dark'><br>??denecek : ". number_format($kalanTutar,2,'.',',')."</font></p>" ;
							
							
							else:
							
							echo number_format($sontutar,2,'.',','). " TL";
		
							endif;	
						
						
						
						
						
						
						 echo'</td>
											
						</tr>					
						</tbody></table>
						
						<div class="row">
						
							
						
						
								
						
						 <div class="col-md-12">
						 <form id="hesapform"> 
						 
						 <input type="hidden" name="masaid" value="'.$masaid.'" />    
                        <input type="button" id="btnn" value="HESAP AL"  class="btn  btn-block  hesapAlbuton2"   />
				 
						 </form>	
						 
						 
							<p><a href="fisbastir.php?masaid='.$masaid.'" onclick="ortasayfa(this.href,\'mywindow\',\'350\',\'400\',\'yes\');return false" class="btn hesapAlbuton btn-block mt-1"  ><i class="fas fa-print mt-1"> F???? BASTIR & HESAP AL</i></a></p> 
						 					 
						 </div>	
						 
						 
						 	 <div class="col-md-12">
										 <div class="row">
										 		<div class="col-md-6" id="degistir"><a  class="btn islembutonlar btn-block mt-1" ><i class="fas fa-exchange-alt mt-1"> MASA De??i??tir</i></a> </div>
												 <div class="col-md-6" id="birlestir"><a  class="btn islembutonlar btn-block mt-1" ><i class="fas fa-stream mt-1"> MASA Birle??tir</i></a>  </div>
										 </div>
										 
										 
										 
										  <div class="row text-center">
										  		 <div class="col-md-12 mx-auto" id="degistirform">'; formgetir($masaid,$db,"Masa De??i??tir<span id='kapa1' class='text-danger float-right'>X</span>",0,"DE??????T??R","degistirbtn","degistirformveri"); echo'</div>
												 <div class="col-md-12" id="birlestirform">'; formgetir($masaid,$db,"Masa Birle??tir<span id='kapa2' class='text-danger float-right'>X</span>",1,"B??RLE??T??R","birlestirbtn","birlestirformveri"); echo'</div>
										 		
										  </div>
										 
								 </div>
								 
								 
								 
								 
								 
								 	 <div class="col-md-12">
									 
										 <div class="row">
										 		<div class="col-md-6" id="iskontoAc"><a  class="btn islembutonlar btn-block mt-1 " ><i class="fas fa-hand-holding-usd  mt-1 "> ??SKONTO</i></a> </div>
												 <div class="col-md-6" id="parcaHesapAc"><a  class="btn islembutonlar btn-block mt-1" ><i class="fas fa-cookie-bite mt-1"> PAR??A HESAP</i></a>  </div>
										 </div>
										 
										 
										 
										 
								  <div class="row text-center">
					 <div class="col-md-12" id="iskontoform">'; iskontogetir($masaid); echo'</div>
					<div class="col-md-12" id="parcaform">'; parcagetir($masaid); echo'</div>
										 		
										  </div>		 
										 
										 
										 
										 
									
										 
								 </div>
								 
								 
								 
								 
						 
						 					
						</div>';				
					
					endif;	 
 break; 
 
 
 case "mutfaksip":

		if (!$_POST):		
		echo "Posttan gelmiyosun";		
		else:		
		$urunid=htmlspecialchars($_POST["urunid"]);
		$masaid=htmlspecialchars($_POST["masaid"]);			
		
		$sorgu2="update mutfaksiparis set durum=1 where urunid=$urunid and masaid=$masaid";
		$silme2=$db->prepare($sorgu2);		
		$silme2->execute();			
		endif;

break; // MUTFAK S??PAR????
 
 
 case "ekle":	

 
 if ($_POST) :
 
 @$masaid=htmlspecialchars($_POST["masaid"]);
 @$urunid=htmlspecialchars($_POST["urunid"]);
 @$iskonto=htmlspecialchars($_POST["iskonto"]);
 @$adet=htmlspecialchars($_POST["adet"]);
 
 				if ($masaid=="" || $urunid=="" || $adet=="" ) :			
				uyari("Bo?? alan b??rakma","danger");								
				else:
					$d=benimsorum2($db,"select * from urunler where id=$urunid",1);
					$son=$d->fetch_assoc();				
					$urunad=$son["ad"];	
					$katid=$son["katid"];
					$urunfiyat=$son["fiyat"];
					
				  $saat=date("H");	
				  $dakika=date("i");
						
						
				
						 /* MUTFA??A B??LG?? G??NDER??L??YOR*/	
						$mutfak="select * from mutfaksiparis where urunid=$urunid and masaid=$masaid";
						$var2=benimsorum2($db,$mutfak,1);				
						
						if ($var2->num_rows!=0) :
						
						$urundizi=$var2->fetch_assoc();
						$sonadet=$adet + $urundizi["adet"];
						$islemid=$urundizi["id"];
						
						$guncel2="UPDATE mutfaksiparis set adet=$sonadet where id=$islemid";
						$guncelson2=$db->prepare($guncel2);
						$guncelson2->execute();	
							
							else:
										   
					
					$durumba=benimsorum2($db,"select * from kategori where id=$katid",1);
				 	$durumbak=$durumba->fetch_assoc();
					
									
									if ($durumbak["mutfakdurum"]==0) :
									
								benimsorum2($db,"insert into mutfaksiparis (masaid,urunid,urunad,adet,saat,dakika) VALUES ($masaid,$urunid,'$urunad',$adet,$saat,$dakika)",0);
								
								
									
									endif;
					
					 
							
							endif;
				
				 /* MUTFA??A B??LG?? G??NDER??L??YOR*/
				
				
				
				
				
						
$var=benimsorum2($db,"select * from anliksiparis where urunid=$urunid and masaid=$masaid",1);				
						
						if ($var->num_rows!=0) :
						
						$urundizi=$var->fetch_assoc();
						$sonadet=$adet + $urundizi["adet"];					
						$islemid=$urundizi["id"];
						
						
						
						
						
				 $guncelson=$db->prepare("UPDATE anliksiparis set adet=$sonadet where id=$islemid");
						$guncelson->execute();				
						uyari("ADET G??NCELLEND??","success");
						
					 /* MASANIN LOG KAYDI*/		
				 	 
			 $ekleson2=$db->prepare("update masalar set saat=$saat, dakika=$dakika where id=$masaid");
				 $ekleson2->execute();				 
				  /* MASANIN LOG KAYDI*/	
				  					
						else:
						
						
						if ($iskonto!=""):
						 //    sayi / 100 * indirim oran??
						$sonuc= ($urunfiyat / 100) * $iskonto; // 0.5
						$urunfiyat=$urunfiyat-$sonuc;
						
						endif;
						
						// garsonun idsini al??yorum
					
					$gelen=benimsorum2($db,"select * from garson where durum=1",1)->fetch_assoc();
	
					$garsonidyaz=$gelen["id"];
					// garsonun idsini al??yorum		
				
				
				 
				 /* MASANIN DURUMUNU G??NCELLEYECE????M*/				 
				 $ekleson2=$db->prepare("update masalar set durum=1 where id=$masaid");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU G??NCELLEYECE????M*/
				  
				  
				  /* MASANIN LOG KAYDI*/		
				  $saat=date("H");	
				  $dakika=date("i");	 
				 $ekleson2=$db->prepare("update masalar set saat=$saat, dakika=$dakika where id=$masaid");
				 $ekleson2->execute();				 
				  /* MASANIN LOG KAYDI*/
						
						
					 $ekle="insert into anliksiparis (masaid,garsonid,urunid,urunad,urunfiyat,adet) VALUES ($masaid,$garsonidyaz,$urunid,'$urunad',$urunfiyat,$adet)"; 
				 $ekleson=$db->prepare($ekle);
				 $ekleson->execute(); 	
					
					
					
					
				  
				  
				  
							 
					uyari("EKLEND??","success");					
						endif;
		endif;	


		else:
		uyari("HATA VAR","danger");			
 		endif;


break;

	case "urun":

					$katid=htmlspecialchars($_GET["katid"]);
					$a="select * from urunler where katid=$katid";
					$d=benimsorum2($db,$a,1);					
					while ($sonuc=$d->fetch_assoc()):					
					echo '<label class="btn  m-2 pt-4  text-center" style="margin:2px; background-color:#fff; height:80px; min-width:100px; color:#193d49;">
					<input name="urunid" type="radio" value="'.$sonuc["id"].'" />
					'.$sonuc["ad"].'
					</label>';
					endwhile;					
		break; // URUN GET??R
		
		
		
		case "kontrol":
		
		$ad=htmlspecialchars($_POST["ad"]);
		$sifre=htmlspecialchars($_POST["sifre"]);
		
		if (@$ad!="" && @$sifre!="") :
		
		
				$var=benimsorum2($db,"select * from garson where ad='$ad'  and sifre='$sifre'",1);
				
				
					if ($var->num_rows==0) :
					
						echo '<div class="alert alert-danger text-center">Bilgiler uyu??muyor</div>';
					
					else:
					
					$garson=$var->fetch_assoc();
					$garsonid=$garson["id"];
					benimsorum2($db,"update garson set durum=1 where id=$garsonid",1);
					?>
                    <script>
					window.location.reload();
					
					</script>
                    
                    <?php
					
					
					endif;
		
		
		
		
		else:
		
		echo '<div class="alert alert-danger text-center">Bo?? b??l??m b??rakma</div>';
		
		endif;
		
		
		break; // KONTROL
		
		
		case "cikis":
		benimsorum2($db,"update garson set durum=0",1);
		header("Location:index.php");				
		break;
		
		case "garsonbilgigetir":
		
		garsonbilgi($db);
		
		break; // ??IKI??
		
		
	case "hazirurunsil":
		
		
		
		if (!$_POST):		
		echo "Posttan gelmiyosun";		
		else:		
		$id=htmlspecialchars($_POST["id"]);			
		$sorgu2="delete from mutfaksiparis where id=$id";
		$silme2=$db->prepare($sorgu2);		
		$silme2->execute();			
		endif;
		
		break; // MUTFAK ??R??N S??L
		
		
	case "rezerveet":
		
		if ($_POST):		
				
		$masaid=htmlspecialchars($_POST["masaid"]);	
		$kisi=htmlspecialchars($_POST["kisi"]);	
		if ($kisi=="") :
		
		$kisi="Yok";
		endif;			
			
		
		$rezerveet=$db->prepare("update masalar set durum=1,rezervedurum=1,kisi='$kisi' where id=$masaid");		
		$rezerveet->execute();			
		endif;
		
		break; // REZERVE ET
	
		
	
	
		case "rezervelistesi":
		
		$siparisler=benimsorum2($db,"select * from masalar where rezervedurum=1",1);
		
		
		
		
		
		echo '<table class="table table-bordered table-striped bg-white table-responsive-lg border-0 text-center mt-1 anasayfaTablo p-0" id="rezervelistem">
		<tbody>
		<tr class="font-weight-bold">
		
		<td>MASA</td>
		<td>K??????</td>
		<td>????LEM</td>
		
		
		
		
		</tr>
		
		';
		
		while ($geldiler=$siparisler->fetch_assoc()) :
	
		
					
						
						
				echo '	<tr>
                    
						<td class="text-center  mx-auto  p-0 m-0">
						 '.$geldiler["ad"].'
						</td>
						
						<td class="text-center  mx-auto  p-0 m-0">
						'.$geldiler["kisi"].'
						</td>
						
						<td class="text-center  mx-auto  p-0 m-0">
						<a class="fas fa-check  m-1 text-danger" sectionId="'.$geldiler["id"].'" style="font-size:20px;" id="mas'.$geldiler["id"].'"></a>
						</td>



						
						
									
						</tr>';		
		
		
		
		
  
  
			endwhile;
  
  
  
 echo '</tbody></table>
 
';
		
		
		
		
		
		
		
		
			

		
		break;
		
		case "rezervekaldir":
		
		if ($_POST):		
			
		$id=htmlspecialchars($_POST["id"]);		
		
		$rezerveet=$db->prepare("update masalar set durum=0,rezervedurum=0,kisi='Yok' where id=$id");		
		$rezerveet->execute();				
				
		endif;
		
		break; // REZERVE L??STES??
		
		


		
		
		
endswitch;
?>
</body>
</html>