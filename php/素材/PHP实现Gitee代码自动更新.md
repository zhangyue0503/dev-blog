1. 需要用 www 用户 clone 代码
   1. 修改 /etc/passwd ，让www可登录
   2. su www 后去clone代码
   3. 改回不可登录
2. www 用户生成证书  `sudo -Hu www ssh-keygen -t rsa证书名称 -C "说明"`
3. 证书提交到 gitee 部署证书