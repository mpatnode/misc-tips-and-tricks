#include <iostream>
#include <vector> 
#include <cstring>
#include <numeric>
using namespace std;

int calc(const char *expression) {
  vector<int> values;
  vector<char> ops;
  char buffer[100];
  int a, b, bytes;
  char oper;
  int results = 0;
  
  for (size_t i = 0; i < strlen(expression);) {
    if (i == 0) {
      sscanf(expression, "%d%c%d%n", &a, &oper, &b, &bytes);
      values.push_back(a);
      values.push_back(b);
      ops.push_back(oper);
    }
    else {
      sscanf(expression + i, "%c%d%n", &oper, &b, &bytes);
      values.push_back(b);
      ops.push_back(oper);
    }
    i += bytes;
  }
  
//  6   +
//  7   *
// 10   +
// 11
//
  int i = 0;
  for (auto c: ops) {
    if (c == '*') {
      a = values[i];
      b = values[i+1];
      values[i+1] = a * b;  
      values[i] = 0;
    }
    i++;
  }
  
  return accumulate(values.begin(), values.end(), 0);
  
}

int main() {
  printf("%s = %d\n", "600*-7*10+1", calc("600*-7*10+1"));
  printf("%s = %d\n", "6+7", calc("6+7"));
  printf("%s = %d\n", "6+7*10", calc("6+7*10"));
}