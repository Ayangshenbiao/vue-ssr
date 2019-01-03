/**
 * state {
 * success : form susccess key
 * error: form reeor key
 * index {
 * key : number  form error order
 * }
 * vaule :{form value
 *  key:{
 *    value:
 *    status:
 *  }
 * }
 * message:{
 * }
 * }
 */
export default {
    namespaced: true,
    state() {
        return {
            formIndex: 100,
            success: [],
            error: [],
            index: {},
            value: {},
            message: {},
            submitSatus: false
        }
    },
    actions: {},
    mutations: {
        // key is sigin
        SUBMIT_STATUS(state, status) {
            state.submitSatus = status
        },
        //  form store
        SET_FORM(state, {index = null, status = false, msg = '', value = '', checked = true, key = ''}) {
            if (!key) {
                console.log('key is not empty!');
                return
            }
            if (!state.index[key]) {
                state.index[key] = typeof index === 'number' ? index : state.formIndex++;
            }
            state.message[key] = msg;
            let myvalue = null;
            if (typeof value === 'object') {
                myvalue = Object.assign({}, state.value[key] && state.value[key].value ? state.value[key].value : {}, value);
            } else {
                myvalue = value;
            }
            let tmp = {};
            tmp[key] = {
                value: myvalue,
                status
            };
            state.value = Object.assign({}, state.value || {}, tmp);
            //console.log('state.value ', key, JSON.stringify(state.value));
            if (!checked) {
                return null;
            }
            let susIndex = state.success.indexOf(key);
            let errIndex = state.error.indexOf(key);
            if (status && susIndex < 0) {
                state.success.push(key);
                if (errIndex >= 0) {
                    state.error.splice(errIndex, 1);
                }
            } else if (!status && errIndex < 0) {
                state.error.push(key);
                if (susIndex >= 0) {
                    state.success.splice(susIndex, 1);
                }
            }
        }
    },
    getters: {
        // for forms
        SUBMIT_STATUS: (state) => () => {
            return state.submitSatus;
        },
        /**
         * forms checked
         * @param keyArray undefined :status according to the configuration of forms    array: only check array of forms
         * @returns
         * {
     *  index
     *  msg
     *  value
     *  status
     * }
         */
        FORMS_ERROR: (state, getters) => (keyArray) => {
            // checked array!keyArray ||
            let checkedArr = (keyArray instanceof Array) ? keyArray : state.error;
            if (checkedArr.length === 0) {
                return false;
            }

            let obj = {};
            let myindex = 9999;
            let mykey;
            checkedArr.map((key) => {
                let index = state.index[key];
                if (myindex > index && !state.value[key].status) {
                    myindex = index;
                    mykey = key
                }
                obj = Object.assign({}, state.value[key]);
            });
            return Object.assign({
                index: myindex,
                msg: state.message[mykey]
            }, obj);
        },
        /**
         * all for el status
         * @returns {boolean}
         * @constructor
         */
        FORMS_STATUS(state) {
            return state.error.length === 0;
        },
        /**
         * back all form el value
         * @returns
         * {
     *  key : XXX
     *  ...
     * }
         * @constructor
         */
        FORMS_VALUE: (state) => () => {
            let values = state.value;
            let formValue = {};
            for (let key in values) {
                formValue[key] = values[key].value || '';
            }
            return formValue;
        },
        // for form el
        /**
         * get form-v-model
         * @param  status, index
         * @returns {string}
         */
        VALE: (state) => (key) => {
            return state.value[key] ? Object.assign({}, state.value[key].value) : '';
        },
        MSG: (state) => (key) => {
            return state.message[key] || null;
        },
        INDEX: (state) => (key) => {
            return state.index[key] || null;
        },
        STATUS: (state) => (key) => {
            return state.value[key] ? state.value[key].status : false;
        },
        FORM: (state) => (key) => {
            let value = state.value[key] || {};
            return Object.assign({
                index: state.index[key] || null,
                msg: state.message[key] || null
            }, value);
        }
    }
}
