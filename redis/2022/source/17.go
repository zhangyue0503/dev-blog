package main

import (
	"fmt"
	"strconv"
	"time"

	"github.com/go-redis/redis"
)

func main17() {
	rdb := redis.NewClient(&redis.Options{
		Addr:     "unix:/tmp/redis.sock",
		Password: "",
		DB:       0,
	})

	rdb.FlushDB()

	t1 := time.Now()

	for i := 1; i < 100000; i++ {
		rdb.Set("info:"+strconv.Itoa(i), "val", -1)
	}

	// pipe := rdb.Pipeline()
	// for i := 1; i < 100000; i++ {
	// 	pipe.Set("info:"+strconv.Itoa(i), "val", -1)
	// }
	// pipe.Exec()

	t2 := time.Now()

	fmt.Println(t2.Sub(t1))
}
