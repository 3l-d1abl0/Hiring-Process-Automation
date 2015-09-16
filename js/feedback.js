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
	//addqb ends

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

		/*
		html=ques+":  ";
		html+="<select name='q-"+(qno+addi)+"' id='q-"+(qno+addi)+"'>";
		html+="<option value='1' selected='selected'>1</option>";
		html+="<option value='2'>2</option>";
		html+="<option value='3'>3</option>";
		html+="<option value='4'>4</option>";
		html+="<option value='5'>5</option>";
		html+="</select><br><br>";
		*/

		html=ques+": "; 
		html+="<div class='rate-ex1-cnt' id='q_"+(qno+addi)+"'>";
		html+="<div class='star_1 ratings_stars' id='1'></div>";
		html+="<div class='star_2 ratings_stars' id='2'></div>";
		html+="<div class='star_3 ratings_stars' id='3'></div>";
		html+="<div class='star_4 ratings_stars' id='4'></div>";
		html+="<div class='star_5 ratings_stars' id='5'></div>";
		html+="<span class='invisible' >0</span>"
		html+="<input type='number' name='q-"+(qno+addi)+"' id='q-"+(qno+addi)+"' value='0' class='invisible'></input>";
		html+="</div><br>";




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
	//addit ends


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


	/////////////
	///Binding events on elements for dynamic elements
	$('.quest').on('mouseenter','.ratings_stars',function(){

				//alert(this.attr('id'));
        var curr_id=$(this).attr('id');
        var par_id=$(this).parent().attr('id');
            //var val=$('#'+par_id+' span').text();
        var integer=par_id.split('_');
		var val= $('#q-'+integer[1]).val();
            
        if(val==0){
                        $(this).prevAll().andSelf().addClass('ratings_over');
        }

        //alert(spn);
        $('#'+par_id+' span').text(curr_id);
	});

	$('.quest').on('mouseleave','.ratings_stars',function(){

		var curr_id=$(this).attr('id');
        var par_id=$(this).parent().attr('id');

        var integer=par_id.split('_');
		var val= $('#q-'+integer[1]).val();

         if(val==0){
                    $(this).prevAll().andSelf().removeClass('ratings_over');
         }

	});

	$('.quest').on('click','.ratings_stars',function(){

		var curr_id=$(this).attr('id');
	    var par_id=$(this).parent().attr('id');
        
        
                //FROM NOT ALL ONLY FROM SIBLINGS
        //$('.ratings_stars').removeClass('ratings_over');

        $(this).siblings().removeClass('ratings_over');

        $(this).prevAll().andSelf().addClass('ratings_over');

        var integer=par_id.split('_');
        $('#q-'+integer[1]).val(curr_id);



	});


/*
	$('.ratings_stars').hover(
    // Handles the mouseover
    function() {
        //alert(this.attr('id'));
        var curr_id=$(this).attr('id');
        var par_id=$(this).parent().attr('id');
            //var val=$('#'+par_id+' span').text();
        var integer=par_id.split('_');
		var val= $('#q-'+integer[1]).val();
            
        if(val==0){
                        $(this).prevAll().andSelf().addClass('ratings_over');
        }

        //alert(spn);
        $('#'+par_id+' span').text(curr_id);



    },
    // Handles the mouseout
    function() {
		
		var curr_id=$(this).attr('id');
        var par_id=$(this).parent().attr('id');

        var integer=par_id.split('_');
		var val= $('#q-'+integer[1]).val();

         if(val==0){
                    $(this).prevAll().andSelf().removeClass('ratings_over');
         }
    	
    	});


	$('.ratings_stars').click(function(){
	//$('.ratings_stars').bind('click',function(){
	    	//alert('click');

	    var curr_id=$(this).attr('id');
	    var par_id=$(this).parent().attr('id');
        
        
                //FROM NOT ALL ONLY FROM SIBLINGS
        //$('.ratings_stars').removeClass('ratings_over');

        $(this).siblings().removeClass('ratings_over');

        $(this).prevAll().andSelf().addClass('ratings_over');

        var integer=par_id.split('_');
        $('#q-'+integer[1]).val(curr_id);




	 });

*/


	///////////

	//alert('-');
});