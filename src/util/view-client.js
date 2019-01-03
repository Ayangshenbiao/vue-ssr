let {getConfigClient} = require('../config/config-client');
let configClient = getConfigClient(process.env.NODE_ENV);

let userInfo = require('@/store/userInfo');

export default {
    /**
     * 原生js获取屏幕高度
     * @param
     * @return number
     */
    screenHeight() {
        var winHeight = 600;
        if (window.innerHeight) {
            winHeight = window.innerHeight;
        } else if ((document.body) && (document.body.clientHeight)) {
            winHeight = document.body.clientHeight;
        }

        return winHeight;
    },
    /**
     * 原生js获取屏幕宽度
     * @param
     * @return number
     */
    screenWidth() {
        var winWidth = 750;
        if (window.innerWidth) {
            winWidth = window.innerWidth;
        } else if ((document.body) && (document.body.clientWidth)) {
            winWidth = document.body.clientWidth;
        }

        return winWidth;
    },
    /**
     * window.localstorsge
     * @param key
     * @param obj type must json
     */
    setItem(key, obj) {
        try {
            let stringObj = JSON.stringify(obj);
            if (window.localStorage) {
                localStorage.setItem(key, stringObj);
            } else {
                this.setCookie(key, JSON.stringify(obj));
            }
        } catch (e) {
            console.error(key, obj, e);
        }
    },
    /**
     * window.localstorsge
     * @param key
     * @returns {null}
     */
    getItem(key) {
        if (!key) {
            console.error('window.localStorage get key is not');
            return null;
        }
        return JSON.parse(window.localStorage.getItem(key) || this.getCookie(key));
    },
    /**
     * window.localstorsge
     * @param key
     * @returns {null}
     */
    delItem(key) {
        return window.localStorage.removeItem(key) || this.delCookie(key);
    },
    /**
     * sessionStorage简单封装
     * @param {*} key
     * @param {*} objString
     */
    sessionSetItem(key, objString) {
        try {
            let stringObj = JSON.stringify(objString);
            if (window.sessionStorage) {
                window.sessionStorage.setItem(key, stringObj);
            } else {
                this.setCookie(key, JSON.stringify(stringObj));
            }
        } catch (e) {
            console.error(key, objString, e);
        }
    },
    /**
     * sessionStorage简单封装
     * @param {*} key
     * @param {*} objString
     */
    sessionGetItem(key) {
        if (!key) {
            console.error('window.sessionStorage get key is not');
            return null;
        }
        return JSON.parse(window.sessionStorage.getItem(key) || this.getCookie(key));
    },
    /**
     * sessionDelItem简单封装
     * @param {*} key
     * @param {*} objString
     */
    sessionDelItem(key) {
        if (!key) {
            console.error('window.sessionStorage del key is not');
            return;
        }
        window.sessionStorage.removeItem(key) || this.delCookie(key);
    },
    /**
     * cookes option
     */
    setCookie(name, value, days) {
        let d = new Date();
        d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days);
        window.document.cookie = name + '=' + value + ';path=/;expires=' + d.toGMTString();
    },
    getCookie(name) {
        let reg = new RegExp('(^| )' + name + '=([^;]*)(;|$)');
        let arr = document.cookie.match(reg);
        if (arr) {
            return unescape(arr[2]);
        } else {
            return null;
        }
    },
    delCookie(name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval = this.getCookie(name);
        if (cval != null) {
            document.cookie = name + '=' + cval + ';path=/;expires=' + exp.toGMTString();
        }
    },
    /**
     * [goPush Only for clients]
     * @param  {[type]} router [description]
     * @param  {[stirng]} path   [description]
     * @param  {[bool]} status [Whether to refresh the current page]
     * @return {[type]}        [description]
     */
    goPush(path, status) {
        status ? window.location.href = path : this.$router.push(path);
    },
    /**
     * 打开新窗口
     * @param path
     * @param target
     */
    goWindowOpen(pathStr, target) {
        window.open(pathStr, target);
    },
    /**
     * 打开新窗口
     * @param path
     * @param target
     */
    goWindowOpenRouter(pathStr,target) {
        let routeData = this.$router.resolve({ path: pathStr});
        window.open(routeData.href, target);
    },
    /**
     * [goReplace Only for clients]
     * @param  {[type]} router [description]
     * @param  {[stirng]} path   [description]
     * @param  {[bool]} status [Whether to refresh the current page]
     * @return {[type]}        [description]
     */
    goReplace(path, status) {
        status ? window.location.replace(path) : this.$router.replace(path);
    },
    /**
     * notice http callback
     * @param code
     * @param message
     */
    errorModus({code = '0000', message = ''}) {
        if (code !== '0000' && code !== 'AUTHORIZED_ERROR' && message) {
            //console.log(code + ", " + message);
            //this.$notice.setNotice(true, message);
        }
    },
    /**
     * notice http callback
     * @param code
     * @param message
     */
    errorCodeModus(data) {
        if (data && data.code && data.code != '0000') {
            console.log(data.message);
            this.$error.setError(true,'错误提示', data.message);
        } else {
            console.log(data.message);
            this.$error.setError(true,'错误提示', data);
        }
    },
    /**
     * [isEmptyObj obj  is  empty]
     * @param  {[type]}  obj [description]
     * @return {Boolean}     [true :is empty  false: is not empty]
     */
    isEmptyObj(obj) {
        if (Object.keys(obj).length === 0) {
            return true;
        }
        return false;
    },
    /**
     * 获取数组最大值 http callback
     * @param code
     * @param message
     */
    maxArr(arr) {
        return Math.max.apply({}, arr);
    },
    /**
     * 获取数组最小值 http callback
     * @param code
     * @param message
     */
    minArr(arr) {
        return Math.min.apply({}, arr);
    },
    /**
     * js金额字符串formart
     * @example  fmoney(12321.23,2)
     *
     */
    fmoney(num, precision=2, separator=',') {
        if (typeof(num) === "undefined") {
            num = 0;
        }
        num = num.toString().replace(/,/g, '');
        var parts;
        // 判断是否为数字
        if (!isNaN(parseFloat(num)) && isFinite(num)) {
            num = new Number(num);
            // 处理小数点位数
            num = (typeof precision !== 'undefined' ? num.toFixed(precision) : num).toString();
            // 分离数字的小数部分和整数部分
            parts = num.split('.');
            // 整数部分加[separator]分隔, 借用一个著名的正则表达式
            parts[0] = parts[0].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1' + (separator || ','));

            return parts.join('.');
        } else {
            return num;
        }

        return NaN;
    },
    /**
     * 是否是公司邮箱
     * @param str
     * @returns {boolean}
     */
    isWscnEmail(str) {
        const reg = /^[a-z0-9](?:[-_.+]?[a-z0-9]+)*@wz\.com$/i;
        return reg.test(str.trim());
    },
    /**
    * 判断身份证号码为18位时最后的验证位是否正确
    */
    isTrueValidateCodeByIdCard(idCardArr) {
        var Wi = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1]; // 加权因子
        var ValideCode = [1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2]; // 身份证验证位值.10代表X

        var sum = 0; // 声明加权求和变量
        if (idCardArr[17].toLowerCase() == 'x') {
            idCardArr[17] = 10; // 将最后位为x的验证码替换为10方便后续操作
        }
        for (var i = 0; i < 17; i++) {
            sum += Wi[i] * idCardArr[i]; // 加权求和
        }
        var valCodePosition = sum % 11; // 得到验证码所位置
        if (idCardArr[17] == ValideCode[valCodePosition]) {
            return true;
        } else {
            return false;
        }
    },
    /**
     * 验证18位数身份证号码中的生日是否是有效生日
      */
    isValidityBrithByIdCard(idCard) {
        var year = idCard.substring(6, 10);
        var month = idCard.substring(10, 12);
        var day = idCard.substring(12, 14);
        var temp_date = new Date(year, parseFloat(month) - 1, parseFloat(day));
        // 这里用getFullYear()获取年份，避免千年虫问题
        if (temp_date.getFullYear() != parseFloat(year) ||
            temp_date.getMonth() != parseFloat(month) - 1 ||
            temp_date.getDate() != parseFloat(day)) {
            return false;
        } else {
            return true;
        }
    },
    /**
     * 合法uri
     * @param textval
     * @returns {boolean}
     */
    validateURL(textval) {
        const urlregex = /^(https?|ftp):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+&%$#=~_-]+))*$/;
        return urlregex.test(textval);
    },
    /* 小写字母*/
    validateLowerCase(str) {
        const reg = /^[a-z]+$/;
        return reg.test(str);
    },
    /* 大写字母*/
    validateUpperCase(str) {
        const reg = /^[A-Z]+$/;
        return reg.test(str);
    },
    /* 大小写字母*/
    validatAlphabets(str) {
        const reg = /^[A-Za-z]+$/;
        return reg.test(str);
    },
    oneOf(value, validList) {
        for (let i = 0; i < validList.length; i++) {
            if (value === validList[i]) {
                return true;
            }
        }
        return false;
    },
    /**
     * 获取登录用户
     */
    getLoginInfo() {
        return this.sessionGetItem('userInfo');
    },
    /**
     * 格式化时间,获取当前时间或相差时间
     * @param {differDay:相差多少天,fmt:时间格式}
     * @returns {fmt}
     */
    dateFormat(differDay = 0, fmt = "yyyy-MM-dd") {
        var ds = (new Date()).getTime() - 3600 * 24 * 1000 * differDay;
        var finalDate = new Date(ds);
        var o = {
            "M+": finalDate.getMonth() + 1,                 //月份
            "d+": finalDate.getDate(),                    //日
            "h+": finalDate.getHours(),                   //小时
            "m+": finalDate.getMinutes(),                 //分
            "s+": finalDate.getSeconds(),                 //秒
            "q+": Math.floor((finalDate.getMonth() + 3) / 3), //季度
            "S": finalDate.getMilliseconds()             //毫秒
        };
        if (/(y+)/.test(fmt)) {
            fmt = fmt.replace(RegExp.$1, (finalDate.getFullYear() + "").substr(4 - RegExp.$1.length));
        }
        for (var k in o) {
            if (new RegExp("(" + k + ")").test(fmt)) {
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
            }
        }
        return fmt;
    },
    /**
     * 证件号码掩码
     * @param str
     * @param frontLen
     * @param endLen
     * @returns {string}
     */
    plusXingCertificate(str, frontLen, endLen) {
        if (typeof str == "string") {
            var len = str.length - frontLen - endLen;
            var xing = '';
            xing = "&nbsp****&nbsp" + "****&nbsp";
            return str.substr(0, frontLen) + xing + str.substr(str.length - endLen);
        } else {
            return str;
        }
    },
    /**
     * 其他掩码
     * @param str
     * @param frontLen
     * @param endLen
     * @returns {string}
     */
    plusXing(str, frontLen, endLen) {
        if (typeof str == "string") {
            var len = str.length - frontLen - endLen;
            var xing = '';
            xing = "&nbsp****&nbsp";
            return str.substr(0, frontLen) + xing + str.substr(str.length - endLen);
        } else {
            return str;
        }
    },
    /**
     * 是否为空
     */
    isEmpty(val) {
        if (val === "" || val === null || val === undefined) {
            return true
        } else {
            return false
        }
    },
    /**
     * 手机号码校验
     * @param str
     * @returns {boolean}
     */
    isMobile(str) {
        var rspValid = {};
        rspValid.booleanFlag = true;
        rspValid.message = "手机号码校验";
        var teststr = /^(0|86|17951)?(13[0-9]|15[012356789]|17[3678]|18[0-9]|14[57])[0-9]{8}$/;
        if (this.isEmpty(str)) {
            rspValid.booleanFlag = false;
            rspValid.message = "手机号码不能为空";
        } else if (!teststr.test(str)) {
            rspValid.booleanFlag = false;
            rspValid.message = "手机号码不正确";
        }
        return rspValid;
    },
    /**
     * 交易密码校验
     * @param str
     * @returns {boolean}
     * Rocky.Jia
     */
    validatTradePassword(str) {
        var rspValid = {};
        rspValid.booleanFlag = true;
        rspValid.message = "密码校验通过";
        var tradePasswordTest = /^[0-9]{6}$/;

        if (this.isEmpty(str)) {
            rspValid.booleanFlag = false;
            rspValid.message = "请输入交易密码";
        } else if (!tradePasswordTest.test(str)) {
            rspValid.booleanFlag = false;
            rspValid.message = "请输入六位数字交易密码";
        }
        return rspValid;
    },
    /**
     * 登录密码校验
     * @param str
     * @returns {boolean}
     * Rocky.Jia
     */
    validateLoginPassword(str) {
        var rspValid = {};
        rspValid.booleanFlag = true;
        rspValid.message = "密码校验通过";
        var passwordTest = /(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{6,16}$/;
        if (this.isEmpty(str)) {
            rspValid.booleanFlag = false;
            rspValid.message = "请输入登录密码";
        } else if (!passwordTest.test(str) || str.length < 6) {
            rspValid.booleanFlag = false;
            rspValid.message = "密码必须是6~16位，包含数字、字母、符号中的两种";
        }
        return rspValid;
    },
    /**
     * 用户名校验
     * @param str
     * @returns {boolean}
     * Rocky.Jia
     */
    validName(str) {
        var rspValid = {};
        rspValid.booleanFlag = true;
        rspValid.message = "用户名称校验正确";
        if (this.isEmpty(str)) {
            rspValid.booleanFlag = false;
            rspValid.message = "用户名称不能为空";
        }
        return rspValid;
    },
    /**
     * 验证手机号码
     * @param str
     * @returns {boolean}
     * Rocky.Jia
     */
    validatMobileTelNo(str) {
        var rspValid = {};
        rspValid.booleanFlag = true;
        rspValid.message = "手机号码校验正确";
        if (this.isEmpty(str)) {
            rspValid.booleanFlag = false;
            rspValid.message = "手机号不能为空";
        } else if (str.length != 11) {
            rspValid.booleanFlag = false;
            rspValid.message = "手机号码错误";
        }
        return rspValid;
    },
    /**
     * 身份证校验
     * @param certificateNo
     * @returns {boolean}
     * Rocky.Jia
     */
    validatCertificateNo(certificateNo) {
        var rspValid = {};
        var certificateNoTest = /(^\d{18}$)|(^\d{17}(\d|X)$)/;
        var certificateNoArr = certificateNo.split(""); // 得到身份证数组
        rspValid.booleanFlag = true;
        rspValid.message = "身份证号码校验正确";
        if (this.isEmpty(certificateNo)) {
            rspValid.booleanFlag = false;
            rspValid.message = "身份证号码不能为空";
        } else if (certificateNo.length != 18) {
            rspValid.booleanFlag = false;
            rspValid.message = "身份证号码位数不对";
        } else if (!(this.isValidityBrithByIdCard(certificateNo) && this.isTrueValidateCodeByIdCard(certificateNoArr) && certificateNoTest.test(certificateNo))) {
            rspValid.booleanFlag = false;
            rspValid.message = "身份证号码校验错误";
        }

        return rspValid;
    },
    /**
     * 取配置
     */
    getConfigClient(name) {
        return configClient[name];
    },
    /**
     * 清应用缓存
     */
    clearApplication() {
        this.sessionDelItem("userInfo");
        this.delCookie("token");

        this.$store.commit("SET_USER_INFO", null);
    },
    /**
     * 取客户信息
     */
    getUserInfo() {
        if (this.sessionGetItem("userInfo")) {
            return this.sessionGetItem("userInfo");
        } else {
            return userInfo;
        }
    },
    /**
     * 设置客户信息
     */
    setUserInfo(data) {
        this.$store.commit("SET_USER_INFO", data);
        this.sessionSetItem("userInfo", data);
    },
    /**
     * 设置客户信息
     */
    setUserInfoByServer(data) {
        var userInfoCurr = this.getUserInfo();

        if (!this.isEmpty(data.custId)) {
            userInfoCurr.custId = data.custId;
        }
        if (!this.isEmpty(data.sysUserInfo)) {
            userInfoCurr.sysUserInfo = data.sysUserInfo;
        }
        if (!this.isEmpty(data.custCustInfo)) {
            userInfoCurr.custInfo = data.custCustInfo;
            userInfoCurr.custInfo.isGroupCust = this.getUserInfo().custInfo.isGroupCust;
            userInfoCurr.custInfo.groupCustStatus = this.getUserInfo().custInfo.groupCustStatus;
            userInfoCurr.custInfo.isHasGroupFundInfo = this.getUserInfo().custInfo.isHasGroupFundInfo;
            userInfoCurr.custInfo.isParent = this.getUserInfo().custInfo.isParent;
            userInfoCurr.custInfo.groupid = this.getUserInfo().custInfo.groupid;
        }
        if (!this.isEmpty(data.custInfoAppendI)) {
            userInfoCurr.custInfoAppendI = data.custInfoAppendI;
        }
        if (!this.isEmpty(data.custOpenProcess)) {
            userInfoCurr.custOpenProcess = data.custOpenProcess;
        }

        this.setUserInfo(userInfoCurr);
    },
    isNullStr(value,str) {
        if(this.isEmpty(value)) {
            if(str){
                return str;
            }else{
                return "--";
            }
        } else {
            return value;
        }
    },
    amountLToU(num) {
        if(num !== null){
            num = num + '';
            if(num.indexOf(',') !== -1){
                num = num.replace(new RegExp(/(,)/g),'');
            }
        }
        num = num ? parseFloat(num.replace(",", "")) : 0;
        if(isNaN(num)) return "无效数值！";
        var strPrefix = "";
        if(num < 0) strPrefix = "(负)";
        num = Math.abs(num);
        if(num >= 1000000000000) return "无效数值！";
        var strOutput = "";
        var strUnit = '仟佰拾亿仟佰拾万仟佰拾元角分';
        var strCapDgt = '零壹贰叁肆伍陆柒捌玖';
        num += "00";
        var intPos = num.indexOf('.');
        if(intPos >= 0) {
            num = num.substring(0, intPos) + num.substr(intPos + 1, 2);
        }
        strUnit = strUnit.substr(strUnit.length - num.length);
        for(var i = 0; i < num.length; i++) {
            strOutput += strCapDgt.substr(num.substr(i, 1), 1) + strUnit.substr(i, 1);
        }
        return strPrefix + strOutput.replace(/零角零分$/, '整').replace(/零[仟佰拾]/g, '零').replace(/零{2,}/g, '零').replace(/零([亿|万])/g, '$1').replace(/零+元/, '元').replace(/亿零{0,3}万/, '亿').replace(/^元/, "零元");
    },
    shareLToU(num) { //份额转大写描述
        num = num ? parseFloat(num.replace(",", "")) : 0;
        if(isNaN(num)) return "无效数值！";
        var strPrefix = "";
        if(num < 0) strPrefix = "(负)";
        num = Math.abs(num);
        if(num >= 1000000000000) return "无效数值！";
        var strOutput = "";
        var strUnit = '仟佰拾亿仟佰拾万仟佰拾点  ';
        var strCapDgt = '零壹贰叁肆伍陆柒捌玖';
        num += "00";
        var intPos = num.indexOf('.');
        if(intPos >= 0) {
            num = num.substring(0, intPos) + num.substr(intPos + 1, 2);
        }
        strUnit = strUnit.substr(strUnit.length - num.length);
        for(var i = 0; i < num.length; i++) {
            strOutput += strCapDgt.substr(num.substr(i, 1), 1) + strUnit.substr(i, 1);
        }
        return strPrefix + strOutput.replace(/零 零 $/, '整').replace(/零[仟佰拾]/g, '零').replace(/零{2,}/g, '零').replace(/零([亿|万])/g, '$1').replace(/零+点/, '点').replace(/亿零{0,3}万/, '亿').replace(/^点/, "零点").replace(/点整/, '').replace(/ /, '').replace(/整/, '') + '份';
    },
    /**
     * 交易密码验证
     */
    preCheckTradePassword(password, callback) {
        var req = {};
        req.password = password; //交易密码（base64加密）
        this.$store.dispatch('FETCH',{
            urlKey:'PUBS_PRECHECKTRADEPASSWORD',
            data:req
        }).then(res=>{
            callback && callback(res);
        })
    },
    /**
     * 打开新窗口 window.open()
     */
    openWindowUrl(url){
        // var a = document.createElement('a');
        // a.href = url;
        // a.target = '_blank';
        // var e = document.createEvent('MouseEvents');
        // e.initEvent('click', true, true);
        // a.dispatchEvent(e);

        var a = document.createElement("a");
        a.setAttribute("href", url);
        a.setAttribute("target", "_blank");
        a.setAttribute("id", "openwin");
        document.body.appendChild(a);
        a.click();
    },
    /**
     * string 转 object
     */
    string2Object(str) {
        return JSON.parse(str);
    },
    /**
     * 获取角色权限
     */
    getRoleRule() {
        let rule = {
            view: true, //查看
            input: true, //经办
            check: false, //复核
            manage: false //管理
        };

        let loginInfo = this.getLoginInfo();
        if (loginInfo && loginInfo.sysUserInfo) {
            let roleId = loginInfo.sysUserInfo.roleId;
            if (roleId == -1) { //管理员
                rule.view = true;
                rule.input = false;
                rule.check = false;
                rule.manage = true;
            } else if (roleId == 0) { //经办
                rule.view = true;
                rule.input = true;
                rule.check = false;
                rule.manage = false;
            } else if (roleId == 1) { //复核
                rule.view = true;
                rule.input = false;
                rule.check = true;
                rule.manage = false;
            } else if (roleId == 2) { //高级经办
                rule.view = true;
                rule.input = true;
                rule.check = true;
                rule.manage = false;
            }
        }

        return rule;
    },
    padLeftZero(str) {
        return ('00' + str).substr(str.length);
    },
    formatDate(date, fmt) {
        if (/(y+)/.test(fmt)) {
            fmt = fmt.replace(RegExp.$1, (date.getFullYear() + '').substr(4 - RegExp.$1.length))
        }
        let o = {
            'M+': date.getMonth() + 1,
            'd+': date.getDate(),
            'h+': date.getHours(),
            'm+': date.getMinutes(),
            's+': date.getSeconds()
        }
        for (let k in o) {
            if (new RegExp(`(${k})`).test(fmt)) {
                let str = o[k] + ''
                fmt = fmt.replace(RegExp.$1, RegExp.$1.length === 1 ? str : this.padLeftZero(str))
            }
        }
        return fmt
    }
}
