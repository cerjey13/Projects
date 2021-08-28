package main

import (
	"fmt"
	"sync"
)

var wg2 = sync.WaitGroup{}

func main() {
	ch := make(chan int, 50)
	wg2.Add(2)
	go func(ch <-chan int) {
		for i := range ch {
			fmt.Println(i)
		}
		wg2.Done()
	}(ch)
	go func(ch chan<- int) {
		ch <- 42
		ch <- 27
		close(ch)
		wg2.Done()
	}(ch)
	wg2.Wait()
}
