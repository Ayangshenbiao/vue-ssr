/**
 * 客户端配置
 */

let configClientJs;
/**
 * 测试环境配置
 * @type {{host: string, netNo: string, uploadFile: {startUrl: string, tmpFilePath: string, filePath: string, keepExtensions: boolean, maxFieldsSize: number, registFile: {staticPath: string, fileName: string, url: string}, qualityCustFile: {staticPath: string, fileName: string, url: string}, professionalFile: {staticPath: string, fileName: string, url: string}, authRealFile: {staticPath: string, fileName: string, url: string}}}}
 */
var configClientDev = {
    "staticFilePath": "http://192.168.100.16:8130"
};

/**
 * sit环境配置
 * @type {{host: string, netNo: string, uploadFile: {startUrl: string, tmpFilePath: string, filePath: string, keepExtensions: boolean, maxFieldsSize: number, registFile: {staticPath: string, fileName: string, url: string}, qualityCustFile: {staticPath: string, fileName: string, url: string}, professionalFile: {staticPath: string, fileName: string, url: string}, authRealFile: {staticPath: string, fileName: string, url: string}}}}
 */
var configClientSit = {
    "staticFilePath": "http://sit.jg.tonghuafund.com/static"
};

/**
 * uat环境配置
 * @type {{host: string, netNo: string, uploadFile: {startUrl: string, tmpFilePath: string, filePath: string, keepExtensions: boolean, maxFieldsSize: number, registFile: {staticPath: string, fileName: string, url: string}, qualityCustFile: {staticPath: string, fileName: string, url: string}, professionalFile: {staticPath: string, fileName: string, url: string}, authRealFile: {staticPath: string, fileName: string, url: string}}}}
 */
var configClientUat = {
    "staticFilePath": "http://uat.jg.tonghuafund.com/static"
};

/**
 * 生产环境配置
 * @type {{host: string, netNo: string, uploadFile: {startUrl: string, tmpFilePath: string, filePath: string, keepExtensions: boolean, maxFieldsSize: number, registFile: {staticPath: string, fileName: string, url: string}, qualityCustFile: {staticPath: string, fileName: string, url: string}, professionalFile: {staticPath: string, fileName: string, url: string}, authRealFile: {staticPath: string, fileName: string, url: string}}}}
 */
var configClientProd = {
    "staticFilePath": "https://jg.tonghuafund.com/static"
};

configClientJs = {
    getConfigClient: function (nodeEnv) {
        let configClient = configClientDev;
        if (nodeEnv === 'sit') {
            configClient = configClientSit;
        } else if (nodeEnv === 'uat') {
            configClient = configClientUat;
        } else if (nodeEnv === 'production') {
            configClient = configClientProd;
        }
        return configClient;
    }
};

module.exports = configClientJs;