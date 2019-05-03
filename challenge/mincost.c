#include <stdio.h>
#define MAX 99999
int min ( int a, int b ) { return a < b ? a : b; }
 
int main() {
	//code
	int arr[] = {50, 100, 150, 200, 300};
	int cost[] = {2, 3, 4, 5, 6};
	int min_cost = MAX;
	int p1, p2;
	int len = sizeof(arr)/sizeof(arr[0]);
	
	for (int i = 0; i < len; i++) {
	    p1 = arr[i];
	    for (int j = 0; j < len; j++) {
	        int win = 1;
	        if (j == i) continue;
            p2 = arr[j];
            for (int m = 2; m <= min(p1, p2); m++) {
                if (p1 % m == 0 && p2 % m == 0) {
                    win = 0;
                    break;
                }
            }
            if (win) {
                min_cost = min(min_cost, cost[i] + cost[j]);
            }
	    }
	}
	printf("%d\n", min_cost == MAX ? -1 : min_cost) ;
}
