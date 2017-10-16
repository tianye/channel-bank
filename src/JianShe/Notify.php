<?php
/**
 * Created by PhpStorm.
 * User: tianye
 * Date: 2017/10/13
 * Time: 下午2:19
 */

//微信H5支付后返回值
//================notify-$_POST===================
//key: charset value: UTF-8
//key: orderNumber value: 1508147957729848008837
//key: orderCurrency value: 156
//key: sign value: 231c36d4e2bb958a033e554bdc17fd6b
//key: version value: 2.0
//key: qid value: J014402017101617591841571656
//key: payType value: B2C
//key: orderAmount value: 2
//key: payAmount value: 2
//key: orderTime value: 20171016175917
//key: transType value: 01
//key: merId value: 10001
//key: state value: 1
//key: signMethod value: MD5
//================notify-$_GET===================
//================notify-XML===================
//charset=UTF-8&orderNumber=1508147957729848008837&orderCurrency=156&sign=231c36d4e2bb958a033e554bdc17fd6b&version=2.0&qid=J014402017101617591841571656&payType=B2C&orderAmount=2&payAmount=2&orderTime=20171016175917&transType=01&merId=10001&state=1&signMethod=MD5


//支付宝H5支付后返回值
//================notify-$_POST===================
//key: charset value: UTF-8
//key: orderNumber value: 1508148278261664005149
//key: orderCurrency value: 156
//key: sign value: eed541fe7b0b18e86ff71b663a9dbb18
//key: version value: 2.0
//key: qid value: J014422017101618063250063508
//key: payType value: B2C
//key: orderAmount value: 2
//key: payAmount value: 2
//key: orderTime value: 20171016180438
//key: transType value: 01
//key: merId value: 10001
//key: state value: 1
//key: signMethod value: MD5
//================notify-$_GET===================
//================notify-XML===================
//charset=UTF-8&orderNumber=1508148278261664005149&orderCurrency=156&sign=eed541fe7b0b18e86ff71b663a9dbb18&version=2.0&qid=J014422017101618063250063508&payType=B2C&orderAmount=2&payAmount=2&orderTime=20171016180438&transType=01&merId=10001&state=1&signMethod=MD5


//支付宝H5退款回调
//================notify-$_POST===================
//key: charset value: UTF-8
//key: refAmount value: 2
//key: orderNumber value: 1508148497445890004382
//key: orderCurrency value: 156
//key: sign value: 5d089e94b07f14cf912df732c382326f
//key: version value: 2.0
//key: qid value: J014422017101618063250063508
//key: orderTime value: 20171016180818
//key: transType value: 02
//key: refConfTime value: 20171016180818
//key: merReserved1 value: 商户退款示例
//key: merId value: 10001
//key: refId value: T002412017101618081813965925
//key: state value: 1
//key: signMethod value: MD5
//================notify-$_GET===================
//================notify-XML===================
//charset=UTF-8&refAmount=2&orderNumber=1508148497445890004382&orderCurrency=156&sign=5d089e94b07f14cf912df732c382326f&version=2.0&qid=J014422017101618063250063508&orderTime=20171016180818&transType=02&refConfTime=20171016180818&merReserved1=%E5%95%86%E6%88%B7%E9%80%80%E6%AC%BE%E7%A4%BA%E4%BE%8B&merId=10001&refId=T002412017101618081813965925&state=1&signMethod=MD5


//微信退款实例
//================notify-$_POST===================
//key: charset value: UTF-8
//key: refAmount value: 2
//key: orderNumber value: 1508148546984233008141
//key: orderCurrency value: 156
//key: sign value: e2e5b0592a51a88f0994915aefb336db
//key: version value: 2.0
//key: qid value: J014402017101617591841571656
//key: orderTime value: 20171016180907
//key: transType value: 02
//key: refConfTime value: 20171016180907
//key: merReserved1 value: 商户退款示例
//key: merId value: 10001
//key: refId value: T002422017101618090767410726
//key: state value: 1
//key: signMethod value: MD5
//================notify-$_GET===================
//================notify-XML===================
//charset=UTF-8&refAmount=2&orderNumber=1508148546984233008141&orderCurrency=156&sign=e2e5b0592a51a88f0994915aefb336db&version=2.0&qid=J014402017101617591841571656&orderTime=20171016180907&transType=02&refConfTime=20171016180907&merReserved1=%E5%95%86%E6%88%B7%E9%80%80%E6%AC%BE%E7%A4%BA%E4%BE%8B&merId=10001&refId=T002422017101618090767410726&state=1&signMethod=MD5