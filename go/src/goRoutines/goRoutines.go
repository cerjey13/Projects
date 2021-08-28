package main

import (
	"fmt"
	"sync"
)

var wg = sync.WaitGroup{}

func main() {
	wg.Add(1)
	go sayHello()
	wg.Wait()
}

func sayHello() {
	fmt.Println("Hello world")
	wg.Done()
}
