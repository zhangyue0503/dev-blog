pcntl

Parallel



ldd 程序依赖的动态库信息查看

nm 查看.so文件的函数



strace -f -s 65500 -i -T -o test.txt -p 23187

```
strace -tt -T -v -f -e trace=file -o /data/log/strace.log -s 1024 -p 23489
```

> -tt 在每行输出的前面，显示毫秒级别的时间
> -T 显示每次系统调用所花费的时间
> -v 对于某些相关调用，把完整的环境变量，文件stat结构等打出来。
> -f 跟踪目标进程，以及目标进程创建的所有子进程
> -e 控制要跟踪的事件和跟踪行为,比如指定要跟踪的系统调用名称
> -o 把strace的输出单独写到指定的文件
> -s 当系统调用的某个参数是字符串时，最多输出指定长度的内容，默认是32个字节
> -p 指定要跟踪的进程pid, 要同时跟踪多个pid, 重复多次-p选项即可。
>
> -i 在系统调用时打印指令指针
>
> -c 统计每一系统调用的所执行的时间,次数和出错的次数等。示例：打印执行uptime时系统系统调用的时间、次数、出错次数和syscall

-e trace=set

仅跟踪指定的系统调用集。该-c选项用于确定哪些系统调用可能是跟踪有用有用。例如，trace=open，close，read，write表示仅跟踪这四个系统调用。

-e trace=file

跟踪所有以文件名作为参数的系统调用。

示例：打印执行ls时跟文件有关的系统调用。

```text
# strace -e trace=file ls
```

-e trace=process

跟踪涉及过程管理的所有系统调用。这对于观察进程的派生，等待和执行步骤很有用。

-e trace=network

跟踪所有与网络相关的系统调用。

-e trace=signal

跟踪所有与信号相关的系统调用。

-e trace=ipc

跟踪所有与IPC相关的系统调用。