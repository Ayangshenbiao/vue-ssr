/**
 * 服务端配置
 */

let configServerJs;
/**
 * 测试环境配置
 * @type {{host: string, netNo: string, uploadFile: {startUrl: string, tmpFilePath: string, filePath: string, keepExtensions: boolean, maxFieldsSize: number, registFile: {staticPath: string, fileName: string, url: string}, qualityCustFile: {staticPath: string, fileName: string, url: string}, professionalFile: {staticPath: string, fileName: string, url: string}, authRealFile: {staticPath: string, fileName: string, url: string}}}}
 */
var configServerDev = {
    "host": "http://192.168.100.16:8130",
    "netNo": "wts",
    "uploadFile": {
        "startUrl": "/upload/fileUpload",
        "tmpFilePath": "/data/tmpfile",
        "filePath": "/data",
        "keepExtensions": true,
        "maxFieldsSize": 5,
        "registFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/K/",
            "fileName": "{{custId}}_{{userId}}_{{vcPub2}}_{{vcPub0}}",
            "url": "/upload/uploadSuccess"
        },
        "qualityCustFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/ISQUALITYCUST/",
            "fileName": "{{custId}}_{{userId}}_ISQUALITYCUST",
            "url": "/upload/uploadSuccess"
        },
        "professionalFile": {
            "staticPath": "/cerfile/{{custId}}/NEWSALE/ISPROFESSIONAL/",
            "fileName": "file_{{custId}}_ISPROFESSIONAL",
            "url": "/upload/uploadSuccess"
        },
        "authRealFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/AUTHREAL/",
            "fileName": "{{custId}}_{{userId}}_AUTHREAL",
            "url": "/upload/uploadSuccess"
        }
    }
};

/**
 * sit环境配置
 * @type {{host: string, netNo: string, uploadFile: {startUrl: string, tmpFilePath: string, filePath: string, keepExtensions: boolean, maxFieldsSize: number, registFile: {staticPath: string, fileName: string, url: string}, qualityCustFile: {staticPath: string, fileName: string, url: string}, professionalFile: {staticPath: string, fileName: string, url: string}, authRealFile: {staticPath: string, fileName: string, url: string}}}}
 */
var configServerSit = {
    "host": "http://192.168.100.16:8130/api",
    "netNo": "wts",
    "uploadFile": {
        "startUrl": "/upload/fileUpload",
        "tmpFilePath": "/data/tmpfile",
        "filePath": "/data",
        "keepExtensions": true,
        "maxFileSize": 5,
        "registFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/K/",
            "fileName": "{{custId}}_{{userId}}_{{vcPub2}}_{{vcPub0}}",
            "url": "/upload/uploadSuccess"
        },
        "qualityCustFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/ISQUALITYCUST/",
            "fileName": "{{custId}}_{{userId}}_ISQUALITYCUST",
            "url": "/upload/uploadSuccess"
        },
        "professionalFile": {
            "staticPath": "/cerfile/{{custId}}/NEWSALE/ISPROFESSIONAL/",
            "fileName": "file_{{custId}}_ISPROFESSIONAL",
            "url": "/upload/uploadSuccess"
        },
        "authRealFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/AUTHREAL/",
            "fileName": "{{custId}}_{{userId}}_AUTHREAL",
            "url": "/upload/uploadSuccess"
        }
    }
};

/**
 * uat环境配置
 * @type {{host: string, netNo: string, uploadFile: {startUrl: string, tmpFilePath: string, filePath: string, keepExtensions: boolean, maxFieldsSize: number, registFile: {staticPath: string, fileName: string, url: string}, qualityCustFile: {staticPath: string, fileName: string, url: string}, professionalFile: {staticPath: string, fileName: string, url: string}, authRealFile: {staticPath: string, fileName: string, url: string}}}}
 */
var configServerUat = {
    "host": "http://192.168.100.16:8130/api",
    "netNo": "wts",
    "uploadFile": {
        "startUrl": "/upload/fileUpload",
        "tmpFilePath": "/data/tmpfile",
        "filePath": "/data",
        "keepExtensions": true,
        "maxFileSize": 5,
        "registFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/K/",
            "fileName": "{{custId}}_{{userId}}_{{vcPub2}}_{{vcPub0}}",
            "url": "/upload/uploadSuccess"
        },
        "qualityCustFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/ISQUALITYCUST/",
            "fileName": "{{custId}}_{{userId}}_ISQUALITYCUST",
            "url": "/upload/uploadSuccess"
        },
        "professionalFile": {
            "staticPath": "/cerfile/{{custId}}/NEWSALE/ISPROFESSIONAL/",
            "fileName": "file_{{custId}}_ISPROFESSIONAL",
            "url": "/upload/uploadSuccess"
        },
        "authRealFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/AUTHREAL/",
            "fileName": "{{custId}}_{{userId}}_AUTHREAL",
            "url": "/upload/uploadSuccess"
        }
    }
};

/**
 * 生产环境配置
 * @type {{host: string, netNo: string, uploadFile: {startUrl: string, tmpFilePath: string, filePath: string, keepExtensions: boolean, maxFieldsSize: number, registFile: {staticPath: string, fileName: string, url: string}, qualityCustFile: {staticPath: string, fileName: string, url: string}, professionalFile: {staticPath: string, fileName: string, url: string}, authRealFile: {staticPath: string, fileName: string, url: string}}}}
 */
var configServerProd = {
    "host": "http://192.168.100.16:8130/api",
    "netNo": "wts",
    "uploadFile": {
        "startUrl": "/upload/fileUpload",
        "tmpFilePath": "/data/tmpfile",
        "filePath": "/data",
        "keepExtensions": true,
        "maxFileSize": 5,
        "registFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/K/",
            "fileName": "{{custId}}_{{userId}}_{{vcPub2}}_{{vcPub0}}",
            "url": "/upload/uploadSuccess"
        },
        "qualityCustFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/ISQUALITYCUST/",
            "fileName": "{{custId}}_{{userId}}_ISQUALITYCUST",
            "url": "/upload/uploadSuccess"
        },
        "professionalFile": {
            "staticPath": "/cerfile/{{custId}}/NEWSALE/ISPROFESSIONAL/",
            "fileName": "file_{{custId}}_ISPROFESSIONAL",
            "url": "/upload/uploadSuccess"
        },
        "authRealFile": {
            "staticPath": "/cerfile/{{custId}}/{{userId}}/AUTHREAL/",
            "fileName": "{{custId}}_{{userId}}_AUTHREAL",
            "url": "/upload/uploadSuccess"
        }
    }
};

configServerJs = {
    getConfigServer: function (nodeEnv) {
        let configServer = configServerDev;
        if (nodeEnv === 'sit') {
            configServer = configServerSit;
        } else if (nodeEnv === 'uat') {
            configServer = configServerUat;
        } else if (nodeEnv === 'production') {
            configServer = configServerProd;
        }
        return configServer;
    }
};

module.exports = configServerJs;