$(document).ready(function(){



	$('.ratings_stars').hover(
    // Handles the mouseover
    function() {
        //alert(this.attr('id'));

            var par_id=$(this).parent().attr('id');

            var val=$('#'+par_id+' span').text();
            if(val==0){
                        $(this).prevAll().andSelf().addClass('ratings_over');
            }

        


        //$(this).nextAll().removeClass('ratings_vote'); 
    },
    // Handles the mouseout
    function() {

                var par_id=$(this).parent().attr('id');

                var val=$('#'+par_id+' span').text();

                if(val==0){
                    $(this).prevAll().andSelf().removeClass('ratings_over');
                }


        
        //set_votes($(this).parent());
       // alert($(this).parent().attr('id'));
        var par_id=$(this).parent().attr('id');
        //alert($(this).attr('id'));
        //alert($(this).parent().attr('id'));
        var curr_ele=$(this).attr('class');

        var spn=$('#'+par_id+' span').text();
        //alert(spn);
        //$('#'+par_id+' span').text($(this).attr('id'));
    }
	);

    
    //$('.ratings_stars').click(function(){
    $('.ratings_stars').bind('click',function(){

        
        var curr_id=$(this).attr('id');
        //alert(curr_id);
        
        //var curr_class=$(this).attr('class');
        //alert(curr_class);
        
                //FROM NOT ALL ONLY FROM SIBLINGS
        //$('.ratings_stars').removeClass('ratings_over');

            $(this).siblings().removeClass('ratings_over');


        //var curr_class=$(this).attr('class');
        //alert(curr_class);

        $(this).prevAll().andSelf().addClass('ratings_over');
        

        var par_id=$(this).parent().attr('id');

        $('#'+par_id+' span').text(curr_id);

            
        //alert($(this).prevAll().attr('id'));

        /*
        for(var i=curr_id;i>0;i--){
            //alert(i);
            //$('.star_'+i).addClass('ratings_over');
            $('#'+par_id+'#'+i).addClass('ratings_over');
        }
        */

        
    });


    /*
    $('.ratings_stars').bind('click',function(){
        alert('....');
    });

    */





});