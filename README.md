后台委托器
================================

用于将后台后台委托给其它应用，或管理受托的后台。


# 简介

作为微服务和小应用，不希望单独实现后台，
或希望将多个应用的后台整合在一起，即可使用本库。

两种角色可使用本库

后台委托者：拥有资源，但不建立自己的后台，而将资源管理权限委托给后台实现者。

后台实现者：实现后台，去管理后台委托者所拥有的资源。


# 用法

## 后台委托者

* 继承抽象类 ` \CatPKT\AdminDelegation\AAdminDelegator; ` 创建委托者类，并实现必要的抽象函数
* 注册资源与增删改查规则
* 将某个 URL 的所有 Method 请求路由到此委托者类的 handle 方法 并传入请求类（需为 \Symfony\Component\HttpFoundation\Request 或其子类）的对象


## 后台实现者

通过加密器和委托者的URL，创建 `AdminDelegatee` 类实例。并通过其管理受委托的后台。
