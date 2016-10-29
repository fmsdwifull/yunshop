$(function() {
    var a = $("#cartBody");	
    var c = $("#divNone");
    var b = function() {
        var o = "";
        var h = $("#divTopMoney");
        var g = $("#divBtmMoney");
        var e = function(t, s, r, q) {
            $.PageDialog.fail(t, s, r, q)
        };
        var n = function(s, r, q) {
            $.PageDialog.confirm(s, r, q)
        };
        if (h.length > 0) {
            h.children("a").click(function() {
                location.href = Gobal.Webpath+"/mobile/cart/pay"   //付款页面
            })
        }
        g.children("a").click(function() {		
            location.href = Gobal.Webpath+"/mobile/cart/pay"      //付款页面
        });
        
		/* 更新divTopMoney,divBtmMoney的内容 */
		var m = function() {
            var q = 0;
            var r = 0;
            $("input:text[name=num]", a).each(function(s) {
                var t = parseInt($(this).val());
                if (!isNaN(t)) {
                    r += t;
                    q += t;
                }
            });
			$("input:text[name=g_num]", a).each(function(s) {
                var t = parseInt($(this).val());
				var price = $(this).attr('g_jiage');
				var money = t * price;
                if (!isNaN(t)) {
                    r += t;
                    q += money;
                }
            });
			var moneyCount = q.toFixed(2);
            if (moneyCount > 0) {
                if (h.length > 0) {
                    h.children("span").html(moneyCount)
                }
                g.children("p").html('总共购买<span class="orange arial z-user">' + r + '</span>个商品  合计金额：<span class="orange arial">' + moneyCount + "</span> 元")
            } else {
                g.remove();
            }
        };
		
		/* 
		*	input输入框的计算及验证
		*/
        var d = function() {
            var z = $(this);
            var t = z.attr("id");
            var v = t.replace("txtNum", "");
            var q = z.next().next();
            var r = parseInt(z.next().next().next().val());
            var s, y, w = /^[1-9]{1}\d{0,6}$/;
            var u;
            o = t;
            var x = function() {
                if (o != t) {
                    return
                }
                s = q.val();
                y = z.val();
                if (y != "" && s != y) {
                    var B = $(window).width();
                    var A = (B) / 2 - z.offset().left - 127;
                    if (w.test(y)) {
                        u = parseInt(y);
                        if (u <= r) {
                            q.val(y)
                        } else {
                            u = r;
                            e("最多" + u + "人次", z, -75, A);
                            z.val(u);
                            q.val(u)
                        }
                        p(u, z);
						 
                        j(z, v, u);
                        i(z, u, r);
                        m()
                    } else {
                        e("只能输正整数哦", z, -75, A);
                        z.val(s)
                    }
                }
                setTimeout(x, 200)
            };
            x()
        }; 
		
		var g_d = function() {
            var z = $(this);
            var t = z.attr("id");
            var v = t.replace("txtNum", "");
            var q = z.next().next();
            var r = parseInt(z.next().next().next().val());
            var s, y, w = /^[1-9]{1}\d{0,6}$/;
            var u;
            o = t;
            var x = function() {
                if (o != t) {
                    return
                }
                s = q.val();
                y = z.val();
                if (y != "" && s != y) {
                    var B = $(window).width();
                    var A = (B) / 2 - z.offset().left - 127;
                    if (w.test(y)) {
                        u = parseInt(y);
                        if (u <= r) {
                            q.val(y)
                        } else {
                            u = r;
                            e("最多" + u + "人次", z, -75, A);
                            z.val(u);
                            q.val(u)
                        }
                        p(u, z);
						 
                        g_j(z, v, u);
                        i(z, u, r);
                        m()
                    } else {
                        e("只能输正整数哦", z, -75, A);
                        z.val(s)
                    }
                }
                setTimeout(x, 200)
            };
            x()
        };
       
		/* 
		*	提示信息：超过100显示信息
		*	@ r: 购买数量
		*	@ u: 购买数量的input对象
		*/
		var p = function(r, u) {
            var t = u.parent().parent().parent();
            var q = t.find("div.z-Cart-tips");
            if (r > 100) {
                if (q.length == 0) {
                    var s = $('<div class="z-Cart-tips">已超过100人次，请谨慎参与！</div>');
                    t.prepend(s);
                }
            } else {
                q.remove();
            }
        };
       
		/* 
		*	更新 input 输入框的值
		*/
		var l = function() {
            var q = $(this);
            if (o == q.attr("id")) {
                o = "";
            }
            if (q.val() == "") {
                q.val(q.next().next().val());
            }
        };
		
		/* 
		*	function：修改小计，并发送到服务器修改购物车
		*	@ q:购买数量的input 对象
		*	@ t:商品id
		*	@ r:购买数量
		*/
        var j = function(q, t, r) {
            var s = function(w) {
                if (w.code == 1) {
                    var v = $(window).width();
                    var u = (v) / 2 - q.offset().left - 127;
                    e("本期商品已购买光了", q, -75, u)
                } else {
                    if (w.code == 0) {
                        q.parent().prev().html('总共购买：<em class="arial">' + r + '</em>人次/<em class="orange arial">￥' + r + ".00</em>")
                    }
                }
            };
            GetJPData(Gobal.Webpath, "ajax", "addShopCart/" + t + "/" + r+"/cart", s)
        };
		
		var g_j = function(q, t, r) {
            var s = function(w) {
                if (w.code == 1) {
                    var v = $(window).width();
                    var u = (v) / 2 - q.offset().left - 127;
                    e("本期商品已购买光了", q, -75, u)
                } else {
                    if (w.code == 0) {
						var price = q.attr('g_jiage');
						var money = (price * r).toFixed(2);
                        q.parent().prev().html('单价：<em class="arial" style="padding-right:10px;">'+ price +' </em>数量：<em class="arial" style="padding-right:10px;">'+r+'</em>小计：<em class="orange arial">￥'+money+'</em>')
                    }
                }
            };
			
            GetJPData(Gobal.Webpath, "ajax", "g_addShopCart/" + t + "/" + r+"/cart", s);
        };
		
		/* 
		*	执行加减操作 
		*	@ w：表数字
		*	@ v: 表 购买数量的input 对象
		*/
        var k = function(w, v) {
            var u = v.attr("id");
            var s = u.replace("txtNum", "");	// 获取商品id
            var r = parseInt(v.next().next().next().val());		// 获取 剩余值
            var q = v.next().next();		// 获取 购买对象
            var t = parseInt(q.val()) + w;	// 获取 要购买值
            if (t > 0 && t <= r) {
                i(v, t, r);			// 更新加减操作样式
                q.val(t);
                v.val(t);
                p(t, v);
                j(v, s, t);
                m();
            }
        };
		
		var g_k = function(w, v) {
            var u = v.attr("id");
            var s = u.replace("txtNum", "");
            var r = parseInt(v.next().next().next().val());
            var q = v.next().next();
            var t = parseInt(q.val()) + w;
            if (t > 0 && t <= r) {
                i(v, t, r);		
                q.val(t);
                v.val(t);
                p(t, v);
                g_j(v, s, t);
                m();
            }
        };
		
		/* 
		*	更新加减操作样式
		*	@ r 表 购买数量的input 对象
		*	@ t 表要购买值
		*	@ s 表剩余值
		*/
        var i = function(r, t, s) {
            var q = r.prev();		// 获取加操作对象
            var u = r.next();		// 获取减操作对象
            if (s == 1) {
                q.addClass("z-jiandis");
                u.addClass("z-jiadis")
            } else {
                if (t == 1) {
                    q.addClass("z-jiandis");
                    u.removeClass("z-jiadis");
                } else {
                    if (t == s) {
                        q.removeClass("z-jiandis");
                        u.addClass("z-jiadis");
                    } else {
                        q.removeClass("z-jiandis");
                        u.removeClass("z-jiadis");
                    }
                }
            }
        };
        
		/* 给input标签，加，减 绑定事件 */
		$("input:text[name=num]", a).each(function(q) {
            var r = $(this);
            r.bind("focus", d).bind("blur", l);
            r.prev().bind("click",
				function() {
					k( - 1, r);
				}
			);
            r.next().bind("click",
            function() {
                k(1, r);
            })
        });
		
		$("input:text[name=g_num]", a).each(function(q) {
            var r = $(this);
            r.bind("focus", g_d).bind("blur", l);
            r.prev().bind("click",
            function() {
                g_k( - 1, r);
            });
            r.next().bind("click",
            function() {
                g_k(1, r);
            })
        });
		
		/* 
		*	function : 购物车 显示与隐藏
		*/
        var f = function() {
            var q = $("li", "#cartBody");
            if (q.length < 1) {
                a.parent().remove();				
                c.show()
            } else {
                if (q.length < 4) {
                    h.remove();
                }
            }
        };
		
		/* 
		*	function：删除操作
		*/
        $("a[name=delLink]", a).each(function(q) {
            $(this).bind("click",
            function() {			 
                var r = $(this);
                var t = r.attr("cid");
                var s = function() {
                    var u = function(v) {					 
                        if (v.code == 0) {
                            r.parent().parent().parent().remove();
                            m();
                            f();
                        } else {
                            e("删除失败，请重试")
                        }
                    };
                    GetJPData(Gobal.Webpath, "ajax", "delCartItem/" + t, u)
                };
                n("您确定要删除吗？", s)
            })
        })
		$("a[name=g_delLink]", a).each(function(q) {
            $(this).bind("click",
            function() {			 
                var r = $(this);
                var t = r.attr("cid");
                var s = function() {
                    var u = function(v) {					 
                        if (v.code == 0) {
						
                            r.parent().parent().parent().remove();
                            m();
                            f()
                        } else {
                            e("删除失败，请重试")
                        }
                    };
                    GetJPData(Gobal.Webpath, "ajax", "g_delCartItem/" + t, u)
                };
                n("您确定要删除吗？", s)
            })
        })
    };
	 
    if (a.length > 0) {
        Base.getScript(Gobal.Skin + "/js/mobile/pageDialog.js", b)
    } else {
        c.show()
    }
});