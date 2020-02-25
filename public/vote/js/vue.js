var app = new Vue({
	el: '#app',
	data: {
		url: 'http://hx.le-cx.com/',
		pop: {
			wx: false,
			option: false,
			froms: false,
			join: false,
			type: 1
		},
		config: {
			res:'',
			code:'',
			uid:'',
			openid:'',
			name:'',
			vid:'',
			appid: 'wxd6f30cb38ce4a273',
			filekey:''
		},
		vote:{},
		join:{
			agree:false,
			paperkey:-1
		}
	},
	created: function () {
		var _ = this;
		_.userinfo(); 
		// _.test();
	},
	methods: {
		test(){
			var _ = this;
			_.config.uid = 8;
			_.config.openid = 'ovvUKwsv9bj2EXgxlhb2yI6OkwLg';
			_.config.name = '~_^';
			_.config.vid = _.GetQueryString('activity_id');
			
			axios.get(_.url+'api/sign/getsigninfo', {
				params: {
					activity_id: _.config.vid,
					user_id: _.config.uid
				}
			}).then(function (res) {
				_.getvote(res);
			});
		},
		userinfo(){
			var _ = this;
			var url = encodeURI(window.location.href);
			var code = _.GetQueryString('code');
			// var code = '021eDoYm1ZWJXq00mhZm1HeyYm1eDoY0';
			if (code==''||code==null){
				window.location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid='+_.config.appid+'&redirect_uri='+url+'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
			}else{
				_.config.code = code;

					// _.config.res = code;
					// alert(code);
				axios.get(_.url+'api/Getwxuser/get_user_all', {
					params: {
						code: code
					}
				}).then(function (res) {
					if(res.data.code==200){
						_.config.uid = res.data.userid;
						_.config.openid = res.data.openid;
						_.config.name = res.data.name;
						_.config.vid = _.GetQueryString('activity_id');
						
						axios.get(_.url+'api/sign/getsigninfo', {
							params: {
								activity_id: _.config.vid,
								user_id: _.config.uid
							}
						}).then(function (res) {
							_.getvote(res);
						});
					}else{
						window.location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid='+_.config.appid+'&redirect_uri='+url+'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
					}
				});
			}
		},
		getvote(myjoin){
			var _ = this;
			axios.get(_.url+'api/activity/getactivityinfo', {
				params: {
					activity_id: _.config.vid,
					openid: _.config.openid
				}
			}).then(function (res) {
				if(res.data.code==200){
					res.data.data.custom = _.addkey(res.data.data.custom,'content');
					res.data.data.myjoin = myjoin;
					_.vote = res.data.data;
				}else{
					alert(res.data.msg);
				}
			});
		},
		paper(val){
			var _ = this;
			_.join.paperkey = val;
		},
		pops(key){
			var _ = this;
			_.pop[key] = !_.pop[key];
		},
		addkey(arr,name){
			for(var i=0;i<arr.length;i++){
				arr[i][name] = '';
			}
			return arr;
		},
		GetQueryString(name){
		    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		    var r = window.location.search.substr(1).match(reg);//search,查询？后面的参数，并匹配正则
		    if(r!=null)return r[2]; return null;
		},
		agree(){
			var _ = this;
			_.join.agree = !_.join.agree;
		},
		choiceImg(index){
			var _ = this;
			_.config.filekey = index;
		    _.$refs.filElem.dispatchEvent(new MouseEvent('click')) 
		},
		getFile(){
			var _ = this;
            var inputFile = _.$refs.filElem.files[0];
            if(inputFile&&_.config.filekey!=''){
                if(inputFile.type !== 'image/jpeg' && inputFile.type !== 'image/png' && inputFile.type !== 'image/gif'){
                    alert('不是有效的图片文件！');
                    return;
                }
				
				var data = new FormData();
				data.append("file",inputFile); //名称
				
				axios.post(_.url+'api/common/upload', data, {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}).then(function (res) {
					_.vote.custom[_.config.filekey].content = res.data.data.url;
				});
            } else {
                return;
            }
		},
		but(){
			var _ = this;
			vote = _.vote;
			
			if(vote.notaudit==0){
				_.pops('join');
				return;
			}
			if(vote.notaudit==1&&vote.myjoin.data.pay!=1){
				_.pops('join');
				return;
			}
			if(vote.notaudit==1&&vote.myjoin.data.data){
				window.location.href=_.url+'vote/qrcode.html?activity_id='+_.config.vid+'&user_id='+_.config.uid+'&openid='+_.config.openid;
				return;
			}
			
			// 去报名
			_.pops('option');
		},
		option(){
			var _ = this;
			if(_.join.paperkey==-1){
				alert('请选择票种');
				return;
			}
			
			// 去报名
			_.pops('option');
			_.pops('froms');
		},
		joins(){
			var _ = this;
			var custom = _.vote.custom;
			
			// 表单验证
			var isok = false;
			for(var i=0;i<custom.length;i++){
				if(isok){
					return;
				}
				if(custom[i].content==''){
					isok = true;
					if(custom[i].type==0){
						alert('请填写'+custom[i].title);
					}else{
						alert('请上传'+custom[i].title);
					}
				}
			}
			if(isok){
				return;
			}
			
			if (!_.join.agree) {
				alert('请同意活动用户服务协议');
				return;
			}
			
			var key = _.join.paperkey;
			var status = _.vote.aduitstatus==0?1:0;
			var url = _.url+'api/Sign/addsign?activity_id='+_.config.vid+'&userid='+_.config.uid+'&status='+status+'&cusform='+JSON.stringify(_.vote.custom)+'&paper_id='+_.vote.paper[key].id+'&activity_name='+_.vote.activityname+'&username='+_.config.name;
			
			
			axios.get(url).then(function (res) {
				console.log(res.data);
				if(res.data.code==200){
					_.pops('froms');
					
					axios.get(_.url+'api/sign/getsigninfo', {
						params: {
							activity_id: _.config.vid,
							user_id: _.config.uid
						}
					}).then(function (res) {
						_.vote.myjoin = res;
						if(_.vote.aduitstatus==1){
							_.vote.notaudit = 0
							_.pops('join');
						}else{
							_.vote.notaudit = 1;
							if(_.vote.myjoin.data.pay==0){
								_.pops('join');
							}else{
								if(_.vote.notaudit==1&&_.vote.myjoin.data.data){
									window.location.href=_.url+'vote/qrcode.html?activity_id='+_.config.vid+'&user_id='+_.config.uid+'&openid='+_.config.openid;
									return;
								}
							}
						}
					}).catch(function (error) {
						alert(JSON.stringify(error));
					});
				}else{
					alert(res.data.msg);
				}
				
			}).catch(function (error) {
				alert(JSON.stringify(error.response.status));
				alert(JSON.stringify(error.response.data));
				alert(JSON.stringify(error.response.headers));
			});
			
		},
		wxpay(){
			var _ = this;
			var url = _.url+'api/pay/wepay?user_id='+_.config.uid+'&activity_id='+_.config.vid;
			axios.get(url).then(function (res) {
				
				WeixinJSBridge.invoke('getBrandWCPayRequest', res.data.data,function(res){
				    if(res.err_msg == "get_brand_wcpay_request:ok" ){
				    // 使用以上方式判断前端返回,微信团队郑重提示：
				          //res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
							_.pops('join');
							_.vote.myjoin.data.pay==1;
							window.location.href=_.url+'vote/qrcode.html?activity_id='+_.config.vid+'&user_id='+_.config.uid+'&openid='+_.config.openid;
				    } 
				});
				console.log(res);
				
			}).catch(function (error) {
				alert(url);
				alert(JSON.stringify(error.response.data));
			});
			
		}
	}
})