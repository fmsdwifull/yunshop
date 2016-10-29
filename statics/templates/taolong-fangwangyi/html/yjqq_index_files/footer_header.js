var formatDate = function(date,format){if(!format)format="yyyy-MM-dd HH:mm:ss";date=new Date(parseInt(date));var dict={"yyyy":date.getFullYear(),"M":date.getMonth()+1,"d":date.getDate(),"H":date.getHours(),"m":date.getMinutes(),"s":date.getSeconds(),"S":(""+(date.getMilliseconds()+1000)).substr(1),"MM":(""+(date.getMonth()+101)).substr(1),"dd":(""+(date.getDate()+100)).substr(1),"HH":(""+(date.getHours()+100)).substr(1),"mm":(""+(date.getMinutes()+100)).substr(1),"ss":(""+(date.getSeconds()+100)).substr(1)};return format.replace(/(y+|M+|d+|H+|s+|m+|S)/g,function(a){return dict[a]})};
setTimeout(function  () {
	
    // shoppingCartNoneCon  无数据时的js效果
    $(".shoppingCartNone").hover(function(){
        $(".shoppingCartNoneCon").show();
    },function(){
        $(".shoppingCartNoneCon").hide();
    })
    // 我的云购全球
    $(".header1 ul li.MyzhLi").hover(function(){
        $(".header1 ul li.MyzhLi .Myzh").show();
        $(".MyzhLi a i").removeClass("top");
        $(".MyzhLi a i").addClass("bottom");
    },function(){
        $(".header1 ul li.MyzhLi .Myzh").hide();
        $(".MyzhLi a i").removeClass("bottom");
        $(".MyzhLi a i").addClass("top");
    })
    // 搜索
    $(".search_header2 input").focus(function(){
        $(this).css({color:"#333"});
//        var vals=$(this).val();
//        if(vals=="搜索您需要的商品"){
//            $(this).val("");
//        }
        //$(".search_span_a").hide();
    })
//    $(".search_span_a a").live('click', function(){
//        var htmls=$(this).html();
//        $(".search_header2 input").val("");
//        $(".search_header2 input").css({color:"#333"});
//        $(".search_header2 input").val(htmls);
//    })
    $(".search_header2 input").blur(function(){
//        var vals=$(this).val();
//        if(vals==""){
//            $(this).val("搜索您需要的商品");
//            $(".search_span_a").show();
            $(this).css({color:"#a9a9a9"});
//        }
    })
    
    $('.search_header2 input').bind('keypress',function(event){
        if(event.keyCode == "13"){
        	location.href='/goods/allCat.do?q='+$("#q").val();
        }
    });
    
    // 2015-5-22 -修改 start 悬浮菜单
    if($(".yNavIndexOut_fixed").offset()){
    	
    	var s_top=$(".yNavIndexOut_fixed").offset().top;
    	$(window).scroll(function(){
    		if($(window).scrollTop()>s_top){
    			$(".header_fixed").css({marginBottom:"46px"});
    			$(".yNavIndexOut_fixed").addClass("yNavIndexOutfixed");
    		}else{
    			$(".yNavIndexOut_fixed").removeClass("yNavIndexOutfixed");
    			$(".header_fixed").css({marginBottom:"0px"});
    		}
    	})
    }
    // 2015-5-22 -修改 end
    
    $($(".yBannerList")[0]).addClass("ybannerExposure");
    
    $(window).resize(function(){
	  $(".Left-fixed-divs").css({height:$(window).height()+"px"});// 右侧悬浮框的位置
	  $(".Left-fixed-divs2").css({height:$(window).height()+"px"});// 购物袋悬浮框的位置
	  $(".y-fixed-divs").css({left:($(window).width()-1210)/2-40+"px"});// 左侧left
	  $(".Left-fixed-login").css({top:($(window).height()-425)+"px"});// 登陆框的位置
	  $(".yNocommodity").css({lineHeight:$(window).height()+"px"});
    })
    $(window).resize();
    $(".Left-fixed-divs .lifixTop").click(function(e){     // 置顶
        e.preventDefault();
        $(document.documentElement).animate({
            scrollTop: 0
        },300);
        // 支持chrome
        $(document.body).animate({
            scrollTop: 0
        },300);
    });
    
    // 导航左侧栏js效果 start
	$('.pullDownList li').mouseover(function() {
//		var ev = ev || window.event;
//	    var target = ev.target || ev.srcElement;
	    var index=$(this).index(".pullDownList li");
		if (!($(this).hasClass("menulihover")||$(this).hasClass("menuliselected"))) {
			$($(".yBannerList")[index]).css("display","block").siblings().css("display","none");
			$($(".yBannerList")[index]).removeClass("ybannerExposure");
			setTimeout(function(){
				$($(".yBannerList")[index]).addClass("ybannerExposure");
			},60)
		}else{	
		}
		$(this).addClass("menulihover").siblings().removeClass("menulihover");
		$(this).addClass("menuliselected").siblings().removeClass("menuliselected");
		if(index == 7){
			$(".yMenuListCon").css("display","none");
			$(".yMenuListConin").css("display","none");
			return;
		}
		$(".yMenuListCon").fadeIn();
		$(".yMenuListConin").css("display","none");
		$($(".yMenuListConin")[index]).css("display","block");
	})
	$(".pullDown").mouseleave(function(){
		$(".yMenuListCon").css("display","none");
		$(".yMenuListConin").css("display","none");
		$(".pullDownList li").removeClass("menulihover");
	})
	// 导航左侧栏js效果 end
    
}, 500);

//时间显示
var showLeftTime = function(time){
	$(".sysTime").text(formatDate(time + new Date().getTime(),"HH:mm:ss"));
	//一秒刷新一次显示时间
	setTimeout(function(){showLeftTime(time);},100);
}

var getHotWord = function(){
	$.ajax({
		url:"/goods/hotwords.do",
		type:"post",
		dataType:"json",
		data:{
			
		},
		success:function(result){
			if(result.status){
				var str = [],
				words = JSON.parse(result.words);
				$(words).each(function(index, word){
					str.push('<a href="/goods/allCat'+word.cid+'.html">'+word.word+'</a>');
				});
				$(".search_span_a").html(str.join(""));
			}
		},
		error:function(){
			
		}
	});
}

var menuIndex = function(){
	$.ajax({
		url:"/menuIndexHead.do",
		type:"post",
		dataType:"json",
		data:{
			
		},
		success:function(result){
			if(result.status){
				var lis = "";
				$(result.menus).each(function(index,menu){
					if(menu.title == '全球免税店'){
						lis += '<li><a href="..'+menu.url+'" ><img src="/static/img/front/index/gif_qq.gif" style="position:absolute;top:12px;left:8px;width:20px;"><img src="/static/img/front/index/qq_gif2.gif" style="position:absolute;top:10px;left:33px;width:96px;"></a></li>';
					}else{
						
						lis += '<li><a href="..'+menu.url+'" ';
						/* if(index == 0)
							lis += 'class="yMenua"'; */
						lis += '>'+menu.title+'</a></li>';
					}
				});
				$(".yMenuIndex").html(lis);
			}
		},
		error:function(){
			
		}
	});
}

//加载banner
var categoryIndex = function(flag){
	var url = "/goods/categoryIndex.do";
	if(flag)
		url = "/goods/categoryIndex.do";
	$.ajax({
		url:url,
		type:"post",
		dataType:"json",
		data:{
			
		},
		success:function(result){
			if(result.status){
				var lis_c = [];
				var con = [];
				var leftNav = [];
				var banner = [];
				$(result.categorys).each(function(index1,category){
					
					lis_c.push('<li');
					banner.push('<div style="background:'+(category.categorySlideList.length!=0?category.categorySlideList[0].background:"")+'" class="yBannerList');
					if(index1 == 0){
						//lis_c.push(' class="menulihover"'); 
						banner.push(' ybannerHide');
					}
					lis_c.push('><i class="listi'+(index1+1)+'"></i>');
					if(index1 == 7)
						lis_c.push('<a href="/index.do?yg_sq=true">'+category.cname+'</a>');//一级分类
					else
						lis_c.push('<a href="/goods/allCat'+category.id+'.html" >'+category.cname+'</a>');//一级分类
					lis_c.push('<span></span>');
					lis_c.push('</li>');
					
					var slides = [category.categorySlideList.length>0?category.categorySlideList[0]:{},category.categorySlideList.length>1?category.categorySlideList[1]:{},category.categorySlideList.length>2?category.categorySlideList[2]:{}];
					banner.push('"><div class="yBannerListIn">');
					if(index1 == 7)
						banner.push('<a href="javascript:void(0);"><img class="ymainBanner" src="'+imagePath+slides[0].image+'">');
					else
						banner.push('<a href="/goods/allCat'+category.id+'.html"><img class="ymainBanner" src="'+imagePath+slides[0].image+'">');
					banner.push('</a>');
					banner.push('<div class="yBannerListInRight">');
					banner.push('<a href="'+slides[1].link+'"><img src="'+imagePath+slides[1].image+'"/></a>');
					banner.push('<b class="yimaginaryLine"></b>');
					banner.push('<a href="'+slides[2].link+'"><img src="'+imagePath+slides[2].image+'"/></a>');
					banner.push('</div></div></div>');
					
					leftNav.push('<li><i style="background-position: -22px -'+(22+20*index1)+'px;"></i><em>'+category.cname+'</em><b></b></li>');
					
					con.push('<div class="yMenuListConin">');
					$(category.children).each(function(index2,category){
						if(index2 < 6){
							con.push('<div class="yMenuLCinList">');
							con.push('<h3><a href="/goods/allCat'+category.id+'.html" class="yListName">'+category.cname+'</a><a href="/goods/allCat'+category.id+'.html" class="yListMore">更多 ></a></h3>');//二级分类
							con.push('<p>');
							$(category.brandList).each(function(index3,brand){
								if(index3 < 10){
									con.push('<a href="/goods/allCat'+category.id+'-'+brand.id+'.html"');//品牌
									if(brand.isRecommend === 1)
										con.push(' class="ecolor610"');
									con.push('>'+brand.bname+'</a>');
								}
							});
							con.push('</p></div>');
						}
					});
					con.push('</div>');
					
				});
				$(".pullDownList").append(lis_c.join(""));
				$(".yMenuListCon").append(con.join(""));
				$(".yBanner").html(banner.join(""));
				$(".y-fixed-divs").html(leftNav.join(""));
			}
		},
		error:function(){
			
		}
	});
}


//签到
function sign(){
	var signTime = $('#signTime').val();
	var memberMid = $('#mid').val();
	if(memberMid!=''){
		var date = new Date(signTime*1000);
	    signTime = date.getFullYear().toString()+(date.getMonth() + 1)+date.getDate().toString()+"";
		date = new Date();
	    var today = date.getFullYear().toString()+(date.getMonth() + 1)+date.getDate().toString()+"";
	    if(today!=signTime){
			$.ajax({
				type:'get',
				url:"/member/sign.do",
				dataType:'json',
				success:function(result){
					if(result.status){
						$("#sign").html("已签到");
						$("#memberSign").html("已连续签到"+result.days+"天");
						location.reload(true);
					}
				}
			});
	    }
	}else{
		window.location.href ="/api/uc/login.do";
	}
}
//检查是否签到
function checkSign(){
	var signTime = $('#signTime').val();
	var date = new Date(signTime*1000);
    signTime = date.getFullYear().toString()+(date.getMonth() + 1)+date.getDate().toString()+"";
	date = new Date();
    var today = date.getFullYear().toString()+(date.getMonth() + 1)+date.getDate().toString()+"";
    if(today==signTime || signTime>today){
    	$("#sign").html("已签到")
    	$("#memberSign").html('已连续签到'+$("#signDays").val()+'天');
    }
   
}

//替换undefined
function replaceUndefined(data){
	if(typeof(data) == "undefined"){
		return '';
	}else{
		return data;
	}
}
//跳转商品页面
function gotoGoods(gid,pid){
	window.location.href = "/goods/goods"+gid+"-"+pid+".html";
}

$(function(){
	$.ajax({
		type:'get',
		url:"/getMemberInfo.do",
		data:{
			time:new Date().getTime()
		},
		dataType:'json',
		success:function(result){
			if(result.status && result.user){
				$('.headerul2 li:eq(1)').html('<a href="/member/memberYg/cloudRecord.do">'+result.user.username+'</a>');
				$('.headerul2 li:eq(2)').html('<a href="/member/logout.do">退出</a>');
				$("#mid").val(result.user.mid);
				$("#signTime").val(result.user.signTime);
				$("#signDays").val(result.user.signDays);
				checkSign();
			}
		}
	});
});





