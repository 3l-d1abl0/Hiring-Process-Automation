$(document).ready(function(){
	
	$("#addin").hide();
	$("#errr").hide();
	$('#adderrr').hide();
	var fileName='';


	$( "#adbtn" ).click(function() {
  		$( "#addin" ).slideDown();
	});



	$("#done").click(function(){
		$("#addin").slideUp();
		$("#adderrr").hide();
	});



	$("#add").click(function(){
		//alert('clicked');

		$("#adderrr").hide();

		var nm=$("#iname").val(); 	nm=$.trim(nm);
		var id=$("#iid").val();		id=$.trim(id);
		var mail=$("#iemail").val(); mail=$.trim(mail);
		var irole=$("#irole").val();  irole=$.trim(irole); irole=irole.toLowerCase();

		//alert(nm+'+'+id+'+'+mail+'+'+irole);
		// error check
		if(nm=='' || id=='' || mail==''|| irole=='' || !isValidEmailAddress(mail) ){
			//alert('Not valid!');
			$('#adderrr').html('Not valid Details !');
			$('#adderrr').slideDown();

			return false;
		}
		else{


				var currol=$('#roles').val();

				//alert(nm+'+'+id+'+'+mail+'+'+irole+'+'+currol);

				
				$.ajax({
					url:"addempl.php",
					type:'POST',
					async:false,
					data:{name:nm,id:id,email:mail,role:irole},
					success:function(res){

						if(res!=0){
							//alert(res);
							if(currol==irole){

								$("#empl").append(
									$('<option>', {
		    							value: id,
		    							text:  nm
									}));	
							}
							
							//alert(res);
							$('#adderrr').html('Added !');
							$('#adderrr').slideDown();

						}
						else{
							//try again
							//alert('Try again!');
							$('#adderrr').html('Try Again !');
							$('#adderrr').slideDown();
						}
					}
				});



			}	//else

		
	});






	$('#roles').on('change', function() {
  		//alert( this.value ); // or $(this).val()
  		//$("#empl").remove();
  		$("#empl").empty();

  		var val=this.value;
  		//alert(val);
  		$.ajax({
  			url:"addroles.php",
  			type:'POST',
  			data:{role:val},
  			success:function(res){
  				if(res){
  					var data=jQuery.parseJSON(res);
  					//alert(res);
  					//alert(data);
  					for(var i=0;i<data.length;i++){
  						//data+=res[i].id;
  						//alert(data[i].id+" "+data[i].name);
  						$("#empl").append(
						$('<option>', {
    						value: data[i].id,
    						text:  data[i].name
						}));
  					}
  				}
  				else{
  					//alert('nn');
  				}
  			}
  		});
	});

	

	var less= new Array('4','6','9','11');
	var more= new Array('1','3','5','7','8','10','12');

	
	$('#month').on('change',function(){
		
			$('#date').empty();
			var mnth=this.value;
			//alert('+'+mnth+'+');

			if(mnth==2){
				//alert(mnth);
				for(var i=1;i<=29;i++){
					$("#date").append(
						$('<option>', {
    						value: i,
    						text:  i
						}));
				}
			}
			else{
				//var cat=less.indexOf(mnth);
				var cat=jQuery.inArray(mnth,less);
				//alert(cat);
				if(cat<0){

					for(var i=1;i<=31;i++){
					$("#date").append(
						$('<option>', {
    						value: i,
    						text:  i
						}));
					}
				}
				else{

					for(var i=1;i<=30;i++){
					$("#date").append(
						$('<option>', {
    						value: i,
    						text:  i
						}));
				}

				}
			}

			
	});



	function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
	};


	//$("input:file").change(function (){
		/*
	$('input[type=file]').change(function (){
       fileName = $(this).val();
       alert(fileName);	
     });
	*/



	$('#submit').click(function(){

		$('#errr').hide();
		//alert(fileName);

		var fname=$('#fname').val();
			fname=$.trim(fname);
			//alert(fname);

		if(!fname.match(/^[A-Za-z]+$/)){
			//not alphabet
			$('#errr').html('Only Alphabets in Name !');
			$('#errr').slideDown();
			return false;
		}

		var lname=$('#lname').val();
			lname=$.trim(lname);
			//alert(lname);

		if(!lname.match(/^[A-Za-z]+$/)){
			//not alphabet
			$('#errr').html('Only Alphabets in Name !');
			$('#errr').slideDown();
			return false;
		}

		var age=$('#age').val();
		//alert('Age:'+age);
		if(!age.match(/^\d+$/)){
			//age nust be in numbers
			$('#errr').html('Age must be in Numbers !');
			$('#errr').slideDown();
			return false;
		}

		var coll=$('#college').val();
		//alert(city);
		if(!coll.match(/^[A-Za-z]+$/)){
			//city name must be in alphabets
			$('#errr').html('Only Alphabets in College Name !');
			$('#errr').slideDown();
			return false;
		}

		var city=$('#ccity').val();
		//alert(city);
		if(!city.match(/^[A-Za-z]+$/)){
			//city name must be in alphabets
			$('#errr').html('Only Alphabets in City Name !');
			$('#errr').slideDown();
			return false;
		}

		var empl=$('#empl').val();
		if(empl==''){
			//interviewer name blank
			$('#errr').html('Interviewer Name Blank !');
			$('#errr').slideDown();
			return false;
		}


		var yr=$('#year').val();
		var mon=$('#month').val();
		var day=$('#date').val();
		var hr=$('#hr').val();
		var minu=$('#minu').val();

		


		var indate= new Date (yr,mon-1,day,hr,minu,0);
		var rightnow = Date.now();

		if(indate<rightnow){
			//can't go to the past
			$('#errr').html('Interview Date can\'t be in past !');
			$('#errr').slideDown();
			return false;
		}

		//alert(fileName);



	});





});