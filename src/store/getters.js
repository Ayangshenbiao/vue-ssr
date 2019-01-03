export default {
    /**
     * uerinfo
     * @returns {state.userInfo.head|{returnCode}}
     * @constructor
     */
    USER_INFO(state) {
        return state.userInfo;
    },
    GET_SERVER_DATA: (state) => (key) => {
        let tmp = JSON.stringify(state.serverData);
        tmp = JSON.parse(tmp);
        return tmp[key] ? (tmp[key] || null) : tmp;
    },
    ALREADY_URLS: (state) => (urlKey) => {
        return state.alreadyUrls[urlKey] || null;
    },
    GETMSG: (state) => (key) => {
        return state.messages[key] || null;
    },
}
