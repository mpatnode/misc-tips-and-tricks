#include <iostream>
using namespace std;

int report;

void shuffle(int plates, int from, int to, int use) {

    if (plates == 1) {
        if (--report == 0) {
            printf("%d %d\n", from, to);
        }
        return;
    }

    shuffle(plates - 1, from, use, to);
    if (--report == 0) {
        printf("%d %d\n", from, to);
    }

    shuffle(plates - 1, use, to, from);
}

int main() {
	int tests, plates;
	scanf("%d\n", &tests);
	for (int i = 0; i < tests; i++) {
	    scanf("%d %d\n", &plates, &report);
	    shuffle(plates, 1, 3, 2);
	}
	return 0;
}
