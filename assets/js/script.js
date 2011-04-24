/* Author: Jonathan Foucher

*/

$(document).ready(function(){
    var gen_img_div=$('#generated_image');
    //gen_img_div.hide();


    changeImage=function(type){
        var class=$("#genImg").attr('class');
        if (type=='next'){
            var num=parseInt(class.substr(4))+1;
        }else{
            var num=parseInt(class.substr(4))-1;
        }
        $("#genImg").attr('class','num_'+num);
        var width=$("#width").val();
        var height=$("#height").val();
        var tags=$("#tags").val();
        if (width) var nw=width + '/';
        if (height) var nh=height + '/';
        if (tags) var nt=tags + '/';
        else nt='';
        if (num>=1 && !$('#prev').text()){
            gen_img_div.prepend('<a href="#" id="prev">&laquo;&nbsp;Previous</a>');
        }
        if (num==0){
            $('#prev').remove();
        }

        //alert(nw+nh+tags+num);
        //$('#genImg img').css('display','none');
        $('#genImg').load('/image/ajax/' + nw+nh+nt+num, function(resp, status){
            //$('#genImg img').attr('src','/image/ajax/' + nw+nh+tags+num);
            //$('#genImg img').css('display','inline');
            var codeDiv=$('#imgcode');
            codeDiv.empty();
            codeDiv.append('<pre>&lt;img src="http://flickholdr.com/'+nw+nh+nt+num+'" alt="Placeholder image from flickholdr.com" /&gt;</pre>');
        });


    }


    $('#next').live('click',function(e){
        changeImage('next');

        e.preventDefault();
    });

    $('#prev').live('click',function(e){

        changeImage('prev');
        e.preventDefault();

    });

    $('#generate input').change(function(){
        //submit form by ajax
        var width=$("#width").val();
        var height=$("#height").val();

        var tags=$("#tags").val();
        if (width) var nw=width + '/';
        if (height) var nh=height + '/';
        //if (tags && num) var nh=tags + '/';
        if (width && height){
            gen_img_div.empty();

            gen_img_div.prepend('<div id="genImg" class="num_0">');
            gen_img_div.prepend('<a href="#" id="next">Next&nbsp;&raquo;</a>');
            gen_img_div.append('<div id="imgcode" />');

            var codeDiv=$('#imgcode');
            codeDiv.hide();
            codeDiv.empty();
            $('#genImg').css('width',width);
            $('#genImg').css('height',height);

            $('#genImg').prepend('<p id="closeImg">X</p>').append('<img src="/'+nw+nh+tags+'" />');
            //$('#genImg').append('<img src="/'+nw+nh+tags+'" />');

            codeDiv.append('<pre>&lt;img src="http://flickholdr.com/'+nw+nh+tags+'" alt="Placeholder image from flickholdr.com" /&gt;</pre>');
            gen_img_div.fadeIn();
            codeDiv.fadeIn();

        }



        //show spinner while waiting for reply
        //http://ajaxload.info/cache/FF/FF/FF/33/33/33/32-0.gif
        //show resulting image in #generated_image


    });
    $('#closeImg').css('cursor','pointer');
    $('#closeImg').live('click',function(){gen_img_div.fadeOut()});
})























