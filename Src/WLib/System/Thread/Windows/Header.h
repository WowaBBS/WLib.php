#define FFI_SCOPE "Windows_Threads"
//#define FFI_LIB "MockThread.dll"
#define FFI_LIB "kernel32.dll"

//typedef void  *HANDLE ;
typedef uint64_t HANDLE ;

typedef unsigned long ThreadResult;
//typedef void* ThreadParam;
typedef uint64_t ThreadParam;
typedef ThreadResult (*ThreadProc)(ThreadParam);

HANDLE CreateThread(
  void          *lpThreadAttributes ,
  unsigned long  dwStackSize        ,
  ThreadProc     lpStartAddress     ,
  ThreadParam    lpParameter        ,
  unsigned long  dwCreationFlags    ,
  unsigned long *lpThreadId
);

unsigned long WaitForSingleObject(HANDLE hHandle, unsigned long dwMilliseconds);

int CloseHandle(HANDLE hObject);
