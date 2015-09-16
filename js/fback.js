$(document).ready(function(){

	//alert('+');
	$('#addquestion').hide();
	$('#nxtround').hide();
	//$('#newqerr').hide();
	$("input[type=radio]").attr('disabled', true);

	$("#addqb").click(function(){

		var inter_id=$('#interview_id').val();
		inter_id=$.trim(inter_id);
		//alert(inter_id);
		var detail=inter_id.split('-');
		//alert(detail[0]);
		//alert(detail[1]);

		
		$.ajax({
			url:"checktable.php",
			type:'POST',
			data:{interid:inter_id},
			success:function(res){
				if(res){
					//alert(res);
					$("#addquestion").slideDown();
					$("#addqb").hide();
					$('#newqerr').html('Add your desired question !');
					$('#newqerr').slideDown();
					//alert(res);
				}
				else{
					//try again
					//alert(res);
					$('#newqerr').html('Cant\'t Add new questions !');
					$('#newqerr').slideDown();
				}
			}
		});

		


		
		//$("#addquestion").css("visibility","visible");

		
	});

	$("#doneadd").click(function(){
		$("#addquestion").slideUp();
		$("#addqb").show();
		$('#newqerr').html('');
		$("#newq").val('');

	});


	$("#addit").click(function(){
		var ques=$("#newq").val();
		ques=$.trim(ques);

		var inter_id=$('#interview_id').val();
		inter_id=$.trim(inter_id);
		

		if(ques==''){
			//alert(ques);
			$('#newqerr').html('Question cannot be Blank !');
			$('#newqerr').slideDown();
			return false;
		}

		//the new question number
		var qno=parseInt($("#maxq").val());
		var addi=parseInt($("#addi").val())+1;

		html=ques+":  ";
		html+="<select name='q-"+(qno+addi)+"' id='q-"+(qno+addi)+"'>";
		html+="<option value='1' selected='selected'>1</option>";
		html+="<option value='2'>2</option>";
		html+="<option value='3'>3</option>";
		html+="<option value='4'>4</option>";
		html+="<option value='5'>5</option>";
		html+="</select><br><br>";

		//html="<div id='q"+qno+"'>"+qno+".		"+ques+" </div>";
		//html+="<textarea id='a"+qno+"' class='ans'> </textarea><br><br>";
		
		//$("#quest").append(html);
		//$("#maxq").val(qno);

		var newnum=qno+addi;

		$.ajax({
			url:"addques.php",
			type:'POST',
			data:{tbl:inter_id,qid:addi,ques:ques},
			success:function(res){
				if(res){
					$("#quest").append(html);
					$("#addi").val(addi);
					$('#newqerr').html('Added!');
					$('#newqerr').slideDown();
					$("#newq").val('');
					//alert(res);
				}
				else{
					//try again
					//alert(res);
					$('#newqerr').html('can\'t Add :Try Again !');
					$('#newqerr').slideDown();
				}
			}
		});


	});


	$("#hire").change(function(){

		//alert('qq');

		/*if($("#hire")[0].checked==true){
			$("#nxtround").hide();
		}
		else{

			$("#nxtround").show();
		}*/

		if(this.checked){
			//alert('Cheked!');
			$("#nxtround").hide();
			$("input[type=radio]").attr('disabled', true);

		}
		else{
			//alert('Unchecked!');
			$("#nxtround").show();
			$("input[type=radio]").attr('disabled', false);
		}
	});

	$("#sub").click(function(){

		//e.preventDefault();

	});


	//alert('-');
});