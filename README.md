# OpenVpn Web界面用户管理与流量控制系统

## 项目由来

由“Fas流控”修改而来，还有一部分文件来自于“聚力流控”，皆搜集自网络。侵删。

## 项目作用与项目定位

OpenVpn用户管理与流量控制。

暂未配套专用APP，适用于个人配合OpenVPN for Android或OpenVPN Connect等通用软件进行使用。

## 项目宗旨

搭建快速方便、使用优雅简洁。

代码人人可见，后门无所遁形。

## 如何使用

系统支持：CentOS 7.0 - 7.4

系统架构：KVM、Hyper-V、VMware、物理机

### 直接使用成品搭建

#### 云端源（新功能更新不及时）

执行：`yum -y install wget && wget "https://gitee.com/imldy/openvpncontrol/raw/master/fasCloudInstall.bin" && bash fasCloudInstall.bin`

#### 本地源（实时更新）

……

### 自行使用源码搭建

#### 云端源

下载或克隆本仓库

压缩`dependence\bin`为`bin.zip`

压缩`dependence\fas_web`为`fas_web.zip`

压缩`dependence\openvpn`为`openvpn.zip`

压缩`dependence\res`为`res.zip`

将压缩后的zip文件放在dependence目录内

然后把整个`dependence`目录放在云端（主机空间或者对象存储）

修改`fasCloudInstall.bin`的`Download_host`值为你云端位置，例如`https://cc.bb.aa/dependence/`

执行`bash fasCloudInstall.bin`

## 后门说明

项目初始文件皆来自于网络，能开源的都开源了，有无后门自行判断，我只能说明我目前没有发现，欢迎大佬参与项目寻找BUG和后门。

## 免责声明

仅供学习交流使用，使用后果自行承担。

## 感谢名单

感谢：Fas流控开发者

感谢：聚力网络科技

感谢：heyixiao

感谢：ZSCloud - 知速云

感谢：其他对此项目源码做出贡献的开发者。

## 常见问题与回答

### 安装为什么这么慢？

1、可能是服务器带宽小

2、需要下载外网的文件

### 下载外网文件如何提速？

可以配置一个能访问外网的代理服务器。

修改/etc/yum.conf文件，尾部追加如下内容：

```
#配置代理
proxy=http://你的代理IP地址:端口
#不代理的ip/域名/主机列表
no_proxy="127.0.0.1,localhost,mirrors.tencentyun.com"
#若代理需要账号密码，则添加；（否则请省略以下；）
proxy_username=你的代理的用户名
proxy_password=你的代理的密码
```
