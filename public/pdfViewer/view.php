 

 


<?php
session_start(); 
// if (isset($_GET['file'])) {$file  = base64_decode($_GET ['file']); 
// }
//  else {die ("Error. No ID Selected! ");  }

$file = $_GET["file"];

// require_once("q.php"); 

// if(isset($_SESSION['nrik2'])){
// $wt1=$_SESSION['nrik2'];
// $wt2=".png";
// $wt=$wt1.$wt2;
// }

 
?>

<script> var message="OOppsss.........";
    function clickIE4(){if (event.button==2){alert(message);return false;}} 
    function clickNS4(e){if (document.layers||document.getElementById&&!document.all){if (e.which==2||e.which==3){alert(message);return false;}}} 
    if (document.layers){document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS4;}
    else if (document.all&&!document.getElementById){document.onmousedown=clickIE4;} document.oncontextmenu=new Function("alert(message);return false")
</script>

<body oncontextmenu="return false" onkeydown="if ((arguments[0] || window.event).ctrlKey) return false" >
<body onBeforePrint="document.body.style.display='none'"; onAfterPrint="document.body.style.display='';">
<script type="text/jscript">
  function disableContextMenu(){
    document.getElementById("fraDisabled").contentWindow.document.oncontextmenu = function(){alert("Dokumen Milik Bank DKI Dilarang Print/Download!"); return false;};;    
  }  
</script>


<script type="text/javascript"> $(document).ready(function() {
    $(window).keyup(function(e){
      if(e.keyCode == 44){
        $("body").hide();
      }
    });
}); 
</script>
<style>
body {

  /*background: -webkit-linear-gradient(left, #ff0000 0%, #ff0000 25%, #f600ff 50%, #faff00 75%, #0800ff 100%);*/
  /*background: linear-gradient(to right, #ff0000 0%, #ff0000 25%, #ff0000 50%, #ff0000 75%, #ff0000 100%);*/
  background-position: center;
    background-repeat: no-repeat;
    background-size: auto;
 background-attachment: fixed; background-blend-mode: lighten;
  /*background-image: url("../../../../pages/view/tesdri/web/converimg/gambar/<?php echo  $wt;?>") ;*/

 }

 

iframe {
  width: 100%;
  height: 600px;
  /*margin: 0 15%;*/
  /*background-color: transparent;*/
  border: 0;
  color: black;

}
iframe.transparent {
  /*opacity: 0.6;*/
}
iframe.control html body {
  background-color: rgba(255, 0, 0, 0.5);
}
p {
  font-size: 20px;
  color: white;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 20px;
}

.watermark{
  font-family: Calibri;
  position: absolute;
  margin-left:  38%;
  margin-top:  20%;
  padding:  20px;
  text-align:  center;
  width:  300px;
  background-color: #545454;
  color:  white;
  opacity: 0.5;
  font-size: 20px;
  font-weight: bold;
}


</style>



<body bgcolor="#FFFFFF" onload="disableContextMenu();" oncontextmenu="return false">
  <?php
    $app = $_GET["app"];
  ?>
  <div class="watermark">
    qqq
  </div>
  <iframe class="transparent" id="fraDisabled" width="100%" height="1000" src="process/web/viewer.php?file=../../../document/<?php print $app; ?>/<?php print $file ?> " onload="disableContextMenu();" onMyLoad="disableContextMenu();">
  </iframe>
</body>

</div>
</body>
</body>
 

