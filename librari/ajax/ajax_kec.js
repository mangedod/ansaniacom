
var http = false;
if(navigator.appName == "Microsoft Internet Explorer") {
  http = new ActiveXObject("Microsoft.XMLHTTP");
} else {
  http = new XMLHttpRequest();
}

function removeOptions1kec(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
	selectbox.remove(i);
	}
	var optn = document.createElement("OPTION");
	optn.text = " Pilih Kecamatan";
	optn.value = "";
	selectbox.options.add(optn);
	
}

function addOption1kec(selectbox,text,value )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	selectbox.options.add(optn);
}

function removeOptions5kec(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
	selectbox.remove(i);
	}
	var optn = document.createElement("OPTION");
	optn.text = " Select Districts ";
	optn.value = "";
	selectbox.options.add(optn);
}

function addOption5kec(selectbox,text,value )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	selectbox.options.add(optn);
}

function getKec(kotaid) {
  http.abort();
  http.open("GET", "/librari/ajax/ajax_kec.php?kotaid=" + kotaid, true);
  http.onreadystatechange=function() {
    if(http.readyState == 4) {
		var responses = http.responseText;
		var res=responses.split('^^^');
		var response = res[0];
		var response5 = res[1];
		
		var list=document.getElementById("kecid");
		removeOptions1kec(list);
		var subsec=response.split('|');
		for (i=0; i<(subsec.length-1); i++) {
		    var data = subsec[i].split('~~');
		    addOption1kec(list,data[1],data[0]);
		   }
		
		
    }
  }
  http.send(null);
}

function getKec2(kotaid) {
  http.abort();
  http.open("GET", "/librari/ajax/ajax_kec.php?kotaid=" + kotaid, true);
  http.onreadystatechange=function() {
    if(http.readyState == 4) {
		var responses = http.responseText;
		var res=responses.split('^^^');
		var response = res[0];
		var response5 = res[1];
		
		var list=document.getElementById("kecid2");
		removeOptions1kec(list);
		var subsec=response.split('|');
		for (i=0; i<(subsec.length-1); i++) {
		    var data = subsec[i].split('~~');
		    addOption1kec(list,data[1],data[0]);
		   }
		
		
    }
  }
  http.send(null);
}

function trapError() {
	return true; // stop the yellow triangle
}
//window.onerror = trapError;