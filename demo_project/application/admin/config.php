<?php
return [
    /* Flyme登陆相关配置*/
    'LOGIN_URL'                 => 'https://member.meizu.com/login/login.html',
    'LOGOUT_URL'                => 'https://member.meizu.com/logout.jsp?useruri=',
    'LOGIN_SERVICE'             => 'meizu_ie',
    'MEMBER_TOKEN_GET_URL'      => 'https://i.flyme.cn/uc/webservice/getTokenByTicket?ticket=',
    'MEMBER_TOKEN_REFRESH_URL'  => 'https://i.flyme.cn/uc/webservice/refreshTokenByTicket?ticket=',
    'MEMBER_TOKEN_DESTRORY_URL' => 'https://i.flyme.cn/uc/webservice/destroyTokenByTicket?ticket=',

    /* 正式环境 */
    'PUBLIC_KEY'                => '-----BEGIN PUBLIC KEY-----{n}MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDXbHJWA3XQg5p1lS7REBdsULrh6Q+F7XI4qpW3{n}BsTWjwTqCV34oEli2UYfYPLc7WcsJF5+aZxe2Ac4oyLNkakrVnRcZ0nRyqGx7oBoAPOR0UBFWH7W{n}cd4UXxn+LvXsoUX0SGYC0MbFkb7detHYodG0h/ZSOWd86UwCOTYVlFn7SQIDAQAB{n}-----END PUBLIC KEY-----',

    /* 测试环境*/
    'TEST_PUBLIC_KEY'           => '-----BEGIN PUBLIC KEY-----{n}MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDjEXYjbQFY1nd35eHNoyglELWKMKWPRAs9jRin{n}nngpJDl4F1Xhxf+qDaS16XKrJxS60UPm+wNf0TrwqfhsT20MbEZMj5IlQbfwc3gdGSNfHrdm4vp2{n}T21jMwIx6R2ptd8Y9wuU0a0oniK23hhLI0WUp32hj7FDG2pc6/BL5Gg1SwIDAQAB{n}-----END PUBLIC KEY-----',

    //超级管理员
    'USER_ALLOW_FLYME'          => [15910282,7679880],
];