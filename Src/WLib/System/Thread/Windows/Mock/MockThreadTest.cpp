
#include <iostream>
#include "MockThread.h"

#if 0
# define MyCreateThread        CreateThread
# define MyWaitForSingleObject WaitForSingleObject
# define MyCloseHandle         CloseHandle
#endif

unsigned long MyProc(ThreadParam Param)
{
  std::cout<<"MyProc\n";
  return 123;
}

int main(int argc, char *argv[])
{
  std::cout<<"Starting\n";

  unsigned long ThreadId;
  HANDLE Handle=MyCreateThread(
    nullptr , // void          *lpThreadAttributes ,
    0       , // unsigned long  dwStackSize        ,
    &MyProc ,
    nullptr , // void          *lpParameter        ,
    0       , // unsigned long  dwCreationFlags    ,
    &ThreadId // unsigned long *lpThreadId
  );

  std::cout<<"Started\n";
  std::cout<<"Handle: "<<Handle<<"\n";
  std::cout<<"ThreadId: "<<ThreadId<<"\n";
  if(!Handle) { std::cout<<"Failed to create thread\n"; return 0; }

//Sleep(1);

  // Wait for finishing thread
  std::cout<<"Waiting\n";
  unsigned long Result = MyWaitForSingleObject(Handle, -1);
  if(Result!=0) std::cout<<"Wait for thread failed\n";
  std::cout<<"Ok\n";

  // Close thread descriptor
  std::cout<<"Closing\n";
  MyCloseHandle(Handle);
  
  std::cout<<"Thread closed\n";
}
