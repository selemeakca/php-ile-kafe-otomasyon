<?php

$db = new mysqli("localhost","root","","siparis")or die ("Bağlanamadı");
$db->set_charset("utf8");


class vipTema  {
	
	
			private function benimsorum($vt,$sorgu,$tercih) {
				
					$a=$sorgu;
					$b=$vt->prepare($a);
					$b->execute();
					if ($tercih==1):
					return $c=$b->get_result();				
					endif;	
					
								
					
				
				
				
			} // baba fonksiyon
		
	    function benimsorum2($vt,$sorgu,$tercih) {
				
					$a=$sorgu;
					$b=$vt->prepare($a);
					$b->execute();
					if ($tercih==1):
					return $c=$b->get_result();				
					endif;					
					
				
				
				
			}
			
		function bekleyensatir($db) {
		
		return $this->benimsorum($db,"select * from mutfaksiparis where durum=1",1)->num_rows;
		
	}
	

	
		
		function doluluk($dv) {
			
			$son=$this->benimsorum($dv,"select * from doluluk",1);
			$veriler=$son->fetch_assoc();			
			$toplam = $veriler["bos"] + $veriler["dolu"];			
		 	$oran =  ($veriler["dolu"] / $toplam) * 100 ;		
			echo $oran=substr($oran,0,4). " %";			
			
		}		
		
			function masatoplam($dv) {
				echo $this->benimsorum($dv,"select * from masalar",1)->num_rows;						
		} // masa toplam sayı
		
		function siparistoplam($dv) {
				echo $this->benimsorum($dv,"select * from anliksiparis",1)->num_rows;						
		} // masa toplam sayı
		
		// MASA DETAY FONKSİYON
		
  				function masagetir ($vt,$id) {			
				$get="select * from masalar where id=$id";			
				return $this->benimsorum($vt,$get,1);	
			
		}		
	

	// MASA DETAY FONKSİYON
	
	
	  function urungrup($db) {	
	$se="select * from kategori";
	$gelen=$this->benimsorum($db,$se,1);	
	while ($son=$gelen->fetch_assoc()) :	
	echo '<a class="btn btn-dark mt-2 text-white" sectionId="'.$son["id"].'">'.$son["ad"].'</a><br>';	
	endwhile;	
		
	}
	
	
	function garsonbak($db) {
		
		$gelen=$this->benimsorum($db,"select * from garson where durum=1",1)->fetch_assoc();
	
		if ($gelen["ad"]!="") :
		
		
		echo $gelen["ad"];
		
		echo '<a href="islemler.php?islem=cikis" class="m-3"><kbd class="bg-danger">ÇIK</kbd></a>';
		else:
		
		echo "Garson Yok";
			
			
		endif;
	
}


	function vipTemaMasalar($dv) {	
		
		
					
					$sonuc=$this->benimsorum($dv,"select * from masalar",1);
					$bos=0;
					$dolu=0;				
					while ($masason=$sonuc->fetch_assoc()) :
					
					$siparisler='select * from anliksiparis where masaid='.$masason["id"].'';
					$satir=$this->benimsorum($dv,$siparisler,1)->num_rows;
					
					if ($satir==0):
					
					
					$icon='ovalb';
					
					
					
					else:
					$icon='ovald';
					
					endif;
																
			
		$this->benimsorum($dv,$siparisler,1)->num_rows==0 ? $bos++ : $dolu++ ;	
		
		
		if ($masason["rezervedurum"]==0) :
		
		echo '<div class="col-lg-2 col-md-3 col-sm-12">  
		<a href="masadetay.php?masaid='.$masason["id"].'" id="lin"> 
		
		
					<div class="row  p-2">
					
							<div class="col-lg-12 p-2  genelCervece" id="anadiv">
							
								<div class="row">
							
<div class="col-lg-3 col-md-3  col-sm-4 pr-2 pt-1 '.$icon.'">
<span style="font-size: 25px;" class="fas fa-mug-hot"></span>

</div>
<div class="col-lg-7 col-md-6 pl-2 col-sm-4 masaad">'.$masason["ad"].'</div> ';
			
			if ($satir!=0): echo '<div class="col-lg-1 col-md-6 pl-2 col-sm-4">
			<kbd class="sipsayi float-left">'.$satir.'</kbd></div>';
			
			else:
			
			echo '<div class="col-lg-1 col-md-3 pl-2 col-sm-4"></div>';
			 endif; 
			echo'</div>
			
			<div class="row">
			<div class="col-lg-12 pt-3">
			';
			
			
					$this->dakikakontrolet($masason["saat"],$masason["dakika"]);
			     
    				echo '
					</div></div>
					
					</div></div>
					</a>
					</div>';	
		
					
					
					
					else:
					
					
					echo '
					
					<div class="col-lg-2 col-md-3 col-sm-12">  
				
		
					<div class="row  p-2">
					
							<div class="col-lg-12 p-2   genelCervece" id="anadiv">
							
								<div class="row">
							
<div class="col-lg-3 col-md-3 col-sm-4 pl-2 pr-2 pt-1 ovalr">
<span style="font-size: 25px;" class="fas fa-mug-hot"></span>

</div>
<div class="col-lg-7 col-md-6  col-sm-4 masaad">'.$masason["ad"].'</div> 
			
			<div class="col-lg-1 col-md-3 pl-2 col-sm-4"></div></div>
			
			
			
			
			<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 pt-3">
			
			<kbd class="mb-0 float-right bg-dark text-warning border border-warning" style="position:absolute;">Kişi: '.$masason["kisi"].' </kbd>
			
					</div></div>
					
					</div></div>
					</a>
					</div>
					
		
					
	';
		
		
		
		endif;		
		
		
		
				
					endwhile;
					
					$dol="update doluluk set bos=$bos, dolu=$dolu where id=1";
					$dolson=$dv->prepare($dol);
					$dolson->execute();
		
		
	}	 // masalar
	
	
	 function vipTemaUrunGrup($db) {	
	
	$gelen=$this->benimsorum($db,"select * from kategori",1);	
	while ($son=$gelen->fetch_assoc()) :
		
	echo '<a class="btn m-2 text-center kategoributon" style="color:#68d3c8;" sectionId="'.$son["id"].'">'.$son["ad"].'</a>';	
	endwhile;	
		
	} // tema2 grup
	
	
	function mutfakdakika($saat,$dakika) {
		
		
		if ($saat!=0 && $dakika!=0) :
		
		
					if ($saat<date("H")) :
					
					$deger= (60 + date("i")) - $dakika;
					
					echo $deger;
					 
			
					else:
					
							$deger =  date("i") - $dakika;				
							
							echo $deger;						
				
			
					
					endif;
		
		
		
		endif;
		
		
		
	}		
	
	function mutfakbilgi($db) {
		
		$siparisler=$this->benimsorum($db,"select * from mutfaksiparis where durum=0",1);
		
		
		$idkontrol=array();
		
		
		
		
		while ($geldiler=$siparisler->fetch_assoc()) :
		$masaid=$geldiler["masaid"];
		
		
		if (!in_array($masaid,$idkontrol)) :		
		
		$idkontrol[]=$masaid;
		
		
						$siparisler2=$this->benimsorum($db,"select * from mutfaksiparis where masaid=$masaid and durum=0",1);
			
			
						$masaad=$this->benimsorum($db,"select * from masalar where id=$masaid",1);
						$masabilgi=$masaad->fetch_assoc();
					
						echo '<div class="col-md-2 ">
		<div class="card mt-1 p-1 bg-white border-danger" style="width:15.5rem;">
		<div class="card-body">
		<h5 class="card-title text-center"><kbd class="bg-danger">Masa : '.$masabilgi["ad"].'</kbd></h5>
		<p class="card-text">
		<div class="row">
					<div class="col-md-7 mt-2 border-bottom bg-dark text-white">Ürün</div>
						<div class="col-md-5 mt-2 border-bottom bg-dark text-white">Adet</div>
				</div>		
		
		';
						
						
						while ($geldiler2=$siparisler2->fetch_assoc()) :
						
						echo '<div class="row">
						<div class="col-md-7 mt-2 border-bottom"><span class="text-danger">'; $this->mutfakdakika($geldiler2["saat"],$geldiler2["dakika"]); echo'</span> '.$geldiler2["urunad"].'</div>
						<div class="col-md-3 mt-2 border-bottom ">'.$geldiler2["adet"].'</div>
						<div class="col-md-2 mt-2 border-bottom" id="mutfaklink">
						<a sectionId="'.$geldiler2["urunid"].'" sectionId2="'.$geldiler2["masaid"].'"><i class="fas fa-check " style="color:#6C6; font-size:20px;"></i></a></div>
						</div>';
						
						
						endwhile;
		
		
		
		echo '
		
		
		</p></div></div></div>';
		
		
		endif;
		
		endwhile;
		
		
		
		
	}
	
	
	function dakikakontrolet($saat,$dakika) {
		
		
		if ($saat!=0 && $dakika!=0) :
		
		
					if ($saat<date("H")) :
					
					$deger= (60 + date("i")) - $dakika;
					
					echo '<kbd class="ml-2 mb-0 mt-2  bg-light text-danger" >'.$deger.'  dakika önce </kbd>';
					 
			
					else:
					
					$deger =  date("i") - $dakika;
					
								if ($deger==0):
								
								echo '<kbd class="ml-2 mb-0 mt-2  bg-light text-danger" >Yeni eklendi</kbd>';
								
								else:
								
									echo '<kbd class="ml-2 mb-0 mt-2  bg-light text-danger" >'.$deger.'  dakika önce </kbd>';
									
								endif;
					
					
				
			
					
					endif;
		
		
		
		endif;
		
		
		
	}		
	







}



?>