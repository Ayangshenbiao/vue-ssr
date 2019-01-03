export default {
    props: {
        sign: {
            type: String,
            required: true
        },
        realTime: {
            type: Boolean,
            default: false
        },
        formSign: {
            type: String,
            required: true
        },
        checked: {
            type: Boolean,
            default: true
        },
        required: {
            type: Boolean,
            default: true
        },
        change: {
            type: Function
        },
        error: {
            type: Function
        },
        success: {
            type: Function
        },
        formsError: {
            type: Function
        },
        formsSuccess: {
            type: Function
        },
        errMsg: {
            type: Object,
            default: () => {
                return {
                    emptyMsg: ''
                }
            }
        },
        placeholder: String,
        inputClass: String,
        value: String,
        index: Number
    },
    mixin: {
        // initialize form el store
        created() {
            if (typeof this.checkedValue === 'function') {
                if (this.value) {
                    this.checkedValue(this.value);
                } else {
                    this.$store.commit(`${this.formSign}/SET_FORM`, {
                        index: this.index || null,
                        key: this.sign,
                        value: this.value,
                        checked: this.required,
                        msg: this.value ? '' : this.errMsg.emptyMsg || ''
                    });
                }
            }
        },
        methods: {
            /**
             * handle store  user callback
             * @param msgkey the this.errMsg key
             * @param status form check result
             * @returns {string} errmsg
             */
            handle(msgkey, status = false, value) { // this.value=value
                let type = `${this.formSign}/SET_FORM`;
                let msg = msgkey ? this.handleMsg(this.errMsg[msgkey] || '') : '';
                let mydetail = {
                    status: status,
                    value: value,
                    msg: msg,
                    key: this.sign,
                    checked: value === '' ? this.required : this.checked
                };
                this.$store.commit(type, mydetail);
                // callback
                if (typeof this.change === 'function') {
                    this.change(value, mydetail);
                }
                if (status && this.success === 'function') {
                    this.success(value, mydetail);
                    // check form all
                    let formStatus = this.$store.getters[`${this.formSign}/FORMS_STATUS`];
                    if (formStatus && typeof this.formsSuccess === 'function') {
                        this.formsSuccess(value, mydetail);
                    }
                }
                if (!status && typeof this.error === 'function') {
                    this.error(value, mydetail);
                    if (typeof this.formFun.formsError === 'function') {
                        this.formsError(value, mydetail);
                    }
                }
                return msg;
            },
            /**
             * handle msg replace var if it has
             * @param msg
             */
            handleMsg(msg) {
                if (!msg) {
                    return ''
                }
                let msgArr = msg.match(/\{.*?\}/gi);
                if (!msgArr) {
                    return msg;
                }
                msgArr.map((key) => {
                    msg = msg.replace(key, this[key.substr(1, msg.length - 2)] || '');
                });
                return msg;
            }
        }
    }
}
