package main

import "fmt"

func shuffle(plates int, from, to, using *[]int) {

	if plates == 1 {
		n := len(*from) - 1
		*to = append(*to, (*from)[n])
		*from = (*from)[:n]
        return
	}

	shuffle(plates-1, from, using, to)
	n := len(*from) - 1
	*to = append(*to, (*from)[n])
	*from = (*from)[:n]

	fmt.Println("From: ", *from)
	fmt.Println("To: ", *to)
	fmt.Println("Using: ", *using)

	shuffle(plates-1, using, to, from)
}

func main() {
	var tests, plates int = 1, 5
	var from, to, using []int

	for ; tests > 0; tests-- {
		for i := plates; i > 0; i-- {
			from = append(from, i)
		}
		shuffle(plates, &from, &to, &using)
	}
}
