
var http = false;
if(navigator.appName == "Microsoft Internet Explorer") {
  http = new ActiveXObject("Microsoft.XMLHTTP");
} else {
  http = new XMLHttpRequest();
}

function removeOptions2(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
	selectbox.remove(i);
	}
	var optn = document.createElement("OPTION");
	optn.text = " Select City ";
	optn.value = "";
	selectbox.options.add(optn);
}

function addOption(selectbox,text,value )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	selectbox.options.add(optn);
}

function getKota(propinsi) {
  http.abort(); 
  http.open("GET", "/librari/ajax/ajax_kota.php?propinsi=" + propinsi, true);
  http.onreadystatechange=function() {
    if(http.readyState == 4) {
		var response   = http.responseText;
		var list       = document.getElementById("kotaId2");
		removeOptions2(list);
		$("select[name='cityname']").val('').trigger("chosen:updated");
		
		var subsec=response.split('|');
		for (i=0; i<(subsec.length-1); i++) {
		    var data = subsec[i].split('~~');
		    addOption(list,data[1],data[0]);
		   }
    }
  }
  http.send(null);
}

function getKota2(propinsi) {
  http.abort();
  http.open("GET", "/librari/ajax/ajax_kota.php?propinsi=" + propinsi, true);
  http.onreadystatechange=function() {
    if(http.readyState == 4) {
		var response = http.responseText;
		var list=document.getElementById("kotaId3");
		removeOptions2(list);
		var subsec=response.split('|');
		for (i=0; i<(subsec.length-1); i++) {
		    var data = subsec[i].split('~~');
		    addOption(list,data[1],data[0]);
		   }
    }
  }
  http.send(null);
}
function trapError() {
	return true; // stop the yellow triangle
}
//window.onerror = trapError;