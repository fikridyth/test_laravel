<html>
<head>
<title>Disable Context Menu</title>





<script type="text/jscript">
  function disableContextMenu()
  {
    //window.frames["fraDisabled"].document.oncontextmenu = function(){alert("No way!"); return false;};   
    // Or use this
     document.getElementById("fraDisabled").contentWindow.document.oncontextmenu = function(){alert("No way!"); return false;};;    
  }  
</script>
</head>
<body bgcolor="#FFFFFF" onload="disableContextMenu();" oncontextmenu="return false">
<iframe id="fraDisabled" width="528" height="473" src="x.php" onload="disableContextMenu();" onMyLoad="disableContextMenu();"></iframe>
</body>
</html>