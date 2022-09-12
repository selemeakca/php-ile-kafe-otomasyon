<?php  ob_start();  
include_once("fonk/yonfok.php"); 
include_once("fonk/temaiki.php"); 
$yokclas = new yonetim; 
$tema2 = new temadestek;
$yokclas->cookcon($vt,false);

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

<title>Restaurant Kontrol</title>

<style>
body {
height:100%;
width:100%;
position:absolute;
	
}

#lk:link, #lk:visited {
	color:#fff;
	text-decoration:none;
	font-size:18px;
	background-color:#17a2b8;
	margin:5px;
	padding:10px;
	border-radius:20px;
	padding-left:30px;
	
	

	
}
#lk:hover {
	background-color:#50b7c7;
	
}

#kivirt {
	border-radius:0px 0px 10px 0px;
	
}

</style>

<script language="javascript">

var popupWindow=null;

function ortasayfa(url,winName,w,h,scroll) {

LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;	
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;	
settings='height='+h+',	width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'

popupWindow=window.open(url,winName,settings)
	
}


$(document).ready(function() {	

	$('#anac').hide();
	
	$('a[data-confirm]').click(function(ev) { 
	
			var href=$(this).attr('href');
			
			if (!$('#dataConfirmModal').length) {
				$('body').append('<div class="modal fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">ONAY</h5></div><div class="modal-body"></div>   <div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">VAZGEÇ</button><a class="btn btn-primary" id="dataConfirmOK">SİL</a></div></div></div></div></div>');
				
				$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
				$('#dataConfirmOK').attr('href',href);
				$('#dataConfirmModal').modal({show:true});
				return false;
				
			}
	
	
	
	
	
	})
	
	
	$('#goster').click(function() { 
	
				
    $('#anac').slideToggle();
	})
	
	
});




</script>

</head>
<body>

<div class="container-fluid " >

<div class="row" style="height:550px;" id="kivirt" >
      	  <div class="col-md-2 bg-info text-white " style="font-size:20px;"  id="kivirt">
        
        	<div class="row">
                <div class="col-md-12 text-center " >
                         <span style="font-size:30px; color:#fff;">
                         <a href="control.php" style="color:#fff;"><i class="fas fa-user"></i></a>
                        </span>
                        <?php echo  $yokclas->kulad($vt); ?>
                        
                        <a href="control.php?islem=cikis">
                         <span style="font-size:20px; color:#fff;" class="float-right mt-3">
                        <i class="fas fa-share-square"></i>
                        </span></a>
                        <hr class="bg-info" />
                </div>
                
                
                
                   <a href="control.php?islem=masayon" id="lk" class="col-md-11"> <i class="fas fa-file-medical-alt"></i><span style="margin-left:10px;">Masa Yönetimi</span></a>                  
                 
                     <a href="control.php?islem=urunyon" id="lk" class="col-md-11"> <i class="fas fa-torah"></i><span style="margin-left:10px;">Ürün Yönetimi</span></a> 
                     
                     <a href="control.php?islem=katyon" id="lk" class="col-md-11">  <i class="fas fa-receipt"></i> <span style="margin-left:10px;">Kategori Yönetimi</span></a>
                     
                     
                        <a href="control.php?islem=garsonyon" id="lk" class="col-md-11"> <i class="fas fa-street-view"></i><span style="margin-left:10px;">Garson Yönetimi</span></a>
                        
                
                 <a href="control.php?islem=garsonper" id="lk" class="col-md-11"> <i class="fas fa-chart-line"></i><span style="margin-left:10px;">Garson Performans</span></a>
                     <?php  $tema2->tas2linkkontrol($vt);	 ?> 
                 
                  <a href="control.php?islem=raporyon"  id="lk" class="col-md-11"> <i class="fas fa-calculator" ></i> <span style="margin-left:10px;">Rapor Yönetimi</span></a>
            
                 <a href="control.php?islem=sifdeg" id="lk" class="col-md-11">  <i class="fas fa-sync"></i><span style="margin-left:10px;">Şifre Değiştir</span></a> 
          
            
                
                
            </div>
        
        
        
        
        
        </div>
        
        <div class="col-md-10" >
        
        
         <?php 
	
	
	@$islem=$_GET["islem"];
	
	switch ($islem) :
	
	//-----------------------------
	
	case "masayon":
	$yokclas->masayon($vt);	
	break;
	
	case "masasil":
	$yokclas->masasil($vt);	
	break;
	
	case "masaguncel":
	$yokclas->masaguncel($vt);	
	break;
	case "masaekle":
	$yokclas->masaekle($vt);	
	break;
	
	//-----------------------------	
		
	case "urunyon":
	$yokclas->urunyon($vt,0);	
	break;
	
	case "urunsil":
	$yokclas->urunsil($vt);	
	break;
	
	case "urunguncel":
	$yokclas->urunguncel($vt);	
	break;
	
	case "urunekle":
	$yokclas->urunekle($vt);	
	break;
	
	case "katgore":
	$yokclas->urunyon($vt,2);		
	break;
	case "aramasonuc":
	$yokclas->urunyon($vt,1);	
	break;
	
	
	//-----------------------------
	case "katyon":
	$yokclas->kategoriyon($vt);
	
	break;
	case "katekle":
	$yokclas->katekle($vt);
	
	break;
	case "katsil":
	$yokclas->katsil($vt);
	
	break;
	case "katguncel":
	$yokclas->katguncel($vt);
	
	break;
	
	//-----------------------------	
	case "raporyon":
	$yokclas->rapor($vt);

	break;
	
	
	
	case "sifdeg":
	
	$yokclas->sifredegis($vt);
	
	break;
	
	case "cikis":		
	$yokclas->cikis($vt,$yokclas->kulad($vt));		
	break;
	
		
	//-----------------------------	
	case "garsonyon":
	$yokclas->garsonyon($vt);
	
	break;
	case "garsonekle":
	$yokclas->garsonekle($vt);
	
	break;
	case "garsonsil":
	$yokclas->garsonsil($vt);
	
	break;
	case "garsonguncel":
	$yokclas->garsonguncel($vt);
	
	break;
	case "garsonper":
	
	$yokclas->garsonper($vt);
	
	break;
	//-----------------------------	



	case "yonayar":
	$yokclas->yoneticiayar($vt);
	
	break;
	case "yonekle":
	$yokclas->yonekle($vt);
	
	break;
	case "yonsil":
	$yokclas->yonsil($vt);
	
	break;
	case "yonguncel":
	$yokclas->yonguncel($vt);
	
	break;
	
	default;
	
?>



<div class="row mt-4"> 
        
        <div class="col-md-3">
           <div class="card border-info p-2" >                   
          <div class="card-body text-info text-center">
          <i class="fas fa-chart-bar" style="font-size:30px;"></i>
          <HR />
            <h5 class="card-title">TOPLAM SİPARİŞ</h5>
            <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->topurunadet($vt); ?></kbd></p> 
             </div>
  
			</div>
          <a class="text-white btn btn-info btn-sm" id="goster" >Tümünü Göster / Kapat</a>  
        </div>
           <div class="col-md-3">
         <div class="card border-info p-2" >  
  <div class="card-body text-info text-center">
  <i class="fas fa-percent" style="font-size:30px;"></i>
  <HR />
  
    <h5 class="card-title">DOLULUK ORANI</h5>
    <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->doluluk($vt); ?></kbd></p>
  </div>
  
</div>
        </div>    
        
         <div class="col-md-3">
         <div class="card border-info p-2" >  
  <div class="card-body text-info text-center">
   <i class="fas fa-utensils" style="font-size:30px;"></i>
 <HR />  
    <h5 class="card-title">TOPLAM MASA</h5>
    <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->toplammasa($vt); ?></kbd></p>
  </div>
  
</div>
        </div>     <div class="col-md-3">
         <div class="card border-info p-2" >  
  <div class="card-body text-info text-center">
   <i class="fas fa-wine-bottle" style="font-size:30px;"></i>
 <HR />
    <h5 class="card-title">TOPLAM ÜRÜN</h5>
    <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->toplamurun($vt); ?></kbd></p>
  </div>
  
</div>

        </div>
        		


</div>


		<div id="anac">
        
		<div class="row mt-4">             
            <div class="col-md-3">
         <div class="card border-info p-2" >  
  		<div class="card-body text-info text-center">
  		 <i class="fas fa-receipt" style="font-size:30px;"></i>
 		<HR />
   		 <h5 class="card-title">TOPLAM KATEGORİ</h5>
   		 <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->toplamkat($vt); ?></kbd></p>
  		</div>
  
		</div>
        </div> 
        
          <div class="col-md-3">
         <div class="card border-info p-2" >  
  		<div class="card-body text-info text-center">
  		 <i class="fas fa-street-view" style="font-size:30px;"></i>
 		<HR />
   		 <h5 class="card-title">TOPLAM GARSON</h5>
   		 <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->toplamgarson($vt); ?></kbd></p>
  		</div>
  
		</div>
        </div> 
        
         </div>
         
        
           
           
           
           
          
           
           
           
           
           
            </div>


			<div class="row mt-4"> 
                     <div class="col-md-6">
                     
                     	<div class="card border-info p-2" >  
                        <div class="card-body text-dark">
                         
                         <h5 class="card-title">Masa Yönetimi <a href="control.php?islem=masaekle" class="btn btn-sm text-white" style="background-color:#17a2b8;">Ekle</a> </h5>
                         <p class="card-text" style="font-size:20px;"><?php  $tema2->defmasayon($vt);	 ?> </p>
                        </div>
                  
                        </div>
                        
                        
                     
                     
                     
                     </div>
                     
             <div class="col-md-6">
                            <div class="card border-info p-2" >  
                            <div class="card-body text-dark">
                             
                             <h5 class="card-title">Ürün Yönetimi <a href="control.php?islem=urunekle" class="btn btn-sm text-white" style="background-color:#17a2b8;">Ekle</a></h5>
                             <p class="card-text" style="font-size:20px;"><?php  $tema2->defurunyon($vt,0);	 ?> </p>
                            </div>
                      
                            </div>
             </div>
            
            </div>


<?php


	endswitch;
	
	
	?>
        
        
        

        
        </div>



</div>



</div>



</body>
</html>