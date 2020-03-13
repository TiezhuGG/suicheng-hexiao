var app = new Vue({
	el: '#app',
	data: {
		url: '',
		pop: {
			wx: false,
			option: false,
			froms: false,
			join: false,
			type: 1
		},
		config: {
			res: '',
			code: '',
			uid: '',
			openid: '',
			name: '',
			vid: '',
			appid: '',
			filekey: ''
		},
		vote: {},
		join: {
			agree: false,
			paperkey: -1
		},
		// 是否免费票
		is_charge: '',
		// 票种id
		paper_id: ''
	},
	created: function () {
        this.url = localStorage.getItem('url')
        this.config.appid = localStorage.getItem('appid')
		// 判断是否要重新授权
		if (localStorage.getItem('openid')) {
			this.config.openid = localStorage.getItem('openid')
			this.config.uid = localStorage.getItem('userid')
			this.config.name = localStorage.getItem('username')
			this.config.vid = this.GetQueryString('activity_id')
			this.getSign()
		}
		// else {
		// 	this.userinfo();
		// }
	},
	methods: {
		getSign() {
			var _ = this;
			axios.get(_.url + 'api/sign/getsigninfo', {
				params: {
					activity_id: _.config.vid,
					user_id: _.config.uid
				}
			}).then(function (res) {
				_.getvote(res);
			});
		},
		getvote(myjoin) {
			var _ = this;
			axios.get(_.url + 'api/activity/getactivityinfo', {
				params: {
					activity_id: _.config.vid,
					openid: _.config.openid
				}
			}).then(function (res) {
				if (res.data.code == 200) {
					res.data.data.custom = _.addkey(res.data.data.custom, 'content');
					res.data.data.myjoin = myjoin;
					_.vote = res.data.data;
					console.log('custom',res.data.data.custom)
					console.log('myjoin',res.data.data.myjoin)
					console.log(_.vote)
				} else {
					alert(res.data.msg);
				}
			});
		},
		paper(val, charge, paperId) {
			var _ = this;
			_.join.paperkey = val;
			_.is_charge = charge
			if(_.is_charge == 1) {
				_.paper_id = paperId
			}
		},
		pops(key) {
			var _ = this;
			_.pop[key] = !_.pop[key];
		},
		addkey(arr, name) {
			for (var i = 0; i < arr.length; i++) {
				arr[i][name] = '';
			}
			return arr;
		},
		GetQueryString(name) {
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
			var r = window.location.search.substr(1).match(reg); //search,查询？后面的参数，并匹配正则
			if (r != null) return r[2];
			return null;
		},
		agree() {
			var _ = this;
			_.join.agree = !_.join.agree;
		},
		choiceImg(index) {
			var _ = this;
			_.config.filekey = index;
			_.$refs.filElem.dispatchEvent(new MouseEvent('click'))
		},
		getFile() {
			var _ = this;
			var inputFile = _.$refs.filElem.files[0];
			if (inputFile && _.config.filekey != '') {
				if (inputFile.type !== 'image/jpeg' && inputFile.type !== 'image/png' && inputFile.type !== 'image/gif') {
					alert('不是有效的图片文件！');
					return;
				}

				var data = new FormData();
				data.append("file", inputFile); //名称

				axios.post(_.url + 'api/common/upload', data, {
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
		but() {
			var _ = this;
			vote = _.vote;
			// 去报名
			_.pops('option');
		},
		option() {
			var _ = this;
			if (_.join.paperkey == -1) {
				alert('请选择票种');
				return;
			}
			// 去报名
			_.pops('option');
			_.pops('froms');
			// this.enroll()
		},

		// 直接报名成功，不弹出表单
		enroll() {
			console.log(this.is_charge)
			if(this.is_charge == 1) {
				// console.log(this.paper_id)
				// 不是免费票,去付款
				this.pops('join')
			} else {
				// console.log('免费票,直接报名成功')
				this.signUp()
			}
		},

		joins() {
			var _ = this;
			var custom = _.vote.custom;

			// 表单验证
			var isok = false;
			for (var i = 0; i < custom.length; i++) {
				if (isok) {
					return;
				}
				if (custom[i].content == '') {
					isok = true;
					if (custom[i].type == 0) {
						alert('请填写' + custom[i].title);
					} else {
						alert('请上传' + custom[i].title);
					}
				}
			}
			if (isok) {
				return;
			}	

			if (!_.join.agree) {
				alert('请同意活动用户服务协议');
				return;
			}
			if(_.is_charge == 1) {
				// 不是免费票,去付款
				_.pops('join')
			} else {
				console.log('免费票,直接报名成功')
				_.signUp()
				window.location.href = _.url + 'vote/me.html'
			}
		},
		// 报名
		async signUp() {
			var _ = this
			var key = _.join.paperkey;
			var status = _.vote.aduitstatus == 0 ? 1 : 0;
			var url = _.url + 'api/Sign/addsign?activity_id=' + _.config.vid + '&userid=' + _.config.uid + '&status=' + status + '&cusform=' + JSON.stringify(_.vote.custom) + '&paper_id=' + _.vote.paper[key].id + '&activity_name=' + _.vote.activityname + '&username=' + _.config.name;

			const data = await axios.get(url)
			console.log('data.data.code', data.data.code)
			// 报名
			if (data.data.code == 200) {
				// _.pops('froms')
				const res = await axios.get(`${_.url}api/sign/getsigninfo`, {
					params: {
						activity_id: _.config.vid,
						id: data.data.id,
						user_id: _.config.uid
					}
				})
				// 报名成功后跳转到个人中心
				window.location.href = this.url + 'vote/me.html'
				alert('报名成功')
			}else {
				alert(data.data.msg)
			}
		},
		wxpay() {
			var _ = this;
			var url = _.url + 'api/pay/wepay?user_id=' + _.config.uid + '&activity_id=' + _.config.vid + '&paper_id=' + _.paper_id;
			axios.get(url).then(function (res) {
				console.log('wxpay', res.data)
				WeixinJSBridge.invoke('getBrandWCPayRequest', res.data.data, function (res) {
					if (res.err_msg == "get_brand_wcpay_request:ok") {
						// 使用以上方式判断前端返回,微信团队郑重提示：
						//res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
						_.signUp()
						_.pops('join');
						_.vote.myjoin.data.pay == 1;
						// window.location.href = _.url + 'vote/qrcode.html?activity_id=' + _.config.vid + '&user_id=' + _.config.uid + '&openid=' + _.config.openid;
					}
					else if (res.err_msg == "get_brand_wcpay_request:cancel") {
						alert("取消支付,请重新报名");
					} else {
						alert("支付失败");
					}
				});
				// console.log('res', res);
			}).catch(function (error) {
				alert(url);
				alert(JSON.stringify(error.response.data));
			});
		},
	}
})