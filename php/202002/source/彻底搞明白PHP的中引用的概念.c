#include <stdio.h>
#include <stdlib.h>
 
int main()
{
    // C 中的指针和引用
    int a = 1;
    int* b = &a;
    printf("%i\n", a); // 1
    free(b); // free b
    printf("%i\n", a); //get error: *** error for object 0x7fff6350da08: pointer being freed was not allocated
    return 0;
}