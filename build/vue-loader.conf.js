'use strict';
const utils = require('./utils');
let {getConfigServer} = require('../config/config-server');
const configServer = getConfigServer(process.env.NODE_ENV);

const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
    loaders: utils.cssLoaders({
        sourceMap: isProduction
            ? configServer.build.productionSourceMap
            : configServer.dev.cssSourceMap,
        extract: isProduction
    }),
    transformToRequire: {
        video: 'src',
        source: 'src',
        img: 'src',
        image: 'xlink:href'
    }
};
