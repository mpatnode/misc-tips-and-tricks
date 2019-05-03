#include <stdio.h>
#include <string.h>
#include <stdlib.h>
// 1  2  3  4
// 5  6  7  8
// 9  10 11 12
// 13 14 15 16
char letters[17] = "DOGKCATSBOOKCARS";
const char siblings[16][9] = {
    /* 1 */ {2, 5, 6, 0},
    /* 2 */ {1, 5, 6, 7, 3, 0},
    /* 3 */ {2, 6, 7, 8, 4, 0},
    /* 4 */ {3, 7, 8, 0},
    /* 5 */ {1, 2, 6, 10, 9, 0},
    /* 6 */ {1, 2, 3, 7, 11, 10, 9, 5, 0},
    /* 7 */ {2, 3, 4, 8, 12, 11, 10, 6, 0},
    /* 8 */ {3, 4, 7, 12, 11, 10, 0},
    /* 9 */ {5, 6, 10, 14, 13, 0},
    /* 10 */ {5, 6, 7, 11, 15, 14, 13, 9, 0},
    /* 11 */ {10, 6, 7, 8, 14, 15, 16, 9, 0},
    /* 12 */ {8, 7, 11, 15, 16, 0},
    /* 13 */ {9, 10, 14, 0},
    /* 14 */ {13, 9, 10, 11, 15, 0},
    /* 15 */ {14, 10, 11, 12, 16, 0},
    /* 16 */ {15, 11, 12, 0}
};

char *grep_dict(char* word) {
    static char BUFF[20];
    static char CMD[100];

    memset(CMD, 0, 100);
    sprintf(CMD, "egrep -i '^%s.*' /usr/share/dict/words", word);
    memset(BUFF, 0, 20);
    // printf("try: %s\n", word);
    FILE* p = popen(CMD, "r"); 
    fscanf(p, "%19s", BUFF); 
    pclose(p);
    /*
    if (*BUFF) {
        printf("found: %s\n", BUFF);
    }
    */
    return BUFF;
}

void check(int i, char* word, char* used) {
    char *results;

    sprintf(word, "%s%c", word, letters[i]); 
    used[i] = 1;

    if (strlen(word) > 1) {
        // Look for a wildcard match from the start of the current word
        results = grep_dict(word);
        if (*results) {
            // If we have 3 or more, look for an exact match in the results
            if (strlen(word) > 2 && strcasecmp(results, word) == 0) {
                printf("%s\n", word);
                // continue, since there could be a longer word as well
            }
        }
        else {
           // There are no words down this path. Pop off the last char and move along
           used[i] = 0;
           word[strlen(word)-1] = 0; 
           return;
       }
    }

    for (const char* s = siblings[i]; *s != 0; s++) {
        if (used[*s - 1]) {
            continue;
        }
        check(*s - 1, word, used);
    }
    used[i] = 0;
    word[strlen(word)-1] = 0; 
}

    

int main(int argc, const char* argv[]) {
    char used[16];
    char *word = calloc(strlen(letters) + 1, sizeof(char));

    if (argc > 1) {
       if (strlen(argv[1]) == 16) {
            strcpy(letters, argv[1]);
       }
       else {
          printf("enter a 16 char string");
          exit(1);
      }
   }

    printf("Puzzle");
    for (int i = 0; i < strlen(letters); i++) {
        if (i % 4 == 0) {
            putchar('\n');
        }
        putchar(letters[i]);
    }
    printf("\n---------\n");

    for (int i = 0; i < strlen(letters); i++) {
        check(i, word, used);
    }
    return 0;
}
