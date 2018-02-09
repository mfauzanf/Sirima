$(document).ready(function(){

	 $("#daftar").click(function(){
        $("#formS1").show();
    });


	 $("#pilihJenjang").click(function() {
         var jenjang = $('#jenjang').val();

         if (jenjang=="S1") {
         	window.open('formS1.html');
         }
    });



    $("#simpanData").click(function() {       
       var asalSekolah = $('#asalSekolah').val();
       var jenisSMA = $('#jenisSMA').val();
  	   var alamatSekolah = $('#alamatSekolah').val();
  	   var nisn =  $('#nisn').val();
  	   var tglLulus = $('#tglLulus').val();	  
  	   var nilaiUan = $('#nilaiUAN').val();	
  	   var prodi1 = $('#pilihan1').val();	
  	   var prodi2 = $('#pilihan2').val();	
  	   var prodi3 = $('#pilihan3').val();	
  	   var kota= $('#pilihKota').val();	
  	   var tempat= $('#pilihTempat').val();	
	  // var kota = document.getElementById('pilihKota').value;
	  // var tempat = document.getElementById('pilihTempat').value;
 		

 	   function cekAsalSekolah(valueAsal) {	 	   	 
				if (valueAsal=="") {
					$("#asalError").html("Asal Sekolah Wajib Diisi");
				}
				else {
				 $('.warning').empty();
					return true;
				}			
	   }

	   function cekJenisSMA(valueJenis) {	   		 
				if (valueJenis=="") {
					$("#jenisError").html("Jenis Sekolah Wajib Diisi");
				}
				else {
					 $('.warning').empty();
					return true;
				}	
	   }

	   function cekAlamatSekolah(valueAlamat) {
	   		if (valueAlamat=="") {
					$("#alamatError").html("Alamat Sekolah Wajib Diisi");
				}
				else {
					 $('.warning').empty();
					return true;
				}
	   }

	   function cekNISN(valueNISN) {

	   		if (valueNISN.match(/[^$,.\d]/)) {
	   			$("#nisnError").html("NISN tidak boleh mengandung huruf");
			}
			else if (valueNISN.length > 10) {
				$("#nisnError").html("NISN maksimal 10 digit");
				 
			}
			else if (valueNISN=="") {
				$("#nisnError").html("NISN wajib diisi");	 
			}
			else {
			 $('.warning').empty();
				return true;
			}
	   		
	   }

	   function cekTgl(valueTgl) {
	   		
			if (valueTgl=="") {
				$("#tglError").html("Tanggal Lulus wajib diisi");	 
			}
			else {
				 $('.warning').empty();
				return true;
			}
	   		
	   }

	   function cekUAN(valueUAN) {	   		 			 
			if(valueUAN == "") {
			 	$("#uanError").html("Nilai UAN wajib diisi");					 
			}
			else {		
			$('.warning').empty();		 
				return true;
			}
	   		
	   }

	   function cekProdi(prodi1,prodi2,prodi3) {
	   	   if (prodi1 == "") {
	   	   		$("#prodi1").html("Prodi 1 wajib diisi");	
	   	   }
	   	   else if((prodi1 == prodi2) && (prodi1 == prodi3)) {
	   	   		$("#prodi1").html("Prodi tidak boleh sama");
	   	   		$("#prodi2").html("Prodi tidak boleh sama");
	   	   		$("#prodi3").html("Prodi tidak boleh sama");
	   	   }
	   	   else if(prodi2 !='' && (prodi1 == prodi2)) {
	   	   		$("#prodi1").html("Prodi tidak boleh sama");
	   	   		$("#prodi2").html("Prodi tidak boleh sama");
	   	   }
	   	   else if(prodi3 !='' && (prodi1 == prodi3)) {
	   	   		$("#prodi1").html("Prodi tidak boleh sama");
	   	   		$("#prodi3").html("Prodi tidak boleh sama");
	   	   }
	   	   else if(prodi3 !='' && prodi2 !='' && prodi1 !='' &&   (prodi2 == prodi3)) {
	   	   		$("#prodi2").html("Prodi tidak boleh sama");
	   	   		$("#prodi3").html("Prodi tidak boleh sama");
	   	   }
	   	   else {
	   	   		 $('.warning').empty();
				return true;
	   	   }
	   }

	   function cekKota(kota) {
	   		if (kota == "") {
	   	   		$("#kotaError").html("Kota Ujian wajib diisi");	
	   	   }
	   	   else {
	   	    $('.warning').empty();
				return true;
	   	   }
	   }

	   function cekTempat(tempat) {
	   		if (tempat == "") {
	   	   		$("#tempatError").html("Tempat Ujian wajib diisi");	
	   	   }
	   	   else {	
	   	   $('.warning').empty();   	   		
				return true;
	   	   }
	   }


	   var uanValid = cekUAN(nilaiUAN); 
	   var asalSekolahValid = cekAsalSekolah(asalSekolah);
	   var jenisSMAValid = cekJenisSMA(jenisSMA);
	   var alamatSekolahValid = cekAlamatSekolah(alamatSekolah);
	   var nisnValid = cekNISN(nisn);
	   var tglValid = cekTgl(tglLulus);	  

	   var prodiValid = cekProdi(prodi1,prodi2,prodi3);
	   var kotaValid = cekKota(kota);
	   var tempatValid = cekTempat(tempat);


	   if((uanValid  == true) && (asalSekolahValid  == true) && (jenisSMAValid == true) && (alamatSekolahValid  == true) && (nisnValid  == true) && (tglValid  == true) && (tempatValid  == true) && (prodiValid  == true) && (kotaValid  == true)) {
     		window.open('pembayaran.html');
     	}


    });
});