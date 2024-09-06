
var http = false;
if(navigator.appName == "Microsoft Internet Explorer") {
  http = new ActiveXObject("Microsoft.XMLHTTP");
} else {
  http = new XMLHttpRequest();
}

function removeOptions1(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
	selectbox.remove(i);
	}
	var optn = document.createElement("OPTION");
	optn.text = " Select Agent Delivery ";
	optn.value = "";
	selectbox.options.add(optn);
	
}

function removeOptionsOngkos(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
	selectbox.remove(i);
	}
	var optn = document.createElement("OPTION");
	optn.text = " Select Service ";
	optn.value = "";
	selectbox.options.add(optn);
}

function addOption1(selectbox,text,value )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	selectbox.options.add(optn);
}

/*function removeOptions5(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
	selectbox.remove(i);
	}
	var optn = document.createElement("OPTION");
	optn.text = " Pilih Pembayaran ";
	optn.value = "";
	selectbox.options.add(optn);
}

function addOption5(selectbox,text,value )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	selectbox.options.add(optn);
}*/

function getAgen(orderid,kecid) {
  http.abort();
  http.open("GET", "/librari/ajax/ajax_agen.php?orderid=" + orderid +'&kecid=' + kecid, true);
  http.onreadystatechange=function() {
    if(http.readyState == 4) {
		var responses = http.responseText;
		var res=responses.split('^^^');
		var response = res[0];
		var response5 = res[1];
		
		var list=document.getElementById("pengiriman");
		removeOptions1(list);
		var subsec=response.split('|');
		for (i=0; i<(subsec.length-1); i++) {
		    var data = subsec[i].split('~~');
		    addOption1(list,data[1],data[0]);
		   }
		   var ongkos = document.getElementById("ongkirid");
		   removeOptionsOngkos(ongkos);
    		// ongkos.remove(ongkos.selectedIndex);
		
		/*var list5=document.getElementById("pembayaran");
		removeOptions5(list5);
		addOption5(list5,"Transfer","Transfer");
		/*var subsec5=response5.split('|');
		for (c=0; c<(subsec5.length-1); c++) {
		    var data5 = subsec5[c].split('~~');
		    addOption5(list5,data5[1],data5[0]);
		   }*/
    }
  }
  http.send(null);
}

function trapError() {
	return true; // stop the yellow triangle
}
//window.onerror = trapError;