package main

import (
	"fmt"
	"strconv"
	"strings"

	"github.com/go-redis/redis"
)

// func main() {
// 	rdb := redis.NewClient(&redis.Options{
// 		Addr:     "localhost:6379",
// 		Password: "",
// 		DB:       0,
// 	})

// 	rdb.FlushDB()

// 	for i := 1; i < 100000; i++ {
// 		rdb.Set("info:"+strconv.Itoa(i), "val", -1)
// 	}

// 	infos, _ := rdb.Info("memory").Result()
// 	fmt.Printf("%s", infos)
// }

func hash_get_key(key string) (k, f string) {
	s := strings.Split(key, ":")
	if len(s[1]) > 2 {
		return s[0] + ":" + s[1][0:len(s[1])-2], s[1][len(s[1])-2:]
	} else {
		return s[0] + ":", s[1]
	}
}

func main16() {
	rdb := redis.NewClient(&redis.Options{
		Addr:     "localhost:6379",
		Password: "",
		DB:       0,
	})

	rdb.FlushDB()

	for i := 1; i < 100000; i++ {
		k, f := hash_get_key("info:" + strconv.Itoa(i))
		rdb.HSet(k, f, "val")
	}
	fmt.Println()
	infos, _ := rdb.Info("memory").Result()
	fmt.Printf("%s", infos)
}
