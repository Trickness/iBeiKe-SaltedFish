# 整体框架
<pre>
index.php (主界面)
config.php (全局配置文件)
|- /core (核心API)    
    |- users.php (public-用户相关操作)
    |- goods.php (public-货物相关操作)
    |- authorization.php (private-各种账号验证问题的处理)
    |- utils.php (private-部分公用函数，比如post提交等)
|- /users (用户)
    |- index.php (public-显示与修改用户信息页面)
|- /saltedfishs (后台)
    |- index.php (public-登陆与操作界面)
|- /utils (其他及插件)
    |- 验证码插件
    |- SMS插件
|- /style (主题，样式以及样式图片)
    |- /css 
    |- /pic
    |- /theme
</pre> 

```
(
    student_id      CHAR(16) NOT NULL,
    student_pass    CHAR(32) NOT NULL,
    student_info    VARCHAR(65535),
    bbs_id          CHAR(32),
    PRIMARY KEY(student_id)
);
```
student_info 参见 [用户信息结构](02.1-users.md#用户信息结构（JSONStr）)