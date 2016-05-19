#API接口说明文档#

**编写：**周雄志  
**版本：**20160421.002

[TOC]

## 历史变更记录

### 2016-04-21变更记录

序号 | 接口类别 | 接口名称 | 动作 | 详情 | 变更人
--- | ------ | ------- | --- | ---- | ----
1   | 应用APP | /app/login-text-code | 修改 | 增加错误码1014 | 周雄志

### 2016-04-20变更记录

序号 | 接口类别 | 接口名称 | 动作 | 详情 | 变更人
--- | ------ | ------- | --- | ---- | ----
1   | 应用APP | /app/login-text-code | 新增 | | 周雄志

***

## 通用

### 1.1 协议
- 所有请求使用标准HTTP协议
- 所有数据使用UTF-8编码

### 1.2 请求与响应格式
- 请求头最好带上`Accept：application/json`
- 响应数据格式默认为json

#### 1.2.1 全局参数
对于登录后的接口，必须通过GET方式传递access_token。

名称          | 类型   | 描述
------------ | ------ | -------
access_token | string | access token

#### 1.2.2 响应HTTP状态码
状态码 | 描述
----- | ------------
200   | 请求成功
401   | 未授权访问
404   | 接口不存在
500   | 内部服务器错误

#### 1.2.3 正常响应数据
名称      | 类型   | 描述
-------- | ------ | -------
status   | number | 状态码
message  | string | 描述
data     | mixed  | 数据

#### 1.2.4 示例：
	{
	  "status": 200,
	  "message": "",
	  "data": [
	  	"foo": "bar"
	  ]
	}

***

## 应用

应用级接口以及未登录（用户）接口。

### 2.1 获取短信验证码
`POST` /app/login-text-code

*功能*

给指定手机号发送短信验证码

*参数*

参数名    | 类型   | 必需 | 描述
-------- | ------ | --- | ---
mobile   | string | 是  | 手机号码

*返回值*

名称      | 类型   | 描述
-------- | ------ | ---

*响应示例*

	{
	  "status": 200,
	  "message": "验证码已发送",
	  "data": null
	}

*错误码表*

状态码 | 描述
----- | ------------
1011  | 手机号码不合法
1012  | 账号不存在
1013  | 验证码获取失败
1014  | 验证码发送失败