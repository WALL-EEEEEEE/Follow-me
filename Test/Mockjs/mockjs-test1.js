/*
* @Author: Bian-Share
* @Date:   2016-07-28 22:51:37
* @Last Modified by:   Bian-Share
* @Last Modified time: 2016-07-29 00:59:14
*/
//使用Mock
var Mock = require('mockjs')
var data = Mock.mock({
   'list|+1':[{
   	'id|+1':1
   }]
})
var list = Mock.mock({
	'id|+1':1
})
//输出结果
console.log(JSON.stringify(data,null,4))
console.log(JSON.stringify(list,null,4))