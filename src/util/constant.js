export const Router = {
    defualtNoUserInfo: '/login', //无客户信息的默认路由
    defualtHasUserInfo: '/account/main', //有客户信息的默认路由
    login: '/login', //登录路由
    setPwd: '/setPwd', //登录密码修改或设置交易密码
    riskTest: '/risk/riskMain', //风险测评
    roleForbid: '/roleForbid' //角色禁止
};

export const Code = {
    authorizedError: 'AUTHORIZED_ERROR' //令牌失效
};

export const CustOpenProcess = {
    0: '/account/main',//开户流程完成
    1: '/regist/setCompanyInfo', //管理员注册完成
    2: '/regist/setRoleInfo', //企业信息输入完成
    3: '/regist/commitInfo',//设置角色完成
    4: '/regist/success', //用户材料上传完成
    F: '/forgetPwd/reSet' //忘记密码设置
};

export const PdfFile = [
    {id: 'proxy', path: '/file/pdf/proxy.pdf'}, //授权协议书
    {id: 'pay', path: '/file/pdf/pay.pdf'}, //支付协议
    {id: 'protocol', path: '/file/pdf/protocol.pdf'}, //用户协议
    {id: 'register', path: '/file/pdf/register.pdf'}, //注册协议
    {id: 'recvAccount', path: '/file/pdf/recvAccount.pdf'} //收款账号
];

