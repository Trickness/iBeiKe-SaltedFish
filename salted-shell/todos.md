## TODO LIST

1. 用户头像系统：
- 参见[用户信息结构](../docs/02.1-users.md#用户信息结构（JSONStr）) 中的header字段，其为一个URL，指向一个图片。头像上传系统有如下要求
    - 校验该文件是否为图像文件(core/utils.php)
    - 将数据写入存储，并保存为随机文件名
    - 更改头像后，删除之前的头像文件
    - 返回指向上传图像的URL

2. 图像URL提取：
- 用户在editor中，以富文本形式写入了介绍，包括图像，通过正则匹配方式找出富文本中所有的图像URL，单独保存出来

3. 仲裁系统（？）

4. 广告系统    
- 热度系统 （热度计算方程--> = (总赞数*0.7+总评论数*0.3)*1000/(发布时间距离当前时间的小时差+2)^1.2）
- 独立广告页面