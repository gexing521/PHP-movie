# PHP-movie
php-协同过滤电影推荐
第一次接触php 使用yaf+yar做一个电影推荐系统。
主要系统思路:
1.	分为两个服务：平台服务，推荐服务—中间使用yar rpc远程调用（微服务那味）
2.	登录使用token验证，redis存放token进行主动过期
3.	用户看完电影（假装你看过了，看电影的代码还没写）评分，然后传消息给kafka，消费端消费之后调用推荐平台进行电影推荐
4.	推荐算法：给你篇文章自己看吧  https://www.jianshu.com/p/27d1e8b84c64
ps：服务器的ip没有删除到2022-11过期如果需要可以直接使用
