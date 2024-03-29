#include <iostream>
using namespace std;

int report;

void shuffle(int plates, int from, int to, int use) {

    if (plates == 1) {
        printf("move %d %d\n", from, to);
        return;
    }

    shuffle(plates - 1, from, use, to);
    printf("move %d %d\n", from, to);


    shuffle(plates - 1, use, to, from);
}

int main() {
	int plates;
    printf("Number of plates: ");
    scanf("%d", &plates);
    printf("\n");
    shuffle(plates, 1, 3, 2);
	return 0;
}
