/**
 * 获取HOST
 * @param url
 */
export function host(url) {
    const host = url.replace(/^https?:\/\//, '').replace(/\/.*$/, '');
    const parts = host.split('.').slice(-3);
    if (parts[0] === 'www') parts.shift();
    return parts.join('.');
}

/**
 * 多长时间之前
 * @param time
 * @returns {*}
 */
export function timeAgo(time) {
    const between = Date.now() / 1000 - Number(time);
    if (between < 3600) {
        return pluralize(~~(between / 60), ' minute');
    } else if (between < 86400) {
        return pluralize(~~(between / 3600), ' hour');
    } else {
        return pluralize(~~(between / 86400), ' day');
    }
}

function pluralize(time, label) {
    if (time === 1) {
        return time + label;
    }
    return time + label + 's';
}

/**
 * 2015年01月01日 ==> 2015-01-01
 */
export function myDate(value) {
    if (!value) return '';
    let tmp = value.replace(/[年|月]/g, '-');
    tmp = tmp.replace(/[日]/g, '');
    return tmp;
}

/**
 * 日期格式化
 * YYYYMMDD -> YYYY-MM-DD
 */
export function formatDate(value) {
    return value.substring(0, 4) + "-" + value.substring(4, 6) + "-" + value.substring(6, 8);
}

/**
 * lff
 * 日期 2017-11-11  ==>>  11月11日
 */
export function myMD(value) {
    if (!value) return '';
    value = value.trim();
    value = value.split('-');
    return value[1] + '月' + value[2] + '日';
}

/**
 * 银行卡后四位数字
 */
export function bankEndFour(value) {
    if (!value) return '';
    return value.trim().substr(-4);
}

/**
 * 银行卡号保留前四位和后四位，中间使用六个*号代替
 */
export function bankPrevEndFour(value) {
    if (!value) return '';
    value = value.trim();
    return value.substr(0, 4) + '******' + value.substr(-4, 4);
}

/**
 * 保留两位小数
 */
export function twoDecimal(value) {
    if (!value) return '';
    value = value.trim();
    return parseFloat(value).toFixed(2);
}
/**
 * 为空显示‘--’
 */
export function emptyFilter(value, view='--') {
    if (value!=='0' && value!==0 &&(value==undefined || value==null || value=='')){
        return view;
    }
    return value;
}

/**
 * 小写金额转化大写金额
 */
export function numberChineseFilter(n) {
    if(isNaN(n)) return "无效数值！";
    if(n >= 1000000000000) return "无效数值！";

    var fraction = ['角', '分'];
    var digit = [
        '零', '壹', '贰', '叁', '肆',
        '伍', '陆', '柒', '捌', '玖'
    ];
    var unit = [
        ['元', '万', '亿'],
        ['', '拾', '佰', '仟']
    ];
    var head = n < 0 ? '欠' : '';
    n = Math.abs(n);
    var s = '';
    for (var i = 0; i < fraction.length; i++) {
        s += (digit[Math.floor(n * 10 * Math.pow(10, i)) % 10] + fraction[i]).replace(/零./, '');
    }
    s = s || '整';
    n = Math.floor(n);
    for (var i = 0; i < unit[0].length && n > 0; i++) {
        var p = '';
        for (var j = 0; j < unit[1].length && n > 0; j++) {
            p = digit[n % 10] + unit[1][j] + p;
            n = Math.floor(n / 10);
        }
        s = p.replace(/(零.)*零$/, '').replace(/^$/, '零') + unit[0][i] + s;
    }
    return head + s.replace(/(零.)*零元/, '元')
        .replace(/(零.)+/g, '零')
        .replace(/^整$/, '零元整');
};

/**
 * 小写份额转化大写
 */
export function shareLtoUFilter(num){ //份额转大写描述
    // num = num ? parseFloat(num.replaceAll(",", "")) : 0;
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
}

/**
 * 金额转化为三位一逗号，保留2位小数
 */
export function moneyFilter(num, precision=2, separator=',') {
    if (num == "" || num == null || num == undefined) {
        return '--';
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
    }

    return NaN;
}

/**
 * object 转 string
 */
export function object2String(obj) {
    return JSON.stringify(obj);
}

/**
 * string 转 object
 */
export function string2Object(str) {
    return JSON.parse(str);
}

export function plusXing(str, frontLen, endLen) {
    if (typeof str == "string") {
        var len = str.length - frontLen - endLen;
        var xing = '';
        xing = " **** ";
        return str.substr(0, frontLen) + xing + str.substr(str.length - endLen);
    } else {
        return str;
    }
}

/**
 * 是否为空
 */
export function isEmpty(val) {
    if (val == "" || val == null || val == undefined) {
        return true
    } else {
        return false
    }
}

/**
 * 金额转换成万元/亿
 */
export function moneyToWan(str) {
    if (isEmpty(str)) {
        return "--";
    } else {
        var num = '--'
        if (parseInt(str/100000000)) {
            num = moneyFilter(str/100000000) + '亿元';
        }
        else if (parseInt(str/10000)) {
            num = moneyFilter(str/10000) + '万元';
        } else {
            num = moneyFilter(str) + '元';
        }
        if(num.indexOf('.00') !== -1){
            num = num.replace('.00','');
        }
        return num;
    }
}

/**
 * 固定收益不可买说明
 */
export function fixedIncomeTitle(isCanBuy, canBuyBeginDateStr, availableLimit,item) {
  if(isEmpty(item))return '数据异常'
  if(item.fundType == '2' && item.fundSubType == '5'){
      return '充值';
  }
  if(item.fundType == '2' && item.fundSubType != '5'){
    return '购买';
  }
  var buyHtml = "购买";
  if (isCanBuy == '2') {
      if(!isEmpty(availableLimit)){
          var month='--';
          var day='--';
          if (!isEmpty(canBuyBeginDateStr)) {
              month = canBuyBeginDateStr.split('-')[1];
              if (month.substr(0,1) == '0') {
                  month = month.substr(1,1);
              }
              day = canBuyBeginDateStr.split('-')[2];
              if (day.substr(0,1) == '0') {
                  day = day.substr(1,1);
              }
              buyHtml = moneyToWan(availableLimit) + '额度' + ',' + month  + '月' + day + '日开售';
          }else{
              buyHtml = '即将开售';
          }
      }else{
          var month='--';
          var day='--';
          if (!isEmpty(canBuyBeginDateStr)) {
              month = canBuyBeginDateStr.split('-')[1];
              if (month.substr(0,1) == '0') {
                  month = month.substr(1,1);
              }
              day = canBuyBeginDateStr.split('-')[2];
              if (day.substr(0,1) == '0') {
                  day = day.substr(1,1);
              }
              buyHtml = month  + '月' + day + '日开售';
          }else{
              buyHtml = '即将开售';
          }
      }
  }
  return buyHtml;
}

/**
 *数字转百分比
 */
export function percentageNum(num){

    return (Math.round(num * 10000)/100).toFixed(2) + '%';
}
export function trimFilter(str,is_global='g'){
    var result;
    result = str.replace(/(^\s+)|(\s+$)/g,"");
    if(is_global.toLowerCase()=="g")
    {
        result = result.replace(/\s/g,"");
    }
    return result;
}