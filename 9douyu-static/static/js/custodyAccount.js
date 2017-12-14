;(function($){
	// 存管账户custodyAccount输入信息验证
	/**** 页面调用样例一
	* html结构
		<input  class="v4-input">
        <span class="v4-input-status"></span>
	    $.validation('.v4-input');

	**** 页面调用样例二
	* html结构
		<input  class="v4-input error">
		$.validation('.v4-input',{
	 	   className:'error'
	    });

	 */
	

	$.validation = function(ele,options){
		this.ele = ele ;
		this.default = {
			tip:'.v4-input-status', //信息状态提示
			errorMsg:'#v4-input-msg', //错误提示框
			className:null //输入框错误样式
		};
		this.opts = $.extend({}, this.default, options);

		// 开户姓名检验规则（4~8位汗字）
		var patternName = /^[\u4e00-\u9fa5]{2,10}$/; 

		// 二代身份证号检验规则（17位数字，最后一位数字或字母）
		var patternIdcard = /^\d{17}[a-zA-Z0-9]$/; 

		// 银行卡号检验规则（16~19位数字）
		var patternBankcard = /^\d{16,19}$/; 

		// 新支付密码检验规则（6位数字）
		var patternPasswordTrading = /^\d{6}$/; 

		// 手机号码检验规则（11位数字）
		var patternPhone = /^\d{11}$/; 

		// 手机验证码检验规则（4~8位数字）
		var patternPhonecode = /^\d{4,8}$/;

		// 充值金额检验规则（大于1元整数）
		var patternAmountRecharge = /^[1-9]\d*$/;

		// 零钱计划转出
		var patternTurnOut = /^\d+\.?\d{0,2}$/;

		// 提现金额检验规则（大于100元整数）
		var patternAmountWithdraw = /^[1-9]\d{2,}$/;

		// 密码检验规则（6-16字母及数字组合）
		var patternPassword = /^(?=.*?\d)(?=.*?[a-zA-Z])[\da-zA-Z]{6,16}$/; 

		// 密码检验规则（6-16字母及数字组合,可以有特殊字符）原始密码
		var patternPasswordOld = /^(?![0-9]+$)(?![a-z]+$).{6,16}$/i; 

		// 校验码检验规则（5字母及数字组合）
		var patternCheckcode = /^[\da-zA-Z]{5}$/; 

		// 邮箱检验规则
		var patternEmail = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,5}$/; 

		
		var opts = this.opts;

		$.each($(ele),function(){
				$(this).on('focus',function(){//输入框聚焦
					if(opts.className){//如果传入错误样式
						$(this).removeClass(opts.className);
					}else{
						$(this).siblings(opts.tip).find('i').removeClass('error').html('');
					};
					$(opts.errorMsg).empty();
					

				});

				$(this).on('blur',function(){//输入框失焦
					if($(this).data('pattern')){

						var patternReg = $(this).data('pattern'),
							val = $.trim($(this).val()),
							result ,
							msg ;

						var inputTextMsg = {
				            'name': '请输入正确的姓名',
				            'idcard': '请输入正确的身份证号',
				            'bankcard': '银行卡号有误，请重新输入',
				            'phone': '请输入银行卡绑定的手机号',
				            'phonecode': '请输入短信验证码',
				            'amountrecharge': '请输入充值金额，最低1元',
				            'turnout': '请输入转出金额',
				            'amountwithdraw': '请输入提现金额，最低100元',
				            'password': '请输入6-16字母及数字组合' ,
				            'passwordOld': '请输入原始密码' ,
				            'passwordSec': '请输入6-16字母及数字组合' ,
				            'checkcode': '请输入校验码' ,
				            'registerpassword': '请输入正确的密码' ,
				            'registerphone': '请输入正确的手机号' ,
				            'email': '请输入正确的邮箱地址 ',
				            'passwordTrading':'请输入6位纯数字密码' 

				        }
				        msg = inputTextMsg[$(this).data("pattern")];
						switch (patternReg)
						{
							case 'name':
							result = patternName.test(val);
							break;

							case 'idcard':
							result = patternIdcard.test(val);
							break;

							case 'bankcard':
							result = patternBankcard.test(val);
							break;

							case 'phone':
							result = patternPhone.test(val);
							break;

							case 'phonecode':
							result = patternPhonecode.test(val);
							break;

							case 'amountrecharge':
							result = patternAmountRecharge.test(val);
							break;

							case 'turnout':
							result = patternTurnOut.test(val);
							break;

							case 'amountwithdraw':
							result = patternAmountWithdraw.test(val);
							break;

							case 'password':
							result = patternPassword.test(val);
							break;

							case 'passwordOld':
							result = patternPasswordOld.test(val);
							break;

							case 'passwordSec':
							result = patternPassword.test(val);
							break;

							case 'checkcode':
							result = patternCheckcode.test(val);
							break;

							case 'registerphone':
							result = patternPhone.test(val);
							break;

							case 'registerpassword':
							result = patternPassword.test(val);
							break;

							case 'email':
							result = patternEmail.test(val);
							break;

							case 'passwordTrading':
							result = patternPasswordTrading.test(val);
							break;


						};

						if($(this).data('optional')){ //如果为选填项 data-optional='optional'
							if(val ==''){

							}else if(result && val !=''){
								if(opts.className){//如果传入错误样式
									$(this).removeClass(opts.className).data('error','')
								}else{
									$(this).data('error',null).siblings(opts.tip).find('i').removeClass('error').html('&#xe69f;');
								}
								$(opts.errorMsg).empty();

							}else if(!result){

								if(opts.className){
									$(this).addClass(opts.className).data('error','error')
								}else{
									
									$(this).data('error','error').siblings(opts.tip).find('i').addClass('error').html('&#xe69d;');
								}
								

								$(opts.errorMsg).html(msg);

							}
						}else{ //必填项


							if(result  && val !=''){
								if(opts.className){//如果传入错误样式
									$(this).removeClass(opts.className).data('error','')
								}else{
									$(this).data('error',null).siblings(opts.tip).find('i').removeClass('error').html('&#xe69f;');
								}
								$(opts.errorMsg).empty();

							}else{

								if(opts.className){
									$(this).addClass(opts.className).data('error','error')
								}else{
									
									$(this).data('error','error').siblings(opts.tip).find('i').addClass('error').html('&#xe69d;');
								}
								

								$(opts.errorMsg).html(msg);

							}

						}

					}

				});
			});
	};

// 表单提交验证，可传入三个参数
	$.formSubmitF = function(formEle,options){
		this.formEle = formEle ;
		this.Default = {
			fromTip:'.v4-input-status', //信息状态提示
			fromErrorMsg:'#v4-input-msg', //错误提示框
			fromT:'#custodyAccount',//当前表单
			className:null //输入框错误样式
		};
		this.opts = $.extend({}, this.Default, options);
		var formTextMsg = {
            'name': '请输入真实姓名',
            'idcard': '请输入身份证号',
            'bankcard': '请输入银行卡号',
            'phone': '请输入手机号',
            'phonecode': '请输入短信验证码',
            'amountrecharge': '请输入充值金额，最低1元',
            'turnout': '请输入转出金额',
            'amountwithdraw': '请输入提现金额，最低100元',
            'password': '请输入密码' ,
            'passwordOld': '请输入原始密码' ,
            'registerpassword': '请输入密码' ,
            'passwordSec': '请输入确认密码' ,
            'checkcode': '请输入校验码' ,
            'registerphone': '请输入手机号' ,
            'email': '请输入邮箱地址 ' ,
            'passwordTrading':'请输入支付密码' 

	        };
        var inputTextMsg = {
            'name': '请输入正确的姓名',
            'idcard': '请输入正确的身份证号',
            'bankcard': '银行卡号有误，请重新输入',
            'phone': '请输入银行卡绑定的手机号',
            'phonecode': '请输入短信验证码',
            'amountrecharge': '请输入充值金额，最低1元',
            'turnout': '请输入转出金额',
            'amountwithdraw': '请输入提现金额，最低100元',
            'password': '请输入6-16字母及数字组合' ,
            'passwordOld': '请输入原始密码' ,
            'passwordSec': '请输入6-16字母及数字组合' ,
            'checkcode': '请输入校验码' ,
            'registerpassword': '请输入正确的密码' ,
            'registerphone': '请输入正确的手机号' ,
            'email': '请输入正确的邮箱地址 ',
            'passwordTrading':'请输入6位纯数字密码' 

        };


	        var opts = this.opts,
	        	errFlag = false,
	        	formFlag = true;


	        $.each($(formEle),function(){
	            if(!$(this).data('optional')){ //如果不为选填项 data-optional='optional'

					$(this).focus(function() {
		            	if(opts.className){
		            		$(this).removeClass(opts.className).data('error',null);
		            	}else{
			                $(this).data('error',null).siblings(opts.fromTip).find('i').removeClass('error').empty();
		            	};
		            	$(opts.fromErrorMsg).empty();
		            });

					var dataError = $(this).data('error');

					if(dataError){
						$(opts.fromErrorMsg).html(inputTextMsg[$(this).data("pattern")]);
					}


		            if($.trim($(this).val()) == '') {
		                $(this).val('');
		                $(opts.fromErrorMsg).html(formTextMsg[$(this).data("pattern")]);
		            	if(opts.className){
		            		$(this).addClass(opts.className).data('error','error');
		            	}else{
			                $(this).data('error','error').siblings(opts.fromTip).find('i').addClass('error').html('&#xe69d;');
		            	}
		                errFlag = true;
		                return false;
		            };

		            
	            }
	            
	        })

	        

	        if(errFlag) {return false};

	        // if($(opts.fromT).data("lock")) {return false};

	        
	        $.each($(formEle), function(){
	        	if(!$(this).data('optional')){ //如果不为选填项 data-optional='optional'
		            if($.trim($(this).val()) == '' || $(this).data("error")) {
		                formFlag = false;
		                return false;
		            }
	        	}
	        });

	        if(!formFlag){
	            return false;
	        } else {
	            // $(opts.fromT).data("lock", true);
	        };

	        return true;
	    };

		// 确认密码校验
	    $.checkPassword = function(options){
	    	this.default = {
				errorMsg:'#v4-input-msg', //错误提示信息
				password:'#password', //密码
				passwordSec:'#passwordSec' //确认密码
			};
			this.opts = $.extend({}, this.default, options);
			var opts = this.opts;
            var pswVal = $(opts.password).val(),
                pswSecVal = $(opts.passwordSec).val();
            if( pswVal != '' && pswSecVal != ''){
                if(pswSecVal != pswVal ){
                    $(opts.errorMsg).html('两次密码输入不一致，请重新输入');
                    return false;
                }
            };
            
        };

	$.extend({


		// 协议勾选按钮判断，不勾选表单不能提交
		checkedBox:function(checkbox,button){
			var $checkbox = $(checkbox),
				$button = $(button);
			$checkbox.on('change',function(){
				if($(this).is(':checked')){
			        $button.removeAttr("disabled").removeClass('disable');
			    }else{
			        $button.attr("disabled","disabled").addClass('disable');
			    }
			})
		},


		//最后一个空方法，最后不需要逗号
        __noop: function(){}
	});
	
	
	
})(jQuery);