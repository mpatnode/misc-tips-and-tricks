#include <stdio.h>
#include <string.h>
#include <ctype.h>
#include <assert.h>
#include <stdlib.h>


char *uncompress(char *p, int* inc) {
    int count = 0;
    char *tmp, *u, *pstart = p;
    printf("uncompress %s\n", p);
    if (isdigit(*p)) {
        sscanf(p, "%d", &count);
        while (isdigit(*p)) p++;
        assert(*p == '[');
        p++;
        tmp = uncompress(p, inc);
        p += *inc;
        assert(*p == ']');
        p++;
        u = calloc(strlen(tmp) * count, sizeof(char));
        for (int i = 0; i < count; i++) {
            strcat(u, tmp);
        }
        free(tmp);
        *inc = p - pstart;
        return u;
    }
    else {
        tmp = strstr(p, "]");
        if (!tmp) {
            *inc = strlen(p);
        } 
        else {
           *inc = tmp - p;
        }
        printf("size = %d\n", *inc);
        u = malloc(*inc + 1);
        strncpy(u, p, *inc);
        u[*inc] = 0;
        return u;
    }
}

int main() {
	char *input = "3[abc]4[ab]c";
	char *u, *p = input;
    char *out = calloc(1, sizeof(char));
	int inc = 0;
	
    while (*p) {
        u = uncompress(p, &inc);
        out = realloc(out, strlen(out) + strlen(u) + 1);
        strcat(out, u);
        p += inc;
    }

	printf("%s\n", out);
	return(0);
}

