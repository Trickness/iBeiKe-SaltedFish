# API 第一版

## 登陆   
参数：   
> ?action=login&username=[USERNAME]&password=[PASSWORD]

返回：     
> 成功：{"status":"success","session":[SESSION]}

> 失败 {"status":"failed"}
        

## 登出       
参数：     
> ?action=logout     

返回:     
> {"status":"success"}

## 检查本科教学网账号[未测试]        
参数：
> ?action=check&student_id=[STUDENT ID]&password=[PASSWORD]     

返回：
> 本科教学网信息（JSON）      

## 注册[未测试]      
参数：     
> ?action=signup&student_id=[STUDENT ID]&password=[PASSWORD]    

返回：
> 成功：{"status":"success","session":[SESSION]}       
> 失败：{"status":"failed", "error":"wrong username or password"}  

## 更新自己信息(未测试)       
参数：     
> ?action=update_self_info      
> POST:info=%7B%22student_id%22%3A%7B%22access%22%3A%22protected%22%2C%22value%22%3A%2241604741%22%7D%2C%22name%22%3A%7B%22access%22%3A%22public%22%2C%22value%22%3A%22%5Cu5f20%5Cu5cfb%5Cu950b%22%7D%2C%22gender%22%3A%7B%22access%22%3A%22public%22%2C%22value%22%3A%22%5Cu7537%22%7D%2C%22birthday%22%3A%7B%22access%22%3A%22private%22%2C%22value%22%3A%2219971127%22%7D%2C%22type%22%3A%7B%22access%22%3A%22private%22%2C%22value%22%3A%22%5Cu672c%5Cu79d1%22%7D%2C       
解释：这里POST的info=xxxxx这么长一堆，其实是urlencode的jsonstr      
这里使用POST是因为用GET可能会超出URL的长度

返回：     
> 成功：{"status":"success","etag":"WUdi8u2ednJU232"}        
> 失败：{"status":"failed","error":"xxxx"}


## 新订单
参数：
> ?action=new_order&goods_id=[ID]&deliver_fee=[FEE]&goods_count=[COUNT]&price_per_goods=[PRICE]     

返回：
> 成功: {"status":"success","order_id":"12"}  
> 失败：{"status":"failed"}

## 撤销订单     
参数：
> ?action=cancel_order&order_id=[ID]

返回：     
> 成功：{"status":"success", "order_id":"12"}      
> 失败：{"status":"failed", "error":"Access denied"}