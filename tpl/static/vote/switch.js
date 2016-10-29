$(function(){   
    //鼠标滑向换色   
    $(".list").hover(function(){   
        $(this).addClass("cur_select");   
    },function(){   
        $(this).removeClass("cur_select");   
    });   
       
    //关闭   
    $(".ad_on").live("click",function(){   
        var add_on = $(this);        
            add_on.removeClass("ad_on").addClass("ad_off").attr("title","点击开启");
         $('#votelimit').val(0);			
    });   
    //开启   
    $(".ad_off").live("click",function(){   
        var add_off = $(this);    
			add_off.removeClass("ad_off").addClass("ad_on").attr("title","点击关闭");   
			$('#votelimit').val(1);	
    });   
});  