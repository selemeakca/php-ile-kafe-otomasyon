<?php 

include_once("fonksiyon/tema3fonk.php");
$tema3 = new vipTema; 

$veri=$tema3->benimsorum2($db,"select * from garson where durum=1",1)->num_rows;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="dosya/jqu.js"></script>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<link rel="stylesheet" href="dosya/tema3.css" >

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


<title>Restaurant Sipariş Sistemi</title>



<script>
$(document).ready(function() {
	$("#bekleyenler").load("islemler.php?islem=garsonbilgigetir");
	$("#rezervelistesi").load("islemler.php?islem=rezervelistesi");
	$("#rezerveformalan").hide();
	
	
	var deger = "<?php echo $veri; ?>";
	
	if (deger==0) {
	
	$('#girismodal').modal({
		
		
		backdrop: 'static',
		keyboard: false		
		
	})
	$('body').on('hidden.bs.modal','.modal', function() {
		
		$(this).removeData('bs.modal');
		
	});	
		
	}
	
	else {
		
	$('#girismodal').modal('hide');	
		
	}		
	
	$('#girisbak').click(function() {		
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=kontrol',
			data :$('#garsonform').serialize(),			
			success: function(donen_veri){
			$('#garsonform').trigger("reset");
				
			$('.modalcevap').html(donen_veri);	
				
			},			
		})		
	});		
	
	setInterval(function() { 
	
	window.location.reload();
	},60000);
	

	

	
	
	
	
	$("#rezerveformac").click(function() { 
	$("#rezerveformalan").show();
	// burada bişe yapacağız
	$("#rezerveformalan").animate({ 	
		opacity:'show',
		width:'show'},'fast','linear',function() {
	});
	
			
	});
	
	
	$("#rezerveformkapa").click(function() { 
	// burada bişe yapacağız
	$("#rezerveformalan").animate({ 	
		opacity:'hide',
		width:'hide'},'fast','linear',function() {
	});
			
	});
	

	
	
		$('#rezervebtn').click(function() {		
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=rezerveet',
			data :$('#rezerveform').serialize(),			
			success: function(donen_veri){
			$('#rezerveform').trigger("reset");
				
			window.location.reload();
				
			},			
		})		
	});		

	
	
	
});



</script>


</head>
<body>


<div class="container-fluid h-100">

				<div class="row justify-content-center h-100">
                <!--MASALAR -->
                
                <div class="col-lg-9">
                            <div class="row">                        
                            <?php  $tema3->vipTemaMasalar($db); ?>
                             </div>
                </div>
                
                 <!--MASALAR -->
                
                <!--SAĞ -->
                
                <div class="col-lg-3 ">
                
                			<div class="row justify-content-center h-100 sagiskelet">
                            	<div class="col-lg-12 ">
                                		<div class="row">
                                        
                                        		<div class="col-lg-12  basliklar ">
                                        <h5 class="pt-2" >MUTFAK SİPARİŞLERİ <kbd class="bg-danger"><?php  echo $tema3->bekleyensatir($db); ?></kbd></h5>
                                        		</div>
                                                
                                               	<div class="col-lg-12" id="bekleyenler">
                                        
                 
                                        
                                        <!-- MUTAFAĞIN BEKLEYEN ÜRÜNLERİ GELİYOR. -->
                                        
                                        
                                        
                                        		</div> 
                                                
                                                
                                                
                                                
                                        </div>
                                
                                
                                </div>
                                
                                <div class="col-lg-12  ">
                                
                                				<div class="row">
                                        
                                        		<div class="col-lg-12  basliklar ">
                                                   
                                        <h5 class="pt-2">REZERVASYONLAR <i id="rezerveformac"  class="fas fa-address-card  ml-1" style="font-size:2em; border-radius:10px;"></i></h5>
                                        		</div>
                                                
                                                
                                                	<div class="col-lg-12" id="rezervelistesi">
                                        
                 
                                        
                                        <!-- REZERVASYONLAR GELİYOR. -->
                                        
                                        
                                       
                                        		</div>  
                                                
                                                
                                                
                                       		 </div>
                                
                                </div>
                                
                                 <div class="col-lg-12 ">
                                 
                                 
                                 		<div class="row">
                                        
                                        		<div class="col-lg-12  basliklar ">
                                        <h5 class="pt-2">İSTATİSTİKLER</h5>
                                        		</div>
                                                
                                       	<div class="col-lg-12  basliklar ">
                                        
                                                        <div class="row basliklar">
                                                        		<div class="col-lg-8 istatistiksagcizgi">
                                                                Toplam sipariş
                                                        		</div>
                                                                
                                                                <div class="col-lg-4">
                                                                <?php $tema3->siparistoplam($db); ?>
                                                        		</div>
                                                        
                                                        </div>
                                                        
                                                        
                                                        <div class="row basliklar">
                                                        		<div class="col-lg-8 istatistiksagcizgi">
                                                                Doluluk oranı
                                                        		</div>
                                                                
                                                                <div class="col-lg-4">
                                                                <?php $tema3->doluluk($db); ?>
                                                        		</div>
                                                        
                                                        </div>
                                                        
                                                         <div class="row basliklar">
                                                        		<div class="col-lg-8 istatistiksagcizgi">
                                                                Toplam Masa
                                                        		</div>
                                                                
                                                                <div class="col-lg-4">
                                                               <?php $tema3->masatoplam($db); ?>
                                                        		</div>
                                                        
                                                        </div>
                                                        
                                                        <div class="row basliklar">
                                                        		<div class="col-lg-8 istatistiksagcizgi">
                                                                Garson
                                                        		</div>
                                                                
                                                                <div class="col-lg-4">
                                                               <?php $tema3->garsonbak($db); ?>
                                                        		</div>
                                                        
                                                        </div>
                                                        
                                                        
                              
                                        
                                        		</div>
                                                
                                                
                                                
                                       		 </div>
                                 
                                 
                                
                                
                                </div>
                            
                            
        
        
        
       						 </div>
                
                
                
                
                </div>
                <!--SAĞ -->
                
                </div>


		
        
        
</div>





<!-- The Modal -->
  <div class="modal fade" id="girismodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header text-center">
          <h4 class="modal-title">Garson Girişi</h4>
          
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        
        
         <form id="garsonform">
         
         <div class="row mx-auto text-center">
         
         
         
         		<div class="col-md-12">Garson Ad</div>
        		 <div class="col-md-12"><select name="ad" class="form-control mt-2">
                  <option value="0">Seç</option>
                  <?php
				  
				  $b=$tema3->benimsorum2($db,"select * from garson",1);
				  
				  while ($garsonlar=$b->fetch_assoc()) :
				  
				  echo '<option value="'.$garsonlar["ad"].'">'.$garsonlar["ad"].'</option>';
				  
				  endwhile;
				  
				  ?>
              
                </select></div>
        
         
        		
         
        		 <div class="col-md-12">Şifre </div>         
                <div class="col-md-12">
                <input name="sifre" type="password" class="form-control  mt-2" />                
                </div>  
                 
                
                <div class="col-md-12">
               <input type="button" id="girisbak" value="GİR" class="btn btn-info mt-4"/>                
                </div>
         
         </div>
         
         
         </form>
        </div>
        
        
         <div class="modalcevap">
          
        </div>
     
        
      </div>
    </div>
  </div>
  
  

  
  
   <div class="row " id="rezerveformalan" >
   
   
    <form id="rezerveform">
         
         <div class="row mx-auto text-center">
         
         
         
         		<div class="col-md-12 font-weight-bold p-1"><font id="rezerveformkapa" class="float-left text-danger pl-2">X</font>Masa Ad</div>
        		 <div class="col-md-12"><select name="masaid" class="form-control mt-2">
                  <option value="0">Seç</option>
                  <?php
				  
				  $b=$tema3->benimsorum2($db,"select * from masalar where durum=0 and rezervedurum=0",1);
				  
				  while ($masalar=$b->fetch_assoc()) :
				  
				  echo '<option value="'.$masalar["id"].'">'.$masalar["ad"].'</option>';
				  
				  endwhile;
				  
				  ?>
              
                </select></div>
        
         
        		
         
        		 <div class="col-md-12 font-weight-bold p-1">Kişi (Opsiyonel)</div>         
                <div class="col-md-12">
                <input name="kisi" type="text" class="form-control  mt-2" />                
                </div>  
                 
                
                <div class="col-md-12">
               <input type="button" id="rezervebtn" value="REZERVE ET" class="btn btn-info mt-4 mb-2"/>                
                </div>
         
         </div>
         
         
         </form>
   
   
   
  
  
  </div>



</body>
</html>