package main

import (
	"fmt"
	"math/rand"
	"os"
	"strconv"
	"sync"
	"time"

	"github.com/go-redis/redis"
)

// 无锁，多协程
// var (
// 	c chan struct{}
// 	r *redis.Client
// )

// func main() {
// 	r = redis.NewClient(&redis.Options{
// 		Addr: "127.0.0.1:6379",
// 	})
// 	r.Del("stock")

// 	chanCount := 5
// 	c = make(chan struct{}, chanCount)

// 	for i := chanCount; i > 0; i-- {
// 		go func() {
// 			for {
// 				stock, err := r.Get("stock").Int()
// 				if err != nil {
// 					continue
// 				}
// 				if stock <= 0 {
// 					break
// 				}
// 				r.Decr("stock")
// 			}
// 			c <- struct{}{}
// 		}()
// 	}

// 	for i := chanCount; i > 0; i-- {
// 		<-c
// 	}
// }

// 本地锁
// var (
// 	c chan struct{}
// 	r *redis.Client
// 	l sync.Mutex
// )

// func main() {
// 	r = redis.NewClient(&redis.Options{
// 		Addr: "127.0.0.1:6379",
// 	})
// 	r.Del("stock", "lock", "verify")

// 	chanCount := 5
// 	c = make(chan struct{}, chanCount)

// 	for i := chanCount; i > 0; i-- {
// 		go func() {
// 			for {
// 				l.Lock()
// 				stock, err := r.Get("stock").Int()
// 				if err != nil {
// 					l.Unlock()
// 					continue
// 				}
// 				if stock <= 0 {
// 					l.Unlock()
// 					break
// 				}
// 				r.Decr("stock")
// 				l.Unlock()
// 			}
// 			c <- struct{}{}
// 		}()
// 	}

// 	for i := chanCount; i > 0; i-- {
// 		<-c
// 	}
// }

// SETNX锁
// var (
// 	c chan struct{}
// 	r *redis.Client
// 	l sync.Mutex
// )

// func main() {
// 	r = redis.NewClient(&redis.Options{
// 		Addr: "127.0.0.1:6379",
// 	})
// 	r.Del("stock", "lock")

// 	chanCount := 5
// 	c = make(chan struct{}, chanCount)

// 	for i := chanCount; i > 0; i-- {
// 		go func() {
// 			for {
// 				l.Lock()
// 				b := r.SetNX("lock", 1, 0)
// 				if b.Err() != nil || !b.Val() {
// 					l.Unlock()
// 					continue
// 				}

// 				stock, err := r.Get("stock").Int()
// 				if err != nil {
// 					r.Del("lock")
// 					l.Unlock()
// 					continue
// 				}
// 				if stock <= 0 {
// 					r.Del("lock")
// 					l.Unlock()
// 					break
// 				}
// 				r.Decr("stock")
// 				l.Unlock()
// 				r.Del("lock")
// 			}
// 			c <- struct{}{}
// 		}()
// 	}

// 	for i := chanCount; i > 0; i-- {
// 		<-c
// 	}
// }

// 过期时间与内容一致
// var (
// 	c chan struct{}
// 	r *redis.Client
// 	l sync.Mutex
// )

// func main() {
// 	r = redis.NewClient(&redis.Options{
// 		Addr: "127.0.0.1:6379",
// 	})
// 	r.Del("stock", "lock")

// 	chanCount := 5
// 	c = make(chan struct{}, chanCount)

// 	for i := chanCount; i > 0; i-- {
// 		go func(index int) {
// 			lockId := strconv.Itoa(os.Getpid()) + ":" + strconv.Itoa(index)
// 			for {
// 				l.Lock()
// 				b := r.SetNX("lock", lockId, 10*time.Second)
// 				if b.Err() != nil || !b.Val() {
// 					l.Unlock()
// 					continue
// 				}
// 				var t *time.Timer
// 				go func() {
// 					t = time.AfterFunc(10*time.Second/3, func() {
// 						fmt.Println("续命1次")
// 						r.Expire("lock", 10*time.Second)
// 					})
// 				}()
// 				// rand.Seed(time.Now().UnixNano())
// 				// randomNum := rand.Intn(15) // 生成0~9的随机数
// 				// time.Sleep(time.Duration(randomNum) * time.Second)

// 				stock, err := r.Get("stock").Int()
// 				if err != nil {
// 					if r.Get("lock").Val() == lockId {
// 						r.Del("lock")
// 						t.Stop()
// 						l.Unlock()
// 					}
// 					continue
// 				}

// 				if stock <= 0 {
// 					if r.Get("lock").Val() == lockId {
// 						r.Del("lock")
// 						t.Stop()
// 						l.Unlock()
// 					}
// 					break
// 				}

// 				r.Decr("stock")
// 				// fmt.Println(r.Get("stock").Val())

// 				if r.Get("lock").Val() == lockId {
// 					r.Del("lock")
// 					t.Stop()
// 					l.Unlock()
// 				}
// 			}
// 			c <- struct{}{}
// 		}(i)
// 	}

// 	for i := chanCount; i > 0; i-- {
// 		<-c
// 	}
// }

var (
	c     chan struct{}
	r     *redis.Client
	l     sync.Mutex
	cLock CLock
)

func main() {

	r = redis.NewClient(&redis.Options{
		Addr: "127.0.0.1:6379",
	})
	r.Del("stock", "lock", "verify")

	chanCount := 5
	c = make(chan struct{}, chanCount)

	for i := chanCount; i > 0; i-- {
		// 协程处理
		go decr(i)
	}

	for i := chanCount; i > 0; i-- {
		<-c
	}
}

func decr(i int) {
	// 初始化锁对象
	cLock = CLock{key: "lock", expire: 3 * time.Second}

	// 解锁操作函数
	allUnLock := func() {
		l.Unlock()
		cLock.UnLock()
	}

	// 异常处理
	defer func() {
		if err := recover(); err != nil {
			// 发生异常，解锁
			l.Unlock()
			allUnLock()
		}
	}()

	for {
		l.Lock() // 原生锁
		// 一致性
		lockId := strconv.Itoa(os.Getpid()) + ":" + strconv.Itoa(i)
		cLock.Lock(lockId) // 分布式锁

		// 续命
		go func() {
			cLock.lifeTimer = time.AfterFunc(cLock.expire-cLock.expire/3, cLock.Life)
		}()

		// 模拟耗时操作
		rand.Seed(time.Now().UnixNano())
		randomNum := rand.Intn(6)
		time.Sleep(time.Duration(randomNum) * time.Second)

		stock, err := r.Get("stock").Int()
		if err != nil {
			allUnLock()
			continue
		}

		if stock <= 0 {
			allUnLock()
			c <- struct{}{}
			break
		}

		r.Decr("stock")

		// 数据如果有重复操作，提示出来，并停止当前进程
		if res, _ := r.SAdd("verify", r.Get("stock").Val()).Result(); err != nil || res == 0 {
			allUnLock()
			fmt.Println("数据有重复: ", r.Get("stock").Val())
			os.Exit(1)
		}
		// 打印操作的是谁
		fmt.Println(lockId, "操作:", r.Get("stock").Val())

		allUnLock()
	}
}

type CLock struct {
	key       string        // 锁的 Key
	expire    time.Duration // 超时时间
	life      int           // 续命次数
	lifeTimer *time.Timer   // 续命定时器
	lockId    string        // 锁的值
}

func (cLock *CLock) Lock(id string) {
	for {
		b := r.SetNX(cLock.key, id, cLock.expire)
		if b.Err() != nil {
			fmt.Println(b.Err().Error())
			continue
		}
		if b.Val() {
			break
		}
	}
	cLock.life = 0
	cLock.lockId = id
	if cLock.lifeTimer != nil {
		cLock.lifeTimer.Stop()
	}
}

func (cLock *CLock) UnLock() {
	getId := r.Get(cLock.key).Val()
	if getId == cLock.lockId {
		r.Del(cLock.key)
		if cLock.lifeTimer != nil {
			cLock.lifeTimer.Stop()
		}
	}
}

func (cLock *CLock) Life() {
	if cLock.lockId != "" {
		if cLock.life < 3 {
			getId := r.Get(cLock.key).Val()
			if getId == cLock.lockId {
				r.Expire(cLock.key, cLock.expire)
				cLock.life++
				// cLock.lifeTimer.Stop()
				cLock.lifeTimer = time.AfterFunc(cLock.expire-cLock.expire/3, cLock.Life)
				fmt.Println(cLock.lockId, "续命", cLock.life, "次")
			}
		} else {
			panic("续命超次数")
		}
	}
}
