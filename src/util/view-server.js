export default {
    methods: {
        /**
         * [goPush Only for clients]
         * @param  {[type]} router [description]
         * @param  {[stirng]} path   [description]
         * @param  {[bool]} status [Whether to refresh the current page]
         * @return {[type]}        [description]
         */
        goPush(path) {
            this.$router.push(path);
        },
        /**
         * [goReplace Only for clients]
         * @param  {[type]} router [description]
         * @param  {[stirng]} path   [description]
         * @param  {[bool]} status [Whether to refresh the current page]
         * @return {[type]}        [description]
         */
        goReplace(path) {
            this.$router.replace(path);
        },
        getRoleRule() {
            let rule = {
                view: false, //查看
                input: true, //录入
                check: false, //复核
                manage: false //管理
            };

            return rule;
        }
    }
}
