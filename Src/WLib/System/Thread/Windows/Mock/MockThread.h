#pragma once

#include <windows.h>

typedef void *HANDLE;
//typedef uint64_t HANDLE;
typedef unsigned long ThreadResult;
typedef void *ThreadParam; //uint64
typedef ThreadResult (*ThreadProc)(ThreadParam);

MOCK_THREAD_API HANDLE MyCreateThread(
  void          *lpThreadAttributes ,
  unsigned long  dwStackSize        ,
  ThreadProc     lpStartAddress     ,
  ThreadParam    lpParameter        ,
  unsigned long  dwCreationFlags    ,
  unsigned long *lpThreadId
);

MOCK_THREAD_API unsigned long MyWaitForSingleObject(HANDLE hHandle, unsigned long dwMilliseconds);
MOCK_THREAD_API int MyCloseHandle(HANDLE hObject);
