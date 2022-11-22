 

<!DOCTYPE html>
<html>
<head>

<script> var message="OOppsss.........";
    ///////////////////////////////////
    function clickIE4(){if (event.button==2){alert(message);return false;}} 
    function clickNS4(e){if (document.layers||document.getElementById&&!document.all){if (e.which==2||e.which==3){alert(message);return false;}}} 
    if (document.layers){document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS4;}
    else if (document.all&&!document.getElementById){document.onmousedown=clickIE4;} document.oncontextmenu=new Function("alert(message);return false")
 
</script>

<body oncontextmenu="return false" onkeydown="if ((arguments[0] || window.event).ctrlKey) return false" >
  
<script type="text/jscript">
  function disableContextMenu()
  {
    //window.frames["fraDisabled"].document.oncontextmenu = function(){alert("No way!"); return false;};   
    // Or use this
     document.getElementById("fraDisabled").contentWindow.document.oncontextmenu = function(){alert("No way!"); return false;};;    
  }  
</script>

<body bgcolor="#FFFFFF" onload="disableContextMenu();" oncontextmenu="return false">
<iframe id="fraDisabled" width="1000" height="1000" src="viewer.html?file=contoh.pdf?page=hsn#toolbar=no" onload="disableContextMenu();" onMyLoad="disableContextMenu();"></iframe>
</body>


   
</div>
</body>
</body>
</html>
