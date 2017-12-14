(function($){
	/*
	* 初始化信息
	* @param element 数字滚动元素
	* @param speed   数字变化速度，数字越大速度越慢
	*
	*/
 NumerBeat = function(element,speed){
 	 this.el = element;
 	 this.speed = speed || '20';
 };
 NumerBeat.prototype = {
 	constructor:NumerBeat,
 	init:function(){
		var beats = this.el;
		for(var i = 0 ; i < $(beats).length; i ++){
			if($(beats)[i].getAttribute("data-rel")){	
				this.beat({box:$(beats)[i]});
			};
		};
	},
	beat:function(o){	
		if(!o.box){return};
		o.v = o.box.getAttribute("data-rel");//最后的数字	
		o.v1 = Number(o.v);
		var m = parseInt(o.v1/this.speed);	//计数跳动时间，数越大，跳动越慢
		if(m < 1){m = 1}
		o.k = this.FloatMul(m,0.56).toFixed(0);	
		var _this = this;
		o.interval = setInterval(function(){_this.add(o)},20);	
		
	},
	fixeds:function(n){
		var _n=n.toString();
		var _ll=_n.split("");
		var _ll2=[];
		var step=1;
		for(var i=_ll.length-1;i>=0;i--){
			/*if(step==4){
				step=0;
				_ll2.push(",");
				i++;
			}else{
				_ll2.push(_ll[i]);
			}*/
			_ll2.push(_ll[i]);
			step++;
		}
		_ll2.reverse();
		return _ll2.join("");
	},
	add:function(o){
		var n = this.FloatAdd(Number(o.box.lang),o.k).toFixed(0);
		if(n >= o.v1){
			clearInterval(o.interval);
			o.box.innerHTML = this.fixeds(o.v);
			return;
		};
		o.box.lang=n;
		o.box.innerHTML  = this.fixeds(n);
	},
	FloatAdd:function(f,d){
		var c,b,a;
		try{
			c=f.toString().split(".")[1].length
		}catch(g){c=0}
		try{
			b=d.toString().split(".")[1].length
		}catch(g){b=0}
		a=Math.pow(10,Math.max(c,b));
		return(f*a+d*a)/a
	},
	FloatMul:function(d,b){
		var a=0,
		f=d.toString(),
		c=b.toString();
		try{
			a+=f.split(".")[1].length
		}catch(g){}
		try{
			a+=c.split(".")[1].length
		}catch(g){}
		return Number(f.replace(".",""))*Number(c.replace(".",""))/Math.pow(10,a)
	},
	numberMove:function(){
		this.el.each(function(index, element) {
			var _data = $(this);
				var iLength = _data.attr("data-rel").length;
				var sInnerHtml = '';
				for(var i=0;i<iLength-1;i++){
					sInnerHtml += '0';
				}
		});
		
	}

 }
})(jQuery)
