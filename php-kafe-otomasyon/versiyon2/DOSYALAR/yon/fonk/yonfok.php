<?php 
$vt = new mysqli("localhost","root","","siparis") or die ("Bağlanamadı");
$vt->set_charset("utf8");

class yonetim {
	
	protected $aktar1,$aktar2;
	
	
	
	private function uyari ($tip,$metin,$sayfa) {
		
		echo '<div class="alert alert-'.$tip.' mt-5">'.$metin.'</div>';
		header('refresh:2,url='.$sayfa.'');
		
	} // uyarı
	
	private function genelsorgu ($dv,$sorgu) {
		
		$sorgum=$dv->prepare($sorgu);
		$sorgum->execute();				
		return $sorguson=$sorgum->get_result();
		
	} // genel sorgu
	
	
      function ciktiicinSorgu ($dv,$sorgu) {
		
		$sorgum=$dv->prepare($sorgu);
		$sorgum->execute();				
		return $sorguson=$sorgum->get_result();
		
	} // çıktı için sorgu
	
	
	function sifrele($veri) {
		
		return base64_encode(gzdeflate(gzcompress(serialize($veri))));
		
	}
	function coz($veri) {
		
		return unserialize(gzuncompress(gzinflate(base64_decode($veri))));
		
	} // şifreleme
	
	function kulad($db) {
		
		
		$id=$this->coz($_COOKIE["id"]);	
		
		$sorgu="select * from yonetim where id=$id";
		$gelensonuc=$this->genelsorgu($db,$sorgu);	
	  	$b=$gelensonuc->fetch_assoc();
		return $b["kulad"];
		
	} // kulad
	
	function cikis ($r,$deger) {
		
		
		
		$id=$this->coz($_COOKIE["id"]);	
				
		$sorgu="update yonetim set aktif=0 where id=$id";
		$sor=$r->prepare($sorgu);
		$sor->execute();	
		
	$deger=md5(sha1(md5($deger)));		
	setcookie("kul",$deger, time() - 10);
	setcookie("id",$_COOKIE["id"], time() - 10);
	$this->uyari("success","Çıkış yapılıyor","index.php");		
		
	} // cıkıs
	
	public  function giriskont($r,$k,$s) {		
		
		$sonhal=md5(sha1(md5($s)));		
		
		$sorgu="select * from yonetim where kulad='$k' and sifre='$sonhal'";
		$sor=$r->prepare($sorgu);
		$sor->execute();
		$sonbilgi=$sor->get_result();
		$veri=$sonbilgi->fetch_assoc();	
		if ($sonbilgi->num_rows==0) :			
		$this->uyari("danger","Bilgiler Hatalı","index.php");
		else:		
				
		$sorgu="update yonetim set aktif=1 where kulad='$k' and sifre='$sonhal'";
		$sor=$r->prepare($sorgu);
		$sor->execute();		
				
				
		$this->uyari("success","Giriş yapılıyor","control.php");
		
		// cookie oluşturacağız
		$kulson=md5(sha1(md5($k)));		
		setcookie("kul",$kulson, time() + 60*60*24);
		$id=$this->sifrele($veri["id"]);
		setcookie("id",$id, time() + 60*60*24);					
		endif;
	
		
	} // giris kontrol	
	
		
	public  function cookcon($d,$durum=false) {
		
		
		if (isset($_COOKIE["kul"])) :			
				$deger = $_COOKIE["kul"];
							
				$id=$this->coz($_COOKIE["id"]);	
												
				$sorgu="select * from yonetim where id=$id";
				$sor=$d->prepare($sorgu);
				$sor->execute();
				$sonbilgi=$sor->get_result();
				$veri=$sonbilgi->fetch_assoc();					
				$sonhal=md5(sha1(md5($veri["kulad"])));					
				if ($sonhal!=$_COOKIE["kul"]) :
				setcookie("kul",$deger, time() - 10 );	
				header("Location:index.php");
				else:	
				if ($durum==true) : header("Location:control.php");	endif;					
					
				endif;
		
		
		
		else:
		
		if ($durum==false) : header("Location:index.php");	endif;			
						
	
		
		endif;
		
	} // cookie kontrol
	
	function toplamgarson($vt) {		
		
		 echo $this->genelsorgu($vt,"select * from garson")->num_rows;	
		// echo $kulbilgi["kulad"];
	
	}
	
	function topurunadet($vt) {		
		$geldi=$this->genelsorgu($vt,"select SUM(adet) from anliksiparis")->fetch_assoc();		
		echo $geldi['SUM(adet)'];
		
	}
	function toplammasa($vt) {		
		 echo $this->genelsorgu($vt,"select * from masalar")->num_rows;	
		
	}
	
	function toplamkat($vt) {		
		 echo $this->genelsorgu($vt,"select * from kategori")->num_rows;	
		
	}
	function toplamurun($vt) {		
		 echo $this->genelsorgu($vt,"select * from urunler")->num_rows;	
		
	}

	function doluluk($dv) {
			
			$veriler=$this->genelsorgu($dv,"select * from doluluk")->fetch_assoc();					
			$toplam = $veriler["bos"] + $veriler["dolu"];			
		 	$oran =  ($veriler["dolu"] / $toplam) * 100 ;		
			echo $oran=substr($oran,0,5). " %";			
			
		} // istatistik
		
// ----- MASA YÖNETİM
		
	function masayon ($vt) {
		
		$so=$this->genelsorgu($vt,"select * from masalar");
		
		echo ' <table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-4 " >
    <thead>
    <tr>
    <th scope="col"><a href="control.php?islem=masaekle" class="btn btn-success">+</a> Masa Adı</th>
    <th scope="col">Güncelle</th>
    <th scope="col">Sil</th>    
    </tr>    
    </thead>
    <tbody>';
		
		while ($sonuc=$so->fetch_assoc()):
		
		echo '
    <tr>
    <td>'.$sonuc["ad"].'</td>
	<td><a href="control.php?islem=masaguncel&masaid='.$sonuc["id"].'" class="btn btn-warning">Güncelle </a></td>   
	<td><a href="control.php?islem=masasil&masaid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Masayı silmek istediğinize emin misiniz ?">Sil </a></td>        
    </tr>
    
    
   ';
		
		endwhile;
		
		echo ' </tbody>
    
    
    </table>
	
	';
		
		
		
	} // masa listele
	
	function masasil ($vt) {
		
		@$masaid=$_GET["masaid"];
		
		if ($masaid!="" && is_numeric($masaid)) :		
				$this->genelsorgu($vt,"delete from masalar where id=$masaid");
			 @$this->uyari("success","Masa Başarıyla silindi","control.php?islem=masayon");					
				
		else:
		@$this->uyari("danger","HATA OLUŞTU","control.php?islem=masayon");	
		
		endif;
		

		
	} // MASA SİL
	
	function masaguncel($vt) {
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3  table-light  text-center mx-auto mt-5 table-bordered" style="border-radius:10px; ><div class="row">';
		
		if ($buton):
		
				@$masaad=htmlspecialchars($_POST["masaad"]);
				@$masaid=htmlspecialchars($_POST["masaid"]);
				
				if ($masaad=="" || $masaid=="") :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=masayon");
				
				else:
					// veritabanı işlemleri
					
					$this->genelsorgu($vt,"update masalar set ad='$masaad' where id=$masaid");
				
					$this->uyari("success","MASA GÜNCELLENDİ","control.php?islem=masayon");
								
				endif;
		
				
		
		
		
		else:
		
		$masaid=$_GET["masaid"];
		
		$aktar=$this->genelsorgu($vt,"select * from masalar where id=$masaid")->fetch_assoc();
		
		
		echo ' 
    
    <form action="" method="post">
    
    <div class="col-md-12  border-bottom"><h4 class="mt-2">MASA GÜNCELLE</h4></div>
    
    <div class="col-md-12  text-danger mt-2"><input type="text" name="masaad" class="form-control mt-3"  value="'.$aktar["ad"].'"/></div>
    
    <div class="col-md-12 text-danger mt-2"><input name="buton" type="submit" class="btn btn-success mt-3 mb-3" /></div>
    <input type="hidden" name="masaid"  value="'.$aktar["id"].'" />
    
    </form>  
    
    ';	
		
		
		endif;
		
		echo '</div></div>';
		
		
		
	} // masa güncelleme
	
	function masaekle($vt) {
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3 table-light  text-center mx-auto mt-5 table-bordered" style="border-radius:10px;>';
		
		if ($buton):
		
				@$masaad=htmlspecialchars($_POST["masaad"]);
							
				if ($masaad=="") :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=masayon");
				
				else:
					// veritabanı işlemleri
					
					$this->genelsorgu($vt,"insert into masalar (ad) VALUES('$masaad')");
				
					$this->uyari("success","MASA EKLENDİ","control.php?islem=masayon");
								
				endif;
		
				
		
		
		
		else:		
		
		echo '     
    <form action="" method="post">
    
    <div class="col-md-12  border-bottom"><h4 class="mt-2">MASA EKLE</h4></div>
    
    <div class="col-md-12 "><input type="text" name="masaad" class="form-control mt-3" require placeholder="Masa adını yazınız" /></div>
    
    <div class="col-md-12 "><input name="buton" type="submit" class="btn btn-success mt-3 mb-3" value="EKLE" /></div>  
    </form>  
    
    ';
		
		
		
		endif;
		
		echo '</div>';
		
		
		
	} // masa ekleme		
	
// ----- MASA YÖNETİM


// ----- ÜRÜN KODLARI
	function urunyon ($vt,$tercih) {
		
		if ($tercih==1) :
		// arama kodları
		$aramabuton=$_POST["aramabuton"];
		$urun=$_POST["urun"];
		
		if ($aramabuton) :		
			$so=$this->genelsorgu($vt,"select * from urunler where ad LIKE '%$urun%'");		
		endif;
	
		
		elseif ($tercih==2) :
		
		$arama=$_POST["arama"];
		$katid=$_POST["katid"];
		
		if ($arama) :		
			$so=$this->genelsorgu($vt,"select * from urunler where katid=$katid");		
		endif;	
		
		
		elseif ($tercih==0) :		
		$so=$this->genelsorgu($vt,"select * from urunler");		
		endif;
		
		
		
		echo '<table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-4 table-dark " >
	<thead>
    <tr>
    <th >
	<form action="control.php?islem=aramasonuc" method="post">	
	<input type="search" name="urun" class="form-control" placeholder="Aranacak ÜRÜN" /></th>
	<th ><input type="submit" name="aramabuton" value="ARA" class="btn btn-danger" /></form></th>	
    <th >
	<form action="control.php?islem=katgore" method="post">
	<select name="katid" class="form-control">';
	
	$d=$this->genelsorgu($vt,"select * from kategori");
	while ($katson=$d->fetch_assoc()) :	
	echo '
	<option value="'.$katson["id"].'">'.$katson["ad"].'</option>';	
	endwhile;  
    
  echo'  </select></th>
    <th ><input type="submit" name="arama" value="GETİR" class="btn btn-danger" /></form></th>    
    </tr>    
    </thead>
    </table>';
		
		echo ' <table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-4 " >
	<thead>
    <tr>
    <th scope="col"><a href="control.php?islem=urunekle" class="btn btn-success">+</a> Ürün Adı</th>
	 <th scope="col">Ürün Fiyat</th>	
    <th scope="col">Güncelle</th>
    <th scope="col">Sil</th>    
    </tr>    
    </thead>
    <tbody>';
		
		while ($sonuc=$so->fetch_assoc()):
		
		echo '
    <tr>
    <td>'.$sonuc["ad"].'</td>
	 <td>'.$sonuc["fiyat"].'</td>
	<td><a href="control.php?islem=urunguncel&urunid='.$sonuc["id"].'" class="btn btn-warning">Güncelle </a></td>   
	<td><a href="control.php?islem=urunsil&urunid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Ürünü silmek istediğinize emin misiniz ?">Sil </a></td>        
    </tr> ';		
		endwhile;		
		echo '</tbody></table>';		
		
	} // ürün listele
	
	function urunsil ($vt) {
		
		@$urunid=$_GET["urunid"];
		
		if ($urunid!="" && is_numeric($urunid)) :	
		
		$satir=$this->genelsorgu($vt,"select * from anliksiparis where urunid=$urunid");
			
		if ($satir->num_rows!=0) :
		echo '<div class="alert alert-info mt-5">
		Bu ürün aşağıdaki masalarda mevcut;<br>';
		while ($masabilgi=$satir->fetch_assoc()) :
		$masaid=$masabilgi["masaid"];		
		$masasonuc=$this->genelsorgu($vt,"select * from masalar where id=$masaid")->fetch_assoc();				
		echo "- ".$masasonuc["ad"]."<br>";			
		endwhile;
		echo '</div>';		 
		 
		 
		 else:
		 $this->genelsorgu($vt,"delete from urunler where id=$urunid");
		 @$this->uyari("success","Ürün Başarıyla silindi","control.php?islem=urunyon");	
			
			endif;	
								
				
		else:
		@$this->uyari("danger","HATA OLUŞTU","control.php?islem=urunyon");	
		
		endif;
		

		
	} // ÜRÜN SİL	
		
	function urunguncel($vt) {
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3 table-light  text-center mx-auto mt-5 table-bordered" style="border-radius:10px;>
		<div class="row">
		';
		
		if ($buton):
		
				@$urunad=htmlspecialchars($_POST["urunad"]);
				@$urunid=htmlspecialchars($_POST["urunid"]);
				@$fiyat=htmlspecialchars($_POST["fiyat"]);
				@$katid=htmlspecialchars($_POST["katid"]);
				
				if ($urunad=="" || $urunid=="" || $katid=="" || $fiyat=="") :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=urunyon");
				
				else:
					// veritabanı işlemleri
					
		$this->genelsorgu($vt,"update urunler set ad='$urunad',fiyat=$fiyat,katid=$katid where id=$urunid");
				
		$this->uyari("success","ÜRÜN GÜNCELLENDİ","control.php?islem=urunyon");
								
				endif;
		
		else:
		
		$urunid=$_GET["urunid"];
		
		$aktar=$this->genelsorgu($vt,"select * from urunler where id=$urunid")->fetch_assoc();
		
		
		?>
    
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
    <?php
   echo ' <div class="col-md-12 table-light border-bottom"><h4 class="mt-2">ÜRÜN GÜNCELLE</h4></div>
    
    <div class="col-md-12 text-danger mt-2" >Ürün adı<input type="text" name="urunad" class="form-control mt-3"  value="'.$aktar["ad"].'"/></div>
	
	 <div class="col-md-12 text-danger mt-2">Ürün Fiyat<input type="text" name="fiyat" class="form-control mt-3"  value="'.$aktar["fiyat"].'"/></div>
	 
	  <div class="col-md-12">';
	  
	  $katid=$aktar["katid"];
	  $katcek=$this->genelsorgu($vt,"select * from kategori");
	  
	   echo 'Kategori<select name="katid" class="mt-3 form-control">';
	  
	  while ($katson=$katcek->fetch_assoc()) :
	  
	  if ($katson["id"]==$katid) : 
	  echo '<option value="'.$katson["id"].'" selected="selected">'.$katson["ad"].'</option>';
	  else:
	   echo '<option value="'.$katson["id"].'">'.$katson["ad"].'</option>';
	  endif;  
	  		 
	 
	  
	  endwhile;
	  echo 	'</select>';
	  
	 
	  
	  
	  echo'</div>
    
    <div class="col-md-12 table-light"><input name="buton" value="Güncelle" type="submit" class="btn btn-success mt-3 mb-3" /></div>
    <input type="hidden" name="urunid"  value="'.$urunid.'" />
    
    </form>  
    
    ';
		
		
		
		endif;
		
		echo '
		</div>
		</div>';
		
		
		
	} // ürün güncelleme

	function urunekle($vt) {
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3  table-light text-center mx-auto mt-5 table-bordered" style="border-radius:10px;">';
		
		if ($buton):
		
				@$urunad=htmlspecialchars($_POST["urunad"]);				
				@$fiyat=htmlspecialchars($_POST["fiyat"]);
				@$katid=htmlspecialchars($_POST["katid"]);
				
				if ($urunad=="" ||  $katid=="" || $fiyat=="") :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=urunyon");
				
				else:
					// veritabanı işlemleri
					
		$this->genelsorgu($vt,"insert into urunler (katid,ad,fiyat) VALUES($katid,'$urunad',$fiyat)");
				
		$this->uyari("success","ÜRÜN EKLENDİ","control.php?islem=urunyon");
								
				endif;
		
		else:
		
				
		?>
    
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
    <?php
   echo ' <div class="col-md-12 border-bottom"><h4 class="mt-2">ÜRÜN EKLEME</h4></div>
    
    <div class="col-md-12 text-danger mt-2">Ürün adı<input type="text" name="urunad" class="form-control mt-3" /></div>
	
	 <div class="col-md-12 text-danger mt-2">Ürün Fiyat<input type="text" name="fiyat" class="form-control mt-3" /></div>
	 
	  <div class="col-md-12 table-light">';
	  
	 
	  $katcek=$this->genelsorgu($vt,"select * from kategori");
	  
	   echo 'Kategori<select name="katid" class="mt-3 form-control">';
	  
	  while ($katson=$katcek->fetch_assoc()) :  

	   echo '<option value="'.$katson["id"].'">'.$katson["ad"].'</option>';  
	  
	  endwhile;
	  echo 	'</select>';
	  
	  echo'</div>
    
    <div class="col-md-12 table-light"><input name="buton" value="EKLE" type="submit" class="btn btn-success mt-3 mb-3" /></div>  
    
    </form>  
    
    ';		
		endif;
		
		echo '</div>';
		
		
		
	} // ürün ekleme

// ----- ÜRÜN KODLARI

// ----- KATEGORİ KODLARI
	
	function kategoriyon ($vt) {
		
		$so=$this->genelsorgu($vt,"select * from kategori");
		
		echo ' <table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-4 " >
    <thead>
    <tr>
    <th scope="col"><a href="control.php?islem=katekle" class="btn btn-success">+</a> Kategori Adı</th>
    <th scope="col">Güncelle</th>
    <th scope="col">Sil</th>    
    </tr>    
    </thead>
    <tbody>';
		
		while ($sonuc=$so->fetch_assoc()):
		
		echo '
    <tr>
    <td>'.$sonuc["ad"].'</td>
	<td><a href="control.php?islem=katguncel&katid='.$sonuc["id"].'" class="btn btn-warning">Güncelle </a></td>   
	<td><a href="control.php?islem=katsil&katid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Kategoriyi silmek istediğinize emin misiniz ?" >Sil </a></td>        
    </tr>
    
    
   ';
		
		endwhile;
		
		echo ' </tbody>
    
    
    </table>';
		
		
		
	} // kategori listele
		
	function katsil ($vt) {
		
		@$katid=$_GET["katid"];
		
		if ($katid!="" && is_numeric($katid)) :		
		$this->genelsorgu($vt,"delete from kategori where id=$katid");
		@$this->uyari("success","Kategori Başarıyla silindi","control.php?islem=katyon");
		else:
		@$this->uyari("danger","HATA OLUŞTU","control.php?islem=katyon");			
		endif;		

		
	} // kategori SİL
	
	function katekle($vt) {
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3 table-light text-center mx-auto mt-5 table-bordered" style="border-radius:10px;" ><div class="row">';
		
		if ($buton):
		
				@$katad=htmlspecialchars($_POST["katad"]);
				@$mutfakdurum=htmlspecialchars($_POST["mutfakdurum"]);
							
				if ($katad=="") :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=katyon");
				
				else:
					// veritabanı işlemleri
					
					$this->genelsorgu($vt,"insert into kategori (ad,mutfakdurum) VALUES('$katad',$mutfakdurum)");
				
					$this->uyari("success","KATEGORİ EKLENDİ","control.php?islem=katyon");
								
				endif;
		
				
		
		
		
		else:		
		?>
		
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
  <?php   
   echo '      <div class="col-md-12  border-bottom"><h4 class="mt-2">KATEGORİ EKLE</h4></div>
    
    <div class="col-md-12 "><input type="text" name="katad" class="form-control mt-3" require placeholder="Kategori Adı" /></div>
	   <div class="col-md-12 ">
	   <select name="mutfakdurum" class="form-control mt-3">
	   	   
	   <option value="0">Mutfağa Uygun</option>
	   <option value="1">Mutfak Dışı</option>
	   
	   
	   </select>
	   
	   </div>
    
    <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success mt-3 mb-3" value="EKLE" /></div>  
    </form>  
    
    ';
		
		
		
		endif;
		
		echo '</div></div>';
		
		
		
	} // kategori ekleme		
			
    function katguncel($vt) {
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3 table-light  text-center mx-auto mt-5 table-bordered" 
style="border-radius:10px; ><div class="row">';
		
		if ($buton):
		
				@$katad=htmlspecialchars($_POST["katad"]);
				@$katid=htmlspecialchars($_POST["katid"]);
				@$mutfakdurum=htmlspecialchars($_POST["mutfakdurum"]);
				
				if ($katad=="" || $katid=="" ) :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=katyon");
				
				else:
					// veritabanı işlemleri
					
		$this->genelsorgu($vt,"update kategori set ad='$katad', mutfakdurum=$mutfakdurum where id=$katid");
				
		$this->uyari("success","KATEGORİ GÜNCELLENDİ","control.php?islem=katyon");
								
				endif;
		
		else:
		
		$katid=$_GET["katid"];
		
		$aktar=$this->genelsorgu($vt,"select * from kategori where id=$katid")->fetch_assoc();
		
		
			?>
    
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
    <?php
		
	
   echo '<div class="col-md-12  border-bottom"><h4 
class="mt-2">KATEGORİ GÜNCELLE</h4></div>
    

	
 <div class="col-md-12 text-danger mt-2 ">Kategori adı
<input type="text" name="katad" class="form-control mt-3"  value="'.$aktar["ad"].'"/></div>
	
 <div class="col-md-12 text-danger mt-2 ">
	  
	   <select name="mutfakdurum" class="form-control mt-3">';
	   
	   if ($aktar["mutfakdurum"]==0) :
	   
	   echo '<option value="0" selected="selected">Mutfağa Uygun</option>
			
	  <option value="1">Mutfak Dışı</option> ';
			  
		 else:
			  
		 echo ' <option value="1" selected="selected">Mutfak Dışı</option>
		 <option value="0" >Mutfağa Uygun</option>'; 
			  
	   
	   endif;
	   
	   
	   	   
	  
	   
	   
	   
	  echo '</select></div>
	
		  
    
    <div class="col-md-12 ">
	<input name="buton" value="Güncelle" type="submit" class="btn btn-success mt-3 mb-3" /></div>
	
    <input type="hidden" name="katid"  value="'.$katid.'" />
    
    </form>  
    
    ';
		
		
		
		endif;
		
		echo '
		</div>
		</div>';
		
		
		
		
		
		
		
		
	} // kategori güncelleme

// ----- KATEGORİ KODLARI	

   	function sifredegis($vt) {
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3 table-light  text-center mx-auto mt-5 table-bordered" 
style="border-radius:10px;>';
		
		if ($buton):
		
				@$eskisif=htmlspecialchars($_POST["eskisif"]);
				@$yen1=htmlspecialchars($_POST["yen1"]);
				@$yen2=htmlspecialchars($_POST["yen2"]);
							
				if ($eskisif=="" || $yen1=="" || $yen2=="" ) :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=sifdeg");
				
				else:
					// veritabanı işlemleri
						$eskisifson=md5(sha1(md5($eskisif)));
				
					
			if ($this->genelsorgu($vt,"select * from yonetim where sifre='$eskisifson'")->num_rows==0) :
	
			$this->uyari("danger","Eski Şifre HATALI","control.php?islem=sifdeg");
			
			elseif($yen1!=$yen2):
			
			$this->uyari("danger","Yeni Şifreler Uyumsuz","control.php?islem=sifdeg");
			
			else:
			
			$yenisifre=md5(sha1(md5($yen1)));	
			
			$id=$this->coz($_COOKIE["id"]);			
			$this->genelsorgu($vt,"update yonetim set sifre='$yenisifre' where id=$id");				
			$this->uyari("success","ŞİFRE DEĞİŞTİRİLDİ","control.php");
	
					
						endif;
					
				endif;
		
		else:		
		?>
		
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
  <?php   
   echo '      <div class="col-md-12 border-bottom"><h4 
class="mt-2">ŞİFRE DEĞİŞTİR</h4></div>
    
    <div class="col-md-12 "><input type="password" name="eskisif" class="form-control mt-3" require  placeholder="Eski Şifrenizi Yazın"/></div>
	   <div class="col-md-12 "><input type="password" name="yen1" class="form-control mt-3" require  placeholder="Yeni Şifre"/></div>
	      <div class="col-md-12 "><input type="password" name="yen2" class="form-control mt-3" require  placeholder="Yeni Şifre tekrar"/></div>
    
    <div class="col-md-12 "><input name="buton" type="submit" value="DEĞİŞTİR" class="btn btn-success mt-3 mb-3" /></div>  
    </form>     ';
		
		
		endif;
		
		echo '</div>';
		
		
		
	} // sifre değiştir	


	function rapor ($vt) {
		
		
		
		@$tercih=$_GET["tar"];
		
		switch ($tercih) :
		
		case "bugun":
		$this->genelsorgu($vt,"Truncate gecicimasa");
		$this->genelsorgu($vt,"Truncate geciciurun");
		$veri=$this->genelsorgu($vt,"select * from rapor where tarih=CURDATE()");
		$veri2=$this->genelsorgu($vt,"select * from rapor where tarih=CURDATE()");
	
		break;
		case "dun":
		$this->genelsorgu($vt,"Truncate gecicimasa");
		$this->genelsorgu($vt,"Truncate geciciurun");
		$veri=$this->genelsorgu($vt,"select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
		$veri2=$this->genelsorgu($vt,"select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
	
		break;
		case "hafta":
		$this->genelsorgu($vt,"Truncate gecicimasa");
		$this->genelsorgu($vt,"Truncate geciciurun");
		$veri=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
		$veri2=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
	
		break;
		case "ay":	
		$this->genelsorgu($vt,"Truncate gecicimasa");
		$this->genelsorgu($vt,"Truncate geciciurun");	
		$veri=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");		
		$veri2=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");		
		
		break;
		case "tum":
		$this->genelsorgu($vt,"Truncate gecicimasa");
		$this->genelsorgu($vt,"Truncate geciciurun");
		$veri=$this->genelsorgu($vt,"select * from rapor");
		$veri2=$this->genelsorgu($vt,"select * from rapor");
	
		break;
		
		case "tarih":
		$this->genelsorgu($vt,"Truncate gecicimasa");
		$this->genelsorgu($vt,"Truncate geciciurun");
		$tarih1=$_POST["tarih1"];
		$tarih2=$_POST["tarih2"];
		echo '<div class="alert alert-info text-center mx-auto mt-4">
		
		'.$tarih1.' - '.$tarih2.'
		
		</div>';
		$veri=$this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
		$veri2=$this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
		
		break;
		
		
		default;
		$this->genelsorgu($vt,"Truncate gecicimasa");
		$this->genelsorgu($vt,"Truncate geciciurun");
		$veri=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
		$veri2=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
	
		endswitch;
		
		
		
		
		
		
		echo ' <table  class="table text-center table-light table-bordered mx-auto mt-4  col-md-8">';
				
				
				if (@$tarih1!="" || @$tarih2!="") :
				
				echo '
				<thead>
                <tr>
                <th colspan="8"><a href="cikti.php?islem=ciktial&tar1='.$tarih1.'&tar2='.$tarih2.'" onclick="ortasayfa(this.href,\'mywindow\',\'900\',\'800\',\'yes\');return false" class="btn btn-warning m-2">ÇIKTI</a>';
				
			echo '<a href="excel.php?tar1='.$tarih1.'&tar2='.$tarih2.'" class="btn btn-info">EXCEL AKTAR</a></th>
				
				</tr>';
				
				endif;
				
				
				
				
				
				echo '			
				
                <thead>
                <tr>
                <th><a href="control.php?islem=raporyon&tar=bugun">Bugün</a></th> 
                <th><a href="control.php?islem=raporyon&tar=dun">Dün</a></th> 
                <th><a href="control.php?islem=raporyon&tar=hafta">Bu hafta</a></th> 
                <th><a href="control.php?islem=raporyon&tar=ay">Bu Ay</a></th> 
                <th><a href="control.php?islem=raporyon&tar=tum">Tüm Zamanlar</a></th> 
                <th colspan="2"><form action="control.php?islem=raporyon&tar=tarih" method="post">
				<input type="date" name="tarih1" class="form-control col-md-10">
				<input type="date" name="tarih2" class="form-control col-md-10">
				</th>  
                <th><input name="buton" type="submit" class="btn btn-danger" value="GETİR"></form></th>  
                             
                </tr>                
                </thead>
                
                <tbody>
                <tr>
                
                 <th colspan="4">
                 
                         <table class="table text-center table-bordered col-md-12 table-striped">
                         <thead>
                         <tr>
                         <th colspan="4" class="table-dark">Masa adet ve Hasılat</th>                         
                         </tr>                         
                         </thead>
                         <thead>
                         <tr class="table-danger">
                         <th colspan="2">Ad</th>   
                         <th colspan="1">Adet</th> 
                         <th colspan="1">Hasılat</th>                       
                         </tr>                         
                         </thead> <tbody>'; 
						 
						 $kilit=$this->genelsorgu($vt,"select * from gecicimasa");						 
						 if ($kilit->num_rows==0) :							 
						while ($gel=$veri->fetch_assoc()):
												
						// masa adını çekiyoruz
						$id=$gel["masaid"];
						$masaveri=$this->genelsorgu($vt,"select * from masalar where id=$id")->fetch_assoc();
						$masaad=$masaveri["ad"];
						// masa adını çekiyoruz
						
						$raporbak=$this->genelsorgu($vt,"select * from gecicimasa where masaid=$id");
						
						if ($raporbak->num_rows==0) :
						//ekleme
						
						$has=$gel["adet"] * $gel["urunfiyat"];
						$adet=$gel["adet"];
						
						$this->genelsorgu($vt,"insert into gecicimasa (masaid,masaad,hasilat,adet) VALUES($id,'$masaad',$has,$adet)");						
						else:					
						$raporson=$raporbak->fetch_assoc();
						$gelenadet=$raporson["adet"];
						$gelenhas=$raporson["hasilat"];
						
						$sonhasilat=$gelenhas + ($gel["adet"] * $gel["urunfiyat"]); 
						$sonadet=$gelenadet  + $gel["adet"];
						
	$this->genelsorgu($vt,"update gecicimasa set hasilat=$sonhasilat, adet=$sonadet where masaid=$id");
						
						//güncelleme
						
						endif;					
						
						
						endwhile;
						 
						 
						 endif;						 
						 
		$son=$this->genelsorgu($vt,"select * from gecicimasa order by hasilat desc;");			
		$toplamadet=0;
		$toplamhasilat=0;		
		
		while ($listele=$son->fetch_assoc()) :		
		
						echo '<tr>
                         <td colspan="2">'.$listele["masaad"].'</td>   
                         <td colspan="1">'.$listele["adet"].'</td> 
                         <td colspan="1">'.number_format($listele["hasilat"],2,'.','.').'</td>                       
                         </tr>   ';
						 $toplamadet += $listele["adet"];
						 $toplamhasilat +=$listele["hasilat"];
					
		endwhile;			 
						 
						 
						 
						 
						                  
                         
                        echo'
						
						<tr class="table-danger">
                         <td colspan="2">TOPLAM</td>   
                         <td colspan="1">'.$toplamadet.'</td> 
                         <td colspan="1">'.number_format($toplamhasilat,2,'.','.').'</td>                       
                         </tr>
								
						</tbody> </table> 
                 
                 
                 
                 
                 </th>  
                 
                 
                 
                 
                 
                         
                  <th colspan="4" >
                  
                   <table class="table text-center table-bordered col-md-12 table-striped">
                         <thead>
                         <tr>
                         <th colspan="4" class="table-dark">Ürün adet ve Hasılat</th>                         
                         </tr>                         
                         </thead>
                         <thead>
                         <tr class="table-danger">
                         <th colspan="2">Ad</th>   
                         <th colspan="1">Adet</th> 
                         <th colspan="1">Hasılat</th>                       
                         </tr>                         
                         </thead> <tbody>'; 
						 
						 $kilit2=$this->genelsorgu($vt,"select * from geciciurun");						 
						 if ($kilit2->num_rows==0) :							 
						while ($gel2=$veri2->fetch_assoc()):
												
						
						$id=$gel2["urunid"];
					
						$urunad=$gel2["urunad"];
						
						$raporbak=$this->genelsorgu($vt,"select * from geciciurun where urunid=$id");
						
						if ($raporbak->num_rows==0) :
						//ekleme
						
						$has=$gel2["adet"] * $gel2["urunfiyat"];
						$adet=$gel2["adet"];
						
						$this->genelsorgu($vt,"insert into geciciurun (urunid,urunad,hasilat,adet) VALUES($id,'$urunad',$has,$adet)");						
						else:					
						$raporson=$raporbak->fetch_assoc();
						$gelenadet=$raporson["adet"];
						$gelenhas=$raporson["hasilat"];
						
						$sonhasilat=$gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]); 
						$sonadet=$gelenadet  + $gel2["adet"];
						
	$this->genelsorgu($vt,"update geciciurun set hasilat=$sonhasilat, adet=$sonadet where urunid=$id");
						
						//güncelleme
						
						endif;					
						
						
						endwhile;
						 
						 
						 endif;						 
						 
		$son2=$this->genelsorgu($vt,"select * from geciciurun order by hasilat desc;");			
			
		
		while ($listele2=$son2->fetch_assoc()) :		
		
						echo '<tr>
                         <td colspan="2">'.$listele2["urunad"].'</td>   
                         <td colspan="1">'.$listele2["adet"].'</td> 
                         <td colspan="1">'.number_format($listele2["hasilat"],2,'.','.').'</td>                       
                         </tr>   ';
					
					
		endwhile;			 
						 
						 
						 
						 
						                  
                         
                        echo'</tbody> </table> 
                 
                  
                  </th>          
                </tr>
                
                </tbody>
                </table>';
		
		
	}  // RAPORLAMA BÖLÜMÜ


// ----- GARSON YÖNETİM KODLARI
	
	function garsonyon ($vt) {
		
		$so=$this->genelsorgu($vt,"select * from garson");
		
		echo ' <table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-4 " >
    <thead>
    <tr>
    <th scope="col"><a href="control.php?islem=garsonekle" class="btn btn-success">+</a> Garson Adı</th>
    <th scope="col">Güncelle</th>
    <th scope="col">Sil</th>    
    </tr>    
    </thead>
    <tbody>';
		
		while ($sonuc=$so->fetch_assoc()):
		
		echo '
    <tr>
    <td>'.$sonuc["ad"].'</td>
	<td><a href="control.php?islem=garsonguncel&garsonid='.$sonuc["id"].'" class="btn btn-warning">Güncelle </a></td>   
	<td><a href="control.php?islem=garsonsil&garsonid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Garsonu silmek istediğinize emin misiniz ?">Sil </a></td>        
    </tr>
    
    
   ';
		
		endwhile;
		
		echo ' </tbody>
    
    
    </table>';
		
		
		
	} // GARSON listele
		
	function garsonsil ($vt) {
		
		@$garsonid=$_GET["garsonid"];
		
		if ($garsonid!="" && is_numeric($garsonid)) :		
		$this->genelsorgu($vt,"delete from garson where id=$garsonid");
		@$this->uyari("success","Garson Başarıyla silindi","control.php?islem=garsonyon");
		else:
		@$this->uyari("danger","HATA OLUŞTU","control.php?islem=garsonyon");			
		endif;		

		
	} // GARSON SİL
	
	function garsonekle($vt) {
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3  table-light text-center mx-auto mt-5 table-bordered" style="border-radius:10px;">';
		
		if ($buton):
		
				@$garsonad=htmlspecialchars($_POST["garsonad"]);
				@$garsonsifre=htmlspecialchars($_POST["garsonsifre"]);
							
				if ($garsonad=="" || $garsonsifre=="") :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=garsonyon");
				
				else:
					// veritabanı işlemleri
					
					$this->genelsorgu($vt,"insert into garson (ad,sifre) VALUES('$garsonad','$garsonsifre')");
				
					$this->uyari("success","GARSON EKLENDİ","control.php?islem=garsonyon");
								
				endif;
		
				
		
		
		
		else:		
		?>
		
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
  <?php   
   echo '      <div class="col-md-12  border-bottom"><h4 class="mt-2">GARSON EKLE</h4></div>
    
    <div class="col-md-12 "><input type="text" name="garsonad" class="form-control mt-3" require placeholder="Garson Adı"/></div>
	
	 <div class="col-md-12 "><input type="text" name="garsonsifre" class="form-control mt-3" require  placeholder="Garson Şifresi"/></div>
    
    <div class="col-md-12 "><input name="buton" type="submit" class="btn btn-success mt-3 mb-3"  value="EKLE"/></div>  
    </form>  
    
    ';
		
		
		
		endif;
		
		echo '</div>';
		
		
		
	} // GARSON ekleme		
			
    function garsonguncel($vt) {
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3 table-light  text-center mx-auto mt-5 table-bordered" style="border-radius:10px;" >';
		
		if ($buton):
		
				@$garsonad=htmlspecialchars($_POST["garsonad"]);
				@$garsonsifre=htmlspecialchars($_POST["garsonsifre"]);
				
				@$garsonid=htmlspecialchars($_POST["garsonid"]);
				
				if ($garsonad=="" || $garsonsifre=="" ) :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=garsonyon");
				
				else:
					// veritabanı işlemleri
					
		$this->genelsorgu($vt,"update garson set ad='$garsonad',sifre='$garsonsifre' where id=$garsonid");
				
		$this->uyari("success","GARSON GÜNCELLENDİ","control.php?islem=garsonyon");
								
				endif;
		
		else:
		
		$garsonid=$_GET["garsonid"];
		
		$aktar=$this->genelsorgu($vt,"select * from garson where id=$garsonid")->fetch_assoc();
		
		
		?>
    
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
    <?php
   echo ' <div class="col-md-12  border-bottom"><h4 
class="mt-2">GARSON GÜNCELLE</h4></div>
    
    <div class="col-md-12  text-danger mt-2">Garson adı<input type="text" name="garsonad" class="form-control mt-3"  value="'.$aktar["ad"].'"/></div>
	
  <div class="col-md-12  text-danger mt-2">Garson Şifresi<input type="text" name="garsonsifre" class="form-control mt-3"  value="'.$aktar["sifre"].'"/></div>	
		  
    
    <div class="col-md-12 "><input name="buton" value="Güncelle" type="submit" class="btn btn-success mt-3 mb-3" /></div>
    <input type="hidden" name="garsonid"  value="'.$garsonid.'" />
    
    </form>  
    
    ';
		
		
		
		endif;
		
		echo '</div>';
		
		
		
	} // garson güncelleme
	
	function garsonper ($vt) {
		
		
		
		@$tercih=$_GET["tar"];
		
		switch ($tercih) :
		
	
		
		case "ay":	
		$this->genelsorgu($vt,"Truncate gecicigarson");
	
		$veri=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");		
		$veri2=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");		
		
		break;
		
		
		case "tarih":
		$this->genelsorgu($vt,"Truncate gecicigarson");
		$tarih1=$_POST["tarih1"];
		$tarih2=$_POST["tarih2"];
		echo '<div class="alert alert-info text-center mx-auto mt-4">
		
		'.$tarih1.' - '.$tarih2.'
		
		</div>';
		$veri=$this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
		$veri2=$this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
		
		break;
		
		
		default;
		$this->genelsorgu($vt,"Truncate gecicigarson");	
		$veri=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");		
		$veri2=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
	
		endswitch;
		
		
		
		
		
		
		echo ' <table  class="table text-center table-light table-bordered mx-auto mt-4  col-md-8">';
				
				
				if (@$tarih1!="" || @$tarih2!="") :
				
				echo '
				<thead>
                <tr>
                <th colspan="4"><a href="cikti.php?islem=garsoncikti&tar1='.$tarih1.'&tar2='.$tarih2.'" onclick="ortasayfa(this.href,\'mywindow\',\'900\',\'800\',\'yes\');return false" class="btn btn-warning m-2">ÇIKTI</a>';
				
			echo '<a href="garsonexcel.php?tar1='.$tarih1.'&tar2='.$tarih2.'" class="btn btn-info">EXCEL AKTAR</a></th>
				
				</tr>';
				
				endif;
				
				
				
				
				
				echo '			
				
                <thead>
                <tr>
				
				 <th><a href="control.php?islem=garsonper&tar=ay">Bu Ay</a></th> 
				 
				 
          
				<form action="control.php?islem=garsonper&tar=tarih" method="post">
				
                <th><input type="date" name="tarih1" class="form-control col-md-10"></th> 
                <th><input type="date" name="tarih2" class="form-control col-md-10"></th> 
               
                           
                <th><input name="buton" type="submit" class="btn btn-danger" value="GETİR" ></form></th>  
                             
                </tr>                
                </thead>
                
                <tbody>
                <tr>
                
                 <th colspan="4">
                 
                         <table class="table text-center table-bordered col-md-12 table-striped">
                       
                         <thead>
                         <tr class="bg-dark text-warning">
                         <th colspan="2">Garson Ad</th>   
                         <th colspan="2">Adet</th> 
                                             
                         </tr>                         
                         </thead> <tbody>'; 
						 
						 $kilit=$this->genelsorgu($vt,"select * from gecicigarson");						 
						 if ($kilit->num_rows==0) :							 
						while ($gel=$veri->fetch_assoc()):
												
						// garson adını çekiyoruz
						$garsonid=$gel["garsonid"];
						$masaveri=$this->genelsorgu($vt,"select * from garson where id=$garsonid")->fetch_assoc();
						$garsonad=$masaveri["ad"];
						// garson adını çekiyoruz
						
						$raporbak=$this->genelsorgu($vt,"select * from gecicigarson where garsonid=$garsonid");
						
						if ($raporbak->num_rows==0) :
						//ekleme
						
						
						$adet=$gel["adet"];
						
						$this->genelsorgu($vt,"insert into gecicigarson (garsonid,garsonad,adet) VALUES($garsonid,'$garsonad',$adet)");						
						else:					
						$raporson=$raporbak->fetch_assoc();
						$gelenadet=$raporson["adet"];
						
						
						$sonadet=$gelenadet  + $gel["adet"];
						
	$this->genelsorgu($vt,"update gecicigarson set adet=$sonadet where garsonid=$garsonid");
						
						//güncelleme
						
						endif;					
						
						
						endwhile;
						 
						
						 endif;		
						 
										 
						 
		$son=$this->genelsorgu($vt,"select * from gecicigarson order by adet desc;");			
		$toplamadet=0;
		
		
		while ($listele=$son->fetch_assoc()) :		
		
						echo '<tr>
                         <td colspan="2">'.$listele["garsonad"].'</td>   
                         <td colspan="2">'.$listele["adet"].'</td> 
                                              
                         </tr>   ';
						 $toplamadet += $listele["adet"];
						
					
		endwhile;			 
						 
						 
						 
						 
						                  
                         
                        echo'
						
						<tr class="bg-dark text-white">
                         <td colspan="2">TOPLAM</td>   
                         <td colspan="2">'.$toplamadet.'</td> 
                                               
                         </tr>
								
						</tbody> </table> 
                 
                 
                 
                 
                 </th>  
                 
                 
                 
                        
                </tr>
                
                </tbody>
                </table>';
				
				echo '</div>';
		
		
	}	
	
	

// ----- GARSON KODLARI	



// ----- YÖNETİCİ KODLARI
	
	function yoneticiayar ($vt) {
		
		$this->yetkikontrol($vt);		
		
		$so=$this->genelsorgu($vt,"select * from yonetim");
		
		echo ' <table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-4 " >
    <thead>
    <tr>
    <th scope="col"><a href="control.php?islem=yonekle" class="btn btn-success">+</a> Yönetici Adı</th>
    <th scope="col">Güncelle</th>
    <th scope="col">Sil</th>    
    </tr>    
    </thead>
    <tbody>';
		
		while ($sonuc=$so->fetch_assoc()):
		
		echo '
    <tr>
    <td>'.$sonuc["kulad"].'</td>
	<td><a href="control.php?islem=yonguncel&yonid='.$sonuc["id"].'" class="btn btn-warning">Güncelle </a></td>  ';
	
	$sonuc["yetki"]==1 ? $durum="disabled" : $durum="";
	
	
	echo'<td><a href="control.php?islem=yonsil&yonid='.$sonuc["id"].'" class="btn btn-danger '.$durum.'" data-confirm="Yöneticiyi silmek istediğinize emin misiniz ?" >Sil </a></td>  
	
	      
    </tr>';
		
		endwhile;
		
		echo ' </tbody>
    
    
    </table>';
		
		
		
	} // YÖNETİCİ listele
		
	function yonsil ($vt) {
		$this->yetkikontrol($vt);
		@$yonid=$_GET["yonid"];
		
		if ($yonid!="" && is_numeric($yonid)) :		
		$this->genelsorgu($vt,"delete from yonetim where id=$yonid");
		@$this->uyari("success","Yönetici Başarıyla silindi","control.php?islem=yonayar");
		else:
		@$this->uyari("danger","HATA OLUŞTU","control.php?islem=yonayar");			
		endif;		

		
	} // YÖNETİCİ SİL
	
	function yonekle($vt) {
		$this->yetkikontrol($vt);
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered" >';
		
		if ($buton):
		
				@$yonad=htmlspecialchars($_POST["yonad"]);
				@$yonsifre=htmlspecialchars($_POST["yonsifre"]);
				
				$yonsifre=md5(sha1(md5($yonsifre)));		
							
				if ($yonad=="" || $yonsifre=="") :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=yonayar");
				
				else:
					// veritabanı işlemleri
					
					$this->genelsorgu($vt,"insert into yonetim (kulad,sifre) VALUES('$yonad','$yonsifre')");
				
					$this->uyari("success","YÖNETİCİ EKLENDİ","control.php?islem=yonayar");
								
				endif;
		
				
		
		
		
		else:		
		?>
		
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
  <?php   
   echo '      <div class="col-md-12 table-light border-bottom"><h4>YÖNETİCİ EKLE</h4></div>
    
    <div class="col-md-12 table-light"><input type="text" name="yonad" class="form-control mt-3" require placeholder="Yönetici Adı" /></div>
	 <div class="col-md-12 table-light"><input type="text" name="yonsifre" class="form-control mt-3" require placeholder="Yönetici Şifresi" /></div>
    
    <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success mt-3 mb-3" /></div>  
    </form>  
    
    ';
		
		
		
		endif;
		
		echo '</div>';
		
		
		
	} // YÖNETİCİ ekleme		
			
    function yonguncel($vt) {
		
		$this->yetkikontrol($vt);
		
		@$buton=$_POST["buton"];
		
		echo '<div class="col-md-3  table-light text-center mx-auto mt-5 table-bordered" style="border-radius:10px;" >';
		
		if ($buton):
		
				@$yonad=htmlspecialchars($_POST["yonad"]);
				@$yonid=htmlspecialchars($_POST["yonid"]);
				
				
				
				if ($yonad=="" || $yonid=="" ) :
				$this->uyari("danger","Bilgiler boş olamaz","control.php?islem=yonayar");
				
				else:
					// veritabanı işlemleri
					
		$this->genelsorgu($vt,"update yonetim set kulad='$yonad' where id=$yonid");
				
		$this->uyari("success","YÖNETİCİ GÜNCELLENDİ","control.php?islem=yonayar");
								
				endif;
		
		else:
		
		$yonid=$_GET["yonid"];
		
		$aktar=$this->genelsorgu($vt,"select * from yonetim where id=$yonid")->fetch_assoc();
		
		
		?>
    
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
    <?php
   echo ' <div class="col-md-12  border-bottom"><h4 class="mt-2">YÖNETİCİ GÜNCELLE</h4></div>
    
    <div class="col-md-12 text-danger mt-2">Yönetici adı<input type="text" name="yonad" class="form-control mt-3"  value="'.$aktar["kulad"].'"/></div>
	

    
    <div class="col-md-12 "><input name="buton" value="Güncelle" type="submit" class="btn btn-success mt-3 mb-3" /></div>
    <input type="hidden" name="yonid"  value="'.$yonid.'" />
    
    </form>  
    
    ';
		
		
		
		endif;
		
		echo '</div>';
		
		
		
	} // YÖNETİCİ güncelleme

// ----- YÖNETİCİ KODLARI	


function linkkontrol($vt) {
	
		$id=$this->coz($_COOKIE["id"]);	
		
		$sorgu="select * from yonetim where id=$id";
		$gelensonuc=$this->genelsorgu($vt,$sorgu);	
	  	$b=$gelensonuc->fetch_assoc();
		
		if ($b["yetki"]==1) :
		
		echo '  <div class="col-md-12 bg-light p-2 pl-3 border-bottom  text-white">
                <a href="control.php?islem=yonayar" id="lk">Yönetici Ayarları</a>
                </div>';
				
		
		
		endif;
	
	
} // link kontrol

function yetkikontrol($vt) {
		$id=$this->coz($_COOKIE["id"]);			
		$sorgu="select * from yonetim where id=$id";
		$gelensonuc=$this->genelsorgu($vt,$sorgu);	
	  	$b=$gelensonuc->fetch_assoc();		
		if ($b["yetki"]==0) :				
		header("Location:control.php");		
		endif;
	
} // yetki kontrol








}

?>



	