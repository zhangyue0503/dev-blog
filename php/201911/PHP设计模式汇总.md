# PHP设计模式汇总

没想到啊，没想到。自己竟然坚持了下来，完成了设计模式深入的学习，并且输出了23篇用php演示的设计模式的文章。但这不是最主要的，更深层次的收获是顺便背下了这些模式的定义及类图。在深入学习了设计模式之后，对Laravel等框架的架构理解也更清楚明了了。就像我在很多模式的讲解中都引用了在Laravel中相关的实现。

从今年2月份到现在，历时9个月，从开始的一周一篇到一周两篇。也让自己看到了坚持的可贵。同时也渐渐用自身经历体会到了一个道理，**基础的才是最重要的**。就像韩寒电影中所说：”听过那么道理，却依然过不好这一生。“在我们学习的过程中也一样，都知道基础有用，但是却总想去追新追潮流，但这些新的知识或者潮流却是那些最原始基础的演变和发展，万变不离其宗才是硬道理。接下来的计划是？没错，明年是更大的挑战，数据结构与算法，同时补习数学。所以，明年的连载文章会以算法为主。除此之外，也会连载关于Laravel6和TP6相关的文章，各位看官还请多多指教。

一家之言有时候并不一定能让你深刻的体会或者理解知识。就像《如何阅读一本书》中的主题阅读一样，用多本参考书或者学习资料来相互进行补充的**主题阅读**方式往往能带来更好的效果。注意，这里不是每一本书或者每一篇资料都从头到尾看一遍，那样你的时间耗费不起，而是直接去找资料中和你当前所学习内容相关的内容进行阅读学习。所以，我的参考资料有这些：

> 书籍

- 《设计模式：可复用面向对象软件的基础》 [https://union-click.jd.com/jdc?e=&p=AyIGZRtYFAcXBFIZWR0yEgRSGFkRCxs3EUQDS10iXhBeGlcJDBkNXg9JHU4YDk5ER1xOGRNLGEEcVV8BXURFUFdfC0RVU1JRUy1OVxUBFQRXH1IcMlVjVR4OUFZHZwdfQVB4dWM0WVgPd0QLWStaJQITBVAZWRYBEDdlG1wlUHzf462DsLMO0%2F%2BUjp2VIgZlG18TABIBVxJdFAoQBWUcWxwyWV4FRA1dRkYGURpZJTIiBGUraxUyETcXdV9HAhcFVBJZQVEWBlAcW0YKElVdHQkdA0VTAh1YEgVFN1caWhEL](https://union-click.jd.com/jdc?e=&p=AyIGZRtYFAcXBFIZWR0yEgRSGFkRCxs3EUQDS10iXhBeGlcJDBkNXg9JHU4YDk5ER1xOGRNLGEEcVV8BXURFUFdfC0RVU1JRUy1OVxUBFQRXH1IcMlVjVR4OUFZHZwdfQVB4dWM0WVgPd0QLWStaJQITBVAZWRYBEDdlG1wlUHzf462DsLMO0%2F%2BUjp2VIgZlG18TABIBVxJdFAoQBWUcWxwyWV4FRA1dRkYGURpZJTIiBGUraxUyETcXdV9HAhcFVBJZQVEWBlAcW0YKElVdHQkdA0VTAh1YEgVFN1caWhEL)
- 《大话设计模式》 [https://union-click.jd.com/jdc?e=&p=AyIGZRNZFQERBVYaWyUCEwRSE1gTCxsEZV8ETVxNNwxeHlRAGRlLQx5BXg1bSkAOClBMW0tdC1ZWDEANTx0KUkBCDUUEG0RCRAFjDhkCEwRSE1gTCxsEZUU4cHdWBAV%2FPlUBZF9QHAFdfFtaUE1XGTITN1UaWRAAEARWGWslAhU3FHVeFQMbBWUaaxUGFAVVHVkdARYEVxhrEgIbNx5CC0pUWkMBGl8UACI3ZRhrJTISN1YrGXtWQlNSEwkRVxUGVh5eEgFHD10aWB0LRlMAGllABkEFXStZFAMWDg%3D%3D](https://union-click.jd.com/jdc?e=&p=AyIGZRNZFQERBVYaWyUCEwRSE1gTCxsEZV8ETVxNNwxeHlRAGRlLQx5BXg1bSkAOClBMW0tdC1ZWDEANTx0KUkBCDUUEG0RCRAFjDhkCEwRSE1gTCxsEZUU4cHdWBAV%2FPlUBZF9QHAFdfFtaUE1XGTITN1UaWRAAEARWGWslAhU3FHVeFQMbBWUaaxUGFAVVHVkdARYEVxhrEgIbNx5CC0pUWkMBGl8UACI3ZRhrJTISN1YrGXtWQlNSEwkRVxUGVh5eEgFHD10aWB0LRlMAGllABkEFXStZFAMWDg%3D%3D)
- 《Head Frist设计模式》 [https://union-click.jd.com/jdc?e=&p=AyIGZRtYFAcXBFIZWR0yEgZVGloWABU3EUQDS10iXhBeGlcJDBkNXg9JHU4YDk5ER1xOGRNLGEEcVV8BXURFUFdfC0RVU1JRUy1OVxUDEgZUGFkSMmEBNkMEdnJuZwEYAXBLallPGCYUe1QLWStaJQITBVAZWRYBEDdlG1wlUHzf462DsLMO0%2F%2BUjp2VIgZlG18TABIBVxJfEgsRBmUcWxwyWV4FRA1dRkYGURpZJTIiBGUraxUyETcXdV9HAhcFVBJZQVEWBlAcW0YKElVdHQkdA0VTAh1YEgVFN1caWhEL](https://union-click.jd.com/jdc?e=&p=AyIGZRtYFAcXBFIZWR0yEgZVGloWABU3EUQDS10iXhBeGlcJDBkNXg9JHU4YDk5ER1xOGRNLGEEcVV8BXURFUFdfC0RVU1JRUy1OVxUDEgZUGFkSMmEBNkMEdnJuZwEYAXBLallPGCYUe1QLWStaJQITBVAZWRYBEDdlG1wlUHzf462DsLMO0%2F%2BUjp2VIgZlG18TABIBVxJfEgsRBmUcWxwyWV4FRA1dRkYGURpZJTIiBGUraxUyETcXdV9HAhcFVBJZQVEWBlAcW0YKElVdHQkdA0VTAh1YEgVFN1caWhEL)
- 《PHP设计模式》 [https://union-click.jd.com/jdc?e=&p=AyIGZRtSHAERB1ATXhEyFgJdHl8WBxMFVxhrUV1KWQorAlBHU0VeBUVNR0ZbSkdETlcNVQtHRVNSUVNLXANBRA1XB14DS10cQQVYD21XHgNQE14RARcGVxlYJQBAYidNU253d29PSyl1XEtOBUQ%2BHXIeC2UaaxUDEAJXGVgWACI3VRxrVGwSBlQfXRMCGzdUK1sRBBAHUxlTEAQWAVQrXBULIkwMSwRDSlZTVB9aFzIiN1YrayUCIgRlWTVHUkcAABJaFgEQBVIeXRIFG1NcSVIRUBsGVU8OEAoVBWUZWhQGGw%3D%3D](https://union-click.jd.com/jdc?e=&p=AyIGZRtSHAERB1ATXhEyFgJdHl8WBxMFVxhrUV1KWQorAlBHU0VeBUVNR0ZbSkdETlcNVQtHRVNSUVNLXANBRA1XB14DS10cQQVYD21XHgNQE14RARcGVxlYJQBAYidNU253d29PSyl1XEtOBUQ%2BHXIeC2UaaxUDEAJXGVgWACI3VRxrVGwSBlQfXRMCGzdUK1sRBBAHUxlTEAQWAVQrXBULIkwMSwRDSlZTVB9aFzIiN1YrayUCIgRlWTVHUkcAABJaFgEQBVIeXRIFG1NcSVIRUBsGVU8OEAoVBWUZWhQGGw%3D%3D)
- 《JavaScript设计模式》 [https://union-click.jd.com/jdc?e=&p=AyIGZRtSFQASAVIfXxIyFgJVH1kVAhYAXBhrUV1KWQorAlBHU0VeBUVNR0ZbSkdETlcNVQtHRVNSUVNLXANBRA1XB14DS10cQQVYD21XHgNQG18XAhIDUhJYJUpFWFxoKEVycVBPfCd3A1B3PWQ8YEQeC2UaaxUDEAJXGVgWACI3VRxrVGwSBlQfXRwDETdUK1sRBBAHUxlTEgQVB1ErXBULIkwMSwRDSlZTVB9aFzIiN1YrayUCIgRlWTVAAhAOUEgLFQIVBgYeWhMDQVdUT1sSARMDBx5eEgIXA2UZWhQGGw%3D%3D](https://union-click.jd.com/jdc?e=&p=AyIGZRtSFQASAVIfXxIyFgJVH1kVAhYAXBhrUV1KWQorAlBHU0VeBUVNR0ZbSkdETlcNVQtHRVNSUVNLXANBRA1XB14DS10cQQVYD21XHgNQG18XAhIDUhJYJUpFWFxoKEVycVBPfCd3A1B3PWQ8YEQeC2UaaxUDEAJXGVgWACI3VRxrVGwSBlQfXRwDETdUK1sRBBAHUxlTEgQVB1ErXBULIkwMSwRDSlZTVB9aFzIiN1YrayUCIgRlWTVAAhAOUEgLFQIVBgYeWhMDQVdUT1sSARMDBx5eEgIXA2UZWhQGGw%3D%3D)

> 网络教程

- 腾讯课堂：大话PHP设计模式
- 网易云课堂：JavaScript高级与设计模式 [https://study.163.com/course/introduction/1006362058.htm?share=1&shareId=1137475601&utm_content=courseIntro&utm_u=1137475601&utm_source=weixin](https://study.163.com/course/introduction/1006362058.htm?share=1&shareId=1137475601&utm_content=courseIntro&utm_u=1137475601&utm_source=weixin)
- 网易云课堂：尚学堂-史上最易懂的设计模式视频
- GitChat：白话设计模式28讲
- GitChat：经典设计模式实战演练

当我完成这一系列文章的时候，极客时间的优秀作者王争老师也出了一套设计模式的专栏。他的数据结构与算法专栏卖得非常火爆，而且组织的线下算法训练营也已经开了好几期，期期好评。将来的学习计划中他的这个专栏也是重点要学习的内容。虽说这个设计模式专栏在我已经学习完设计模式之后才出来，但还是抑制不住我这个极客时间铁粉的买买买之路。

仔细研究了下他的这个《设计模式之美专栏》，发现不仅仅局限于那23种设计模式，还包括：

- 200+真实案例分析与设计
- 顶尖互联网公司的编程经验分享
- 应对设计模式面试的思路与技巧

下面是具体的课程列表：


不用我多说了吧，如果是PHPer，配合着我的系列文章一起学习更能事半功倍。快来加入一起学习吧！扫描识别下方二维码进入学习！


 # 设计模式文章汇总：

> 创建型模式

- 简单工厂

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/01.simple-factory/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/01.simple-factory/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/k_4AOqnW4FPcslcG8r5x_g](https://mp.weixin.qq.com/s/k_4AOqnW4FPcslcG8r5x_g)

    掘金：[https://juejin.im/post/5ced0dd0e51d4550a629b1f6](https://juejin.im/post/5ced0dd0e51d4550a629b1f6)

- 工厂方法

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/02.factory/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/02.factory/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/UeLrBQW6sKLgszovzYNt-g](https://mp.weixin.qq.com/s/UeLrBQW6sKLgszovzYNt-g)

    掘金：[https://juejin.im/post/5cf53a3051882506400062f7](https://juejin.im/post/5cf53a3051882506400062f7)

- 抽象工厂

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/03.abstract-factory/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/03.abstract-factory/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/8IgYen6QxKUnMFriWrI6yA](https://mp.weixin.qq.com/s/8IgYen6QxKUnMFriWrI6yA)

    掘金：[https://juejin.im/post/5cfde72ef265da1bc64bb6d8](https://juejin.im/post/5cfde72ef265da1bc64bb6d8)

- 原型模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/08.prototype/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/08.prototype/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/KO4TuT2t5Xh_3BG3UrfN1w](https://mp.weixin.qq.com/s/KO4TuT2t5Xh_3BG3UrfN1w)

    掘金：[https://juejin.im/post/5d65400bf265da03d60f1044](https://juejin.im/post/5d65400bf265da03d60f1044)
    
- 生成器模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/16.builder/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/16.builder/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/AhCLhH3rQAOULdZ2NtSGDw](https://mp.weixin.qq.com/s/AhCLhH3rQAOULdZ2NtSGDw)

    掘金：[https://juejin.im/post/5da3c17a6fb9a04e046bc7ab](https://juejin.im/post/5da3c17a6fb9a04e046bc7ab)
    
- 单例模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/21.singleton/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/21.singleton/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/xJPF0dJYorbjhDQJMxogpQ](https://mp.weixin.qq.com/s/xJPF0dJYorbjhDQJMxogpQ)

    掘金：[https://juejin.im/post/5db8d763f265da4d2e121d47](https://juejin.im/post/5db8d763f265da4d2e121d47)
    
> 结构型模式

- 适配器模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/05.adapter/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/05.adapter/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/kgBY2gnI65TiCIxatbmO8A](https://mp.weixin.qq.com/s/kgBY2gnI65TiCIxatbmO8A)

    掘金：[https://juejin.im/post/5d47ef645188250525750ac2](https://juejin.im/post/5d47ef645188250525750ac2)
    
- 桥接模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/18.bridge/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/18.bridge/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/_o3FkcbKXHdUIMDgMbQOiA](https://mp.weixin.qq.com/s/_o3FkcbKXHdUIMDgMbQOiA)

    掘金：[https://juejin.im/post/5dabe31e6fb9a04e0855c54d](https://juejin.im/post/5dabe31e6fb9a04e0855c54d)
    
- 组合模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/14.composite/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/14.composite/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/f4YCkz29uwppKNpf3FyZ5Q](https://mp.weixin.qq.com/s/f4YCkz29uwppKNpf3FyZ5Q)

    掘金：[https://juejin.im/post/5d9a9ef66fb9a04e19504b4f](https://juejin.im/post/5d9a9ef66fb9a04e19504b4f)
    
- 装饰器模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/04.decorator/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/04.decorator/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/aimblTTMqqEqmuvU9kUH1g](https://mp.weixin.qq.com/s/aimblTTMqqEqmuvU9kUH1g)

    掘金：[https://juejin.im/post/5d1087366fb9a07eaf2b9d26](https://juejin.im/post/5d1087366fb9a07eaf2b9d26)
    
- 外观模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/19.facade/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/19.facade/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/RzCoM96XnlT610q4AiuAVA](https://mp.weixin.qq.com/s/RzCoM96XnlT610q4AiuAVA)

    掘金：[https://juejin.im/post/5dae4ccaf265da5ba7453baa](https://juejin.im/post/5dae4ccaf265da5ba7453baa)
    
- 享元模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/13.flyweights/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/13.flyweights/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/w0T01O86XobBtrz-4389gQ](https://mp.weixin.qq.com/s/w0T01O86XobBtrz-4389gQ)

    掘金：[https://juejin.im/post/5d914cf0f265da5b81793c5f](https://juejin.im/post/5d914cf0f265da5b81793c5f)
    
- 代理模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/12.proxy/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/12.proxy/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/0CvVMuP-_j-0sqRK_4kcZA](https://mp.weixin.qq.com/s/0CvVMuP-_j-0sqRK_4kcZA)

    掘金：[https://juejin.im/post/5d871413e51d453b1e478b8e](https://juejin.im/post/5d871413e51d453b1e478b8e)
    
> 行为型模式

- 责任链模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/11.chain-of-responsiblity/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/11.chain-of-responsiblity/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/ZA9vyCEkEg9_KTll-Jkcqw](https://mp.weixin.qq.com/s/ZA9vyCEkEg9_KTll-Jkcqw)

    掘金：[https://juejin.im/post/5d7e4926e51d4561a705bbbc](https://juejin.im/post/5d7e4926e51d4561a705bbbc)
    
- 命令模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/09.command/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/09.command/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/meIF_xSo4pHRYBon7tqvfw](https://mp.weixin.qq.com/s/meIF_xSo4pHRYBon7tqvfw)

    掘金：[https://juejin.im/post/5d6ccba15188252e96191b41](https://juejin.im/post/5d6ccba15188252e96191b41)
    
- 迭代器模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/07.iterator/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/07.iterator/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/uycac0OXYYjAG1BlzTUjsw](https://mp.weixin.qq.com/s/uycac0OXYYjAG1BlzTUjsw)

    掘金：[https://juejin.im/post/5d5a3997e51d45620c1c53ba](https://juejin.im/post/5d5a3997e51d45620c1c53ba)
    
- 中介者模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/15.mediator/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/15.mediator/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/RS5HGDAO21LkKbf_JU-0Fw](https://mp.weixin.qq.com/s/RS5HGDAO21LkKbf_JU-0Fw)

    掘金：[https://juejin.im/post/5d9e79b56fb9a04e343d5335](https://juejin.im/post/5d9e79b56fb9a04e343d5335)
    
- 备忘录模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/17.memento/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/17.memento/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/iXF_Vr2Z31tBfq8k0ZRqMA](https://mp.weixin.qq.com/s/iXF_Vr2Z31tBfq8k0ZRqMA)

    掘金：[https://juejin.im/post/5da51488f265da5b6e0a4080](https://juejin.im/post/5da51488f265da5b6e0a4080)
    
- 观察者模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/06.observer/blod.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/06.observer/blod.md)

    微信公众号：[https://mp.weixin.qq.com/s/SlSToMIGNBtU06BWNCwWvg](https://mp.weixin.qq.com/s/SlSToMIGNBtU06BWNCwWvg)

    掘金：[https://juejin.im/post/5d4f93d46fb9a06ae439e53d](https://juejin.im/post/5d4f93d46fb9a06ae439e53d)
    
- 状态模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/22.state/blod.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/22.state/blod.md)

    微信公众号：[https://mp.weixin.qq.com/s/-hhdecA38V0O0j2gFBE_8g](https://mp.weixin.qq.com/s/-hhdecA38V0O0j2gFBE_8g)

    掘金：[https://juejin.im/post/5dbeea3be51d456e4871af33](https://juejin.im/post/5dbeea3be51d456e4871af33)
    
- 策略模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/10.strategy/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/10.strategy/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/BU6EHMvU9ssvBkUYdJtT9w](https://mp.weixin.qq.com/s/BU6EHMvU9ssvBkUYdJtT9w)

    掘金：[https://juejin.im/post/5d7508d5f265da03b76b4653](https://juejin.im/post/5d7508d5f265da03b76b4653)
    
- 模板方法模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/20.template-method/blod.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/20.template-method/blod.md)

    微信公众号：[https://mp.weixin.qq.com/s/2sX1ASQpnMybJ2xFqRR3Ig](https://mp.weixin.qq.com/s/2sX1ASQpnMybJ2xFqRR3Ig)

    掘金：[https://juejin.im/post/5db63432e51d456bd1552325](https://juejin.im/post/5db63432e51d456bd1552325)
    
- 访问者模式

    GitHub：[https://github.com/zhangyue0503/designpatterns-php/blob/master/23.visitor/blog.md](https://github.com/zhangyue0503/designpatterns-php/blob/master/23.visitor/blog.md)

    微信公众号：[https://mp.weixin.qq.com/s/nXE_RQGSyx9rgs5-cTULUQ](https://mp.weixin.qq.com/s/nXE_RQGSyx9rgs5-cTULUQ)

    掘金：[https://juejin.im/post/5dc2124c518825108334bd09](https://juejin.im/post/5dc2124c518825108334bd09)
    
