#include <stdio.h>
#include <climits>
#include <vector>
using namespace std;

int last = 0;
const char *names[] = {"A", "B", "C"};
int report;
int move_count;

void move(vector<int> pegs[], int from, int to) {
    last = pegs[from].back();
    pegs[from].pop_back();
    pegs[to].push_back(last);
    printf("Moved %d from %s to %s\n", last, names[from], names[to]);
    /*
    if (++move_count == report) {
        printf("%d %d\n", from + 1, to + 1);
    }
    */
}

int legal(int from, vector<int> pegs[]) {
    if (pegs[from].empty()) {
        return -1;
    }
    
    int value = pegs[from].back();
    if (value == last) {
        return -1;
    }
    
    int diff = INT_MAX;
    int candidate = -1;
    int ccount = 0;
    for (int i = 0; i < 3; i++) {
        if (from == i) {
            continue;
        }
        int ctop = pegs[i].empty() ? INT_MAX : pegs[i].back();
        if (value > ctop) {
            continue;
        }
        
        // even/odd optimization (ignore empty)
        if (ctop != INT_MAX && !((value ^ ctop) & 1)) {
            continue;
        }
        
        // move to the closest value
        if (ctop - value < diff) {
            candidate = i;
            diff = ctop - value;
        }
        
    }
    
    return candidate;
}

int main() {
    int tests, rings;

    // scanf("%d\n", &tests);
    tests = 1;
    for (int i = 0; i < tests; i++) {
        vector<int> pegs[3]; // from, to, use;
        move_count = 0;
        printf("Enter number of rings: ");
        scanf("%d", &rings);
        // scanf("%d %d\n", &rings, &report);
        for (int p = rings; p > 0; p--) {
            pegs[0].push_back(p);
        }
        move(pegs, 0, (rings & 1) ? 2 : 1);

        int dst;
        
        int count = 0;
        while (pegs[2].size() < rings) {
            for(int src = 0; src < 3; src++) {
                if ((dst = legal(src, pegs)) >= 0) {
                    move(pegs, src, dst);
                }
            }
        }
    }
    return 0;
}
