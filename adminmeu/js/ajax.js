   var xmlHttp = buatObjekXmlHttp();
   
   function buatObjekXmlHttp()
   {
      var obj = null;
      if (window.ActiveXObject)
         obj = new ActiveXObject("Microsoft.XMLHTTP");   
      else 
         if (window.XMLHttpRequest)
            obj = new XMLHttpRequest();
          
      // Cek isi xmlHttp
      if (obj == null)
         document.write(
            "Browser tidak mendukung XMLHttpRequest");      
      return obj;    
   }
           
   function ambilData(sumber_data, id_elemen)
   { 
      if (xmlHttp != null)
      {
         var obj = document.getElementById(id_elemen);
         xmlHttp.open("GET", sumber_data, true);

         xmlHttp.onreadystatechange = function ()
         {
            if (xmlHttp.readyState == 4 &&
                xmlHttp.status == 200)
            {
               obj.innerHTML = xmlHttp.responseText;
            }
         }  
         
         xmlHttp.send(null);
      }
   }
var drz; 
	
	 
	function buatajax(){ 
	    if (window.XMLHttpRequest){ 
	        return new XMLHttpRequest(); 
	    } 
	    if (window.ActiveXObject){ 
	        return new ActiveXObject("Microsoft.XMLHTTP"); 
	    } 
	    return null; 
	} 
	 
//fungsi pasien
	function lihat3(kata3){ 
	    if(kata3.length==0){ 
	        document.getElementById("kotaksugest3").style.visibility = "hidden"; 
	    }else{ 
	        drz = buatajax(); 
	        var url="caripasien.php"; 
	        drz.onreadystatechange=stateChanged3; 
	        var params = "q1="+kata3; 
	        drz.open("POST",url,true); 
	        //beberapa http header harus kita set kalau menggunakan POST 
	        drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	        drz.setRequestHeader("Content-length", params.length); 
	        drz.setRequestHeader("Connection", "close"); 
	        drz.send(params); 
	    } 
	 
	} 

	function stateChanged3(){ 
	var data; 
	    if (drz.readyState==4 && drz.status==200){ 
	        data=drz.responseText; 
	        if(data.length>0){ 
	            document.getElementById("kotaksugest3").innerHTML = data; 
	            document.getElementById("kotaksugest3").style.visibility = ""; 
	        }else{ 
	            document.getElementById("kotaksugest3").innerHTML = ""; 
	            document.getElementById("kotaksugest3").style.visibility = "hidden"; 
	        } 
	    } 
	} 
	 
	function isi3(id,nama){ 
	    document.getElementById("kata3").value = id; 
		document.getElementById("siswa").value = nama; 
	    document.getElementById("kotaksugest3").style.visibility = "hidden"; 
	    document.getElementById("kotaksugest3").innerHTML = ""; 
	} 	 
	
	//puskesmas
	
	
