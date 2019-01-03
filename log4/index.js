var log4js = require('log4js');
log4js.configure(require('./log4js.json'));
let logInfo = log4js.getLogger('info');
let logErr = log4js.getLogger('error');

function printInfo(printObj, fileName = null, key = 'INFO', rout = null, sendTime = null, options = null, responseData = null) {
    let _tmpDate = sendTime ? `${sendTime.toLocaleString()}:${sendTime.getMilliseconds()}` : '';
    printObj.info(
        `[${fileName}] ${key}:${_tmpDate}${rout ? `[${typeof rout === 'object' ? JSON.stringify(rout) : rout}]` : ''}
        ${options ? `REQUEST:${JSON.stringify(options)};` : ''}${responseData ? `RESPONSE:${typeof responseData === 'object' ? JSON.stringify(responseData) : responseData};` : ''}`);
}

/**
 * @param key SEND: api call , RENDER: page drawing
 * @param rout  router info
 * @param reqTime api require time
 * @param options api params
 * @param resData api callback time
 */
module.exports = {
    logErr(fileName, key, rout, reqTime, options, resData) {
        printInfo(logErr, fileName, key, rout, reqTime, options, resData)
    },
    logInfo(fileName, key, rout, reqTime, options, resData) {
        printInfo(logInfo, fileName, key, rout, reqTime, options, resData)
    },
    log4js,
    defaultInfo: logInfo
};
