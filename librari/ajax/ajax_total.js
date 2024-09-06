
var http = false;
if(navigator.appName == "Microsoft Internet Explorer") {
  http = new ActiveXObject("Microsoft.XMLHTTP");
} else {
  http = new XMLHttpRequest();
}

function getTotal(orderid,ongkir) {
  http.abort();
  http.open("GET", "/librari/ajax/ajax_total.php?orderid=" + orderid + "&ongkir="+ongkir, true);
  http.onreadystatechange=function() {
    if(http.readyState == 4) {
		var responses = http.responseText;
		
		var res         = responses.split('~~');
		var ongkosawrp  = "<b>" + res[0] +"</b>";
		var ongkosakhir = res[1];
		var ongkosakrp  = res[2];
		var nilaisubsrp = res[3];
		var total       = res[4];
		var totalrp     = "<b>" + res[5] +"</b>";
		
		$("#ongkosawal_text").html(ongkosawrp);
		$("#ongkoskirim").text(ongkosakhir);
		$("#ongkoskirim_text").text(ongkosakrp);
		$("#nilaisubsidi_text").text(nilaisubsrp);
		$("#totalpembelian").html(totalrp);
		/*var subsec=response.split('|');
		for (i=0; i<(subsec.length-1); i++) {
		    var data = subsec[i].split('~~');
		    //addOption1(list,data[1],data[0]);
		   }*/
		
    }
  }
  http.send(null);
}

function trapError() {
	return true; // stop the yellow triangle
}
//window.onerror = trapError;