# 整体框架
<pre>
index.php (主界面)
config.php (全局配置文件)
|- /core (核心API)    
    |- users.php (public-用户相关操作)
    |- goods.php (public-货物相关操作)
    |- students_info_binder.php (private-绑定用户到学生信息)
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
