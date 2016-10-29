var formatDate = function(date,format){if(!format)format="yyyy-MM-dd HH:mm:ss";date=new Date(parseInt(date));var dict={"yyyy":date.getFullYear(),"M":date.getMonth()+1,"d":date.getDate(),"H":date.getHours(),"m":date.getMinutes(),"s":date.getSeconds(),"S":date.getMilliseconds(),"MM":(""+(date.getMonth()+101)).substr(1),"dd":(""+(date.getDate()+100)).substr(1),"HH":(""+(date.getHours()+100)).substr(1),"mm":(""+(date.getMinutes()+100)).substr(1),"ss":(""+(date.getSeconds()+100)).substr(1)};return format.replace(/(y+|M+|d+|H+|s+|m+|S)/g,function(a){return dict[a]})};
/**
 * 描述：图片延迟加载
 * 
 * */
function lazyload200(id){
	//设置图片延迟加载  距离屏幕100像素开始加载图片
	$("img.lazy"+id).lazyload({
		effect : "fadeIn",
		placeholder : "/static/img/front/loading_200.gif",
		threshold : 100,
		skip_invisible : false
	});
	
}

//根据id获取商品详情
var goodsDetails = function(id){
	$.ajax({
		url:"/goods/goods4.do",
		type:"post",
		dataType:"json",
		data:{
			id:id
		},
		success:function(result){
			if(result.status){
				
				// 如果取回的数据中  goods 数组不存在，则创建空数组
				if (!result.goods) result.goods = [];
				// 首页每个楼层的二级分类下可以展示四个商品
				for (var i = 0; i < 4; i++){
					var good = result.goods[i];
					// 如果根据当前下标能渠道商品，则展示该商品，如果取不到，则填充“敬请期待”图片
					if (good){
						var str = [];
						str.push('<div class="w_imgOut" data-gid="'+good.gid+'" data-pid="'+good.periodCurrent+'"><a class="w_goods_img" data-gid="'+good.gid+'" data-pid="'+good.periodCurrent+'" href="javascript:void 0"><img class="lazy'+id+'" data-original="'+imageGoodsPath+good.showImages.split(',')[0]+'" data-gid="'+good.gid+'" data-pid="'+good.periodCurrent+'"><noscript><img src="'+imageGoodsPath+good.showImages.split(',')[0]+'" alt=""></noscript></a></div>');
						str.push('<a class="w_goods_three" href="javascript:void 0" title="'+good.title+'" data-gid="'+good.gid+'" data-pid="'+good.periodCurrent+'">(第'+good.periodCurrent+'期) '+good.title+'</a><b>价值：￥'+good.priceTotal+'</b>');
						str.push('<div class="w_line"><span style="width:'+(good.priceSell/good.priceTotal*100 === 0 || good.priceSell/good.priceTotal*100 >= 1 ? good.priceSell/good.priceTotal*100 : 1)+'%"></span></div>');
						str.push('<ul class="w_number"><li class="w_amount">'+good.priceSell+'</li><li class="w_amount">'+good.priceTotal+'</li><li class="w_amount">'+(good.priceTotal-good.priceSell)+'</li><li>已云购次数</li><li>总需人次</li><li>剩余人次</li></ul>');
						str.push('<dl class="w_rob"><dd><a class="w_slip" data-gid="'+good.gid+'" data-pid="'+good.periodCurrent+'" href="javascript:void 0">立即抢购</a></dd></dl>');
						$(".goods"+id).append('<li class="w_goods_details">'+str.join("")+'</li>');
					} else {
						$(".goods"+id).append('<li class="w_goods_details" style="background:url(\'/static/img/front/goods/expect.jpg\') no-repeat center 0;"></li>');
					}
				}
				
				lazyload200(id);
			}
		},
		error:function(){
			
		}
	});
	
	
}
//根据商品的一级栏目加载商品楼层
var gailou = function(){
	
	$.ajax({
		url:"/goods/categoryIndex.do",
		type:"post",
		dataType:"json",
		data:{
			
		},
		success:function(result){
			if(result.status){
				$(result.categorys).each(function(indexOut,category){
					
					// 只加载到 7F，因为 8F 的 “抢购社区” 要做特殊处理
					if (indexOut > 6) return;
					
					var str = [];//放商品的容器
					
					str.push('<div class="yCon yCon'+indexOut+' yConCenter"><h2><i>'+(indexOut+1)+'F</i><a href="/goods/allCat'+category.id+'.html" class="yCon-title">'+category.cname+'</a><a href="/goods/allCat'+category.id+'.html" class="yMoreLink"><em>更多</em></a><ul>');
					str.push('</ul></h2>');
					str.push( '<div class="yConCenterIn"></div></div>');
					$(".yContent").append(str.join(""));
					
					var s = [];//二级分类
					var goodstr = [];//每个分类的商品
					$(category.children).each(function(indexIn,category){
						if(indexIn<6){
							s.push('<li><a href="/goods/allCat'+category.id+'.html" ');	
							if(indexIn==0){
								s.push('class="yhoversH1List"');
								goodstr.push('<div class="y_btn_all y_btn_left"><i></i></div><div class="y_btn_all y_btn_right"><i></i></div>');
							}
							s.push('>'+category.cname+'</a></li>');
							goodstr.push('<div class="yConCenterInList"');
							if(indexIn==0)
								goodstr.push(' style="display:block;"');
							goodstr.push('><ul class="w_goods_one goods'+category.id+'">'); 
							
							goodstr.push('</ul></div>');
						}
					});
					$(".yCon"+indexOut+" ul").append(s.join("")+'<span></span>');
					$(".yCon"+indexOut+" .yConCenterIn").append(goodstr.join(""));
					
				});
				addAd();
				addHover();
				$(result.categorys).each(function(indexOut,category){
					
					$(category.children).each(function(indexIn,category){
						setTimeout(function(){goodsDetails(category.id);}, 300*indexIn);
					});
					
				});
			}
		},
		error:function(){
			
		}
	});
	
	
}
//加载最新揭晓的商品信息
var jiexiao = function(){
	$.ajax({
		url:"/goods/jiexiaoIndex.do",
		type:"post",
		dataType:"json",
		data:{
			
		},
		success:function(result){
			if(result.status){
				$(".yConulout ul").empty();
				var str;
				$(result.pageModel.dataList).each(function(index,goods){
					str = [];
					
					str.push('<li class="goods'+goods.gid+'_'+goods.period+'"><dl>');
					str.push('<dd class="yddImg"><a href="/goods/goods'+goods.gid+'-'+goods.period+'.html" target="_blank"><img class="lazyjx" data-original="'+imageGoodsPath+goods.showImages.split(',')[0]+'"><noscript><img src="'+imageGoodsPath+goods.showImages.split(',')[0]+'" alt=""></noscript></a></dd>');
					str.push('<dd class="yddName">恭喜 <a href="/other/cloudRecord/'+eval('('+goods.userInfo+')').mid+'.html" class="yddNameas">'+eval('('+goods.userInfo+')').nickname+'</a> 获得</dd>');
					str.push('<dd class="yGray"><a href="/goods/goods'+goods.gid+'-'+goods.period+'.html" target="_blank">(第'+goods.period+'期)'+goods.title+'</a></dd>');
					str.push('<dd class="yGray">幸运号码：'+goods.userWinCode+'</dd>');
					str.push('</dl><i></i></li>');
					
					$(".yConulout ul").width($(".yConulout ul").width()+243);
					$(".yConulout ul").append(str.join(""));
					
					lazyload200('jx');
					
				});
				//如果最新揭晓少于5个用图片补空
				var len = result.pageModel.dataList.length;
				for(var i=len;i<5;i++){
					$(".yConulout ul").width($(".yConulout ul").width()+243);
					$(".yConulout ul").append('<li style="background:url(/static/img/front/index/jiexiao.jpg) no-repeat center 0;"></li>');
				}
				jiexiaoNew();
			}
		},
		error:function(){
			
		}
	});
	
}
//获取首页通知
var notices = function(){
	$.ajax({
		url:"/notices.do",
		type:"post",
		dataType:"json",
		data:{
			
		},
		success:function(result){
			if(result.status){
				var str = [];
				$(result.notices).each(function(index, notice){
					str.push('<li><p class="yscrollfont"><a href="/footer/new_dynamic.do" title="'+notice.title+'">'+notice.title+'</a>');
					str.push('</p><p class="yscrolltime">'+formatDate(notice.publishTime, "yyyy/MM/dd")+'</p></li>');
				});
				$(".yscroll_list_left").html(str.join(""));
			}
		},
		error:function(){
			
		}
	});
}

//首页下晒单
var shaidan = function(page){
	$.ajax({
		url:"/other/allshow.do",
		type:"post",
		dataType:"json",
		data:{
			page:page,
			size:6,
			indexShow:"sd"
		},
		success:function(result){
			if(result.status){
				var str = [];
				if(result.showsPage.total > 0){
					$(result.showsPage.dataList).each(function(index,show){
					
						str.push('<li><a href="/other/sunSingleDetail/'+show.showId+'-'+show.mid+'.html" class="List2Imga"><img class="lazysd" data-original="'+show.photos.split(",")[0]+'"><noscript><img src="'+show.photos.split(",")[0]+'" alt=""></noscript></a>');
						str.push('<div class="List2ImgRight"><p><a href="/other/sunSingleDetail/'+show.showId+'-'+show.mid+'.html">'+show.title+'</a></p></div></li>');
						
					});
					$(".yCon8CenterinList2 ul").html(str.join(""));
					lazyload200('sd');
				}else{
					$(".yCon8Centerscroll").html('<div class="w_empty_img"><img src="/static/img/front/index/shan.jpg"/><a class="w_add_tiao" href="/member/memberYg/prizePage.do">你晒单，我送积分</a></div>');
				}
			}
		},
		error:function(){
			
		}
	});
}

//加载广告位
var addAd = function(){
	
	$.ajax({
		url:"/cms/ads.do",
		type:"post",
		dataType:"json",
		data:{
			
		},
		success:function(result){
			if(result.status){
				result.ads.floor1 && addAdFun(1, result.ads.floor1);
				result.ads.floor2 && addAdFun(2, result.ads.floor2);
				result.ads.floor3 && addAdFun(3, result.ads.floor3);
				result.ads.floor4 && addAdFun(4, result.ads.floor4);
				result.ads.floor5 && addAdFun(5, result.ads.floor5);
				result.ads.floor6 && addAdFun(6, result.ads.floor6);
				result.ads.floor7 && addAdFun(7, result.ads.floor7);
				result.ads.floor8 && addAdFun(8, result.ads.floor8);
				for(var i=0,len=$(".aBJCon").length; i<len; i++){
					adHH(i);
				}
			}
		},
		error:function(){
			
		}
	});
	
}
var addAdFun = function(index, objs){
	if(objs){
		var str = [];
		str.push('<div class="aBJCon">');
		$(objs).each(function(index, obj){
			str.push('<a href="'+obj.link+'" title="'+obj.description+'"><img src="'+imagePath+obj.img+'"></a>');
		});
		str.push('</div>');
		$(".yCon"+index).before(str.join(""));//添加广告
	}
}
//为所有的商品添加点击跳转事件
var addClick = function(){
	$(".yContent").delegate(".w_goods_three,.w_imgOut,.w_slip", "click", function(ev){
	    var ev = ev || window.event;
	    var target = ev.target || ev.srcElement;
	    var gid = $(target).attr("data-gid");
	    var pid = $(target).attr("data-pid");
	    window.open('goods/goods'+gid+'-'+pid+'.html');
	});
}

/**
 * 跑秒动画产生效果函数
 * 参数说明：times - 要跑秒时长+new Date().getTime()
 * 			 objc  - 跑秒要显示的位置
 * 特别说明：① - 此句中的new Date().getTime()只是为形成跑秒动画效果而使用的，和跑秒的时间长短无关
 * 				  即使用户浏览器或电脑系统时间不同，但每次打开网页显示的时间跑秒动画是统一的
 */
var t = {}
function Time_fun(times,objc,gid,pid){               
	t.time = times - (new Date().getTime());//①
	t.h = parseInt((t.time/1000)/60/60%24);//时
	t.i = parseInt((t.time/1000)/60%60);
	t.s =  parseInt((t.time/1000)%60);
	t.ms =  String(Math.floor(t.time%1000));
	t.ms = parseInt(t.ms.substr(0,2));
	if(t.h<10)t.h='0'+t.h; //剩余时
	if(t.i<10)t.i='0'+t.i; //剩余分钟
	if(t.s<10)t.s='0'+t.s; //剩余秒
	if(t.ms<0)t.ms='00'; //剩余毫秒
	t.oh=String(t.h).slice(0,1);
	t.th=String(t.h).slice(1);
	t.oi=String(t.i).slice(0,1);
	t.ti=String(t.i).slice(1);
	t.os=String(t.s).slice(0,1);
	t.ts=String(t.s).slice(1);
	t.oms=String(t.ms).slice(0,1);
	t.tms=String(t.ms).slice(1);
	if(t.h>0)
		objc.find("p").html("<b>"+t.oh+"</b><b>"+t.th+"</b><span>:</span><b>"+t.oi+"</b><b>"+t.ti+"</b><span>:</span><b>"+t.os+"</b><b>"+t.ts+"</b>");   
	else
		objc.find("p").html("<b>"+t.oi+"</b><b>"+t.ti+"</b><span>:</span><b>"+t.os+"</b><b>"+t.ts+"</b><span>:</span><b>"+t.oms+"</b><b>"+t.tms+"</b>");   
	if(t.time<=0){     
		objc.find("p").addClass("timeing");           
	    objc.find("p").html('正在计算，请稍后...');
	    setTimeout(function(){
	    	info(gid,pid);
	    },10000);                             
	    return;                     
	}
	setTimeout(function(){                                 
    	Time_fun(times,objc,gid,pid);                 
	},30); 
}

//定时获取揭晓商品的信息
var jiexiaoNew = function(){
	$.ajax({
		url:"/goods/jiexiaoNew.do",
		type:"post",
		dataType:"json",
		data:{
			
		},
		success:function(result){
			if(result.status){
				
				var str = [];
				$(result.goods).each(function(index,goods){
					if($(".goods"+goods.gid+"_"+goods.periods).attr("class")!="yTimesLi goods"+goods.gid+"_"+goods.periods){
						
						str.push('<li class="yTimesLi goods'+goods.gid+'_'+goods.periods+'"><dl class="yTimesDl">');
						str.push('<dd class="yddImg"><a href="/goods/goods'+goods.gid+'-'+goods.periods+'.html" target="_blank"><img class="lazyjxn" data-original="'+imageGoodsPath+goods.showImages.split(',')[0]+'"><noscript><img src="'+imageGoodsPath+goods.showImages.split(',')[0]+'" alt=""></noscript></a></dd>');
						str.push('<dd class="yddName"><a href="/goods/goods'+goods.gid+'-'+goods.periods+'.html" target="_blank">(第'+goods.periods+'期)'+goods.title+'</a></dd>');
						str.push('<dd class="yGray">价值  <span>￥'+goods.totalPrice+'</span></dd>');
						str.push('<dd class="yTimes"><p><b>0</b><b>0</b><span>:</span><b>0</b><b>0</b><span>:</span><b>0</b><b>0</b></p></dd>');
						str.push('</dl><strong></strong></li>');
						
						$(".yConulout ul").width($(".yConulout ul").width()+243);
					}
					
				});
				$(".yConulout ul").prepend(str.join(""));
				lazyload200('jxn');
				$(result.goods).each(function(index,goods){
					var objc=$($(".goods"+goods.gid+"_"+goods.periods+" .yTimesDl .yTimes")[0])
					if(goods.expectPublishTime - result.now > 0){
						Time_fun( goods.expectPublishTime - result.now + new Date().getTime(), objc, goods.gid, goods.periods);
					}else{
						objc.find("p").addClass("w_waiting").html('福彩中心通讯故障~请耐心等待');
					}
					
				});
				
			}
		},
		error:function(){
			
		}
	});
	
}
//商品揭晓信息
var info = function(gid, pid){
	$.ajax({
		url:'/goods/querygoods.do',
		type:'post',
		dataType:"json",
		data:{
			gid:gid,
			pid:pid
		},
		success:function(result){
			if(result.status ){
				var goods = result.goods;
				var p = goods.period || goods.periodCurrent;
				if(p == pid && goods.userWinCode){//返回来的商品详情期数不对应或没有云购码则揭晓失败
//					$(".goods"+gid+"_"+pid).remove();
					var str = [];
					str.push('<dl>');
					str.push('<dd class="yddImg"><a href="/goods/goods'+goods.gid+'-'+goods.period+'.html" target="_blank"><img src="'+imageGoodsPath+goods.showImages.split(',')[0]+'"></a></dd>');
					str.push('<dd class="yddName">恭喜 <a href="/other/cloudRecord/'+eval('('+goods.userInfo+')').mid+'.html" class="yddNameas">'+eval('('+goods.userInfo+')').nickname+'</a> 获得</dd>');
					str.push('<dd class="yGray"><a href="/goods/goods'+goods.gid+'-'+goods.period+'.html" target="_blank">(第'+goods.period+'期)'+goods.title+'</a></dd>');
					str.push('<dd class="yGray">幸运号码：'+goods.userWinCode+'</dd>');
					str.push('</dl><i></i>');
//					$(".yConulout ul").width($(".yConulout ul").width()+243);
//					$(".yConulout ul").prepend(str.join(""));
					$(".goods"+gid+"_"+p).html(str.join(""));
				}else{
					$($(".goods"+gid+"_"+pid+" .yTimesDl .yTimes")[0]).find("p").removeClass("timeing").addClass("w_waiting").html('福彩中心通讯故障~请耐心等待');
				}
			}
		},
		error:function(){
			
		} 
	});
}
function newsList() {
	$.ajax({  
        type : "get",  
        async:false,  
        url : "http://bbs.ygqq.com/java.php",  
        dataType : "jsonp",//数据类型为jsonp  
        jsonp: "jsonpCallback",//服务端用于接收callback调用的function名的参数  
        success : function(data){
    		var $newsList = $("#newsList")
    		for (var i = 0; i < 4; i++) {
    			var news = data[i];
    			var datetime = new Date(parseInt(news.time) * 1000);
    			var href = "http://bbs.ygqq.com/viewthread-"+news.id+".html";
    			$newsList.append([
    			         "<li>",
    				         "<div class='yCon8Calendar'>",
    					         "<b>",datetime.getDate(),"</b></br>",
    					         "<span>",datetime.getFullYear(),"-",(datetime.getMonth()+1),"</span>",
    				         "</div>",
    				         "<div class='yCon8Li1a'><a href='",href,"' title='",news.title,"' target='_blank'><span>",news.title,"</span></a><span class='new-con8Cale-span'>",news.news || news.title,"</span></div>",
    			         "</li>"
    			     ].join(""));
    			
    		}
        },  
        error:function(){  
            alert('fail');  
        }  
    });
}

$(function(){
	
	notices();
	
	gailou();
	jiexiao();
	setInterval(jiexiaoNew,30000);
	addClick();
	//alert(new Date().getTime());
	shaidan();
	// 加载抢购咨询列表
	newsList();
	
	
});
