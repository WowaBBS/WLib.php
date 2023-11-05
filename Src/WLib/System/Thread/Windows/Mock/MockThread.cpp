#include <iostream>
#include <windows.h>
#include "MockThread.h"

#define EnableWrapper 1

BOOL WINAPI DllMain(
    HINSTANCE hinstDLL,  // handle to DLL module
    DWORD     fdwReason,     // reason for calling function
    LPVOID    lpvReserved   // reserved
)
{
  std::cout<<"DllMain\n";
  // Perform actions based on the reason for calling.
  switch(fdwReason)
  { 
  case DLL_PROCESS_ATTACH : std::cout<<"ProcessAttach\n"; break; //Initialize once for each new process. //Return FALSE to fail DLL load.
  case DLL_THREAD_ATTACH  : std::cout<<"ThreadAttach\n"; break; //Do thread-specific initialization.
  case DLL_THREAD_DETACH  : std::cout<<"ThreadDetach\n"; break; //Do thread-specific cleanup.
  case DLL_PROCESS_DETACH:
    if(lpvReserved!=nullptr)
      std::cout<<"ProcessDetach?\n";
    else
      std::cout<<"ProcessDetach?\n";
    break;  // Perform any necessary cleanup.
  default:
    std::cout<<"DllMain?\n";
  }
  return TRUE;  // Successful DLL_PROCESS_ATTACH.
}  

typedef void *HANDLE;
//typedef uint64_t HANDLE;
typedef unsigned long DWORD;

struct TWrapProc
{
  ThreadProc  Proc  ;
  ThreadParam Param ;
  
  TWrapProc(ThreadProc aProc, ThreadParam aParam)
    :Proc(aProc) ,Param(aParam)
  {
  }
  
  ThreadResult Call() { return Proc(Param); }

  static TWrapProc* Create(ThreadProc Proc, ThreadParam Param) { return new TWrapProc(Proc, Param); }
  void Destroy() { delete this; }
};

unsigned long MyProc(void* Param)
{
  auto WrapProc=(TWrapProc*)Param;
  if(EnableWrapper)
  {
    std::cout<<"MyProc Begin\n";
    
    int msgboxID = MessageBox(
      NULL,
      "Resource not available\nDo you want to try again?",
      "Account Details",
      MB_ICONWARNING | MB_CANCELTRYCONTINUE | MB_DEFBUTTON2
    );
    
    auto Res=WrapProc->Call();
    std::cout<<"MyProc End\n";
    WrapProc->Destroy();
    return Res;
  }
  std::cout<<"MyProc\n";
  
  return 123;
}

HANDLE MyCreateThread(
  void          *lpThreadAttributes ,
  unsigned long  dwStackSize        ,
  ThreadProc     lpStartAddress     ,
  ThreadParam    lpParameter        ,
  unsigned long  dwCreationFlags    ,
  unsigned long *lpThreadId
)
{
  std::cout<<"CreateThread\n";
  if(EnableWrapper)
  {
    auto MyParam=TWrapProc::Create(lpStartAddress, lpParameter);
    auto Res=CreateThread(
      (LPSECURITY_ATTRIBUTES)lpThreadAttributes ,
      dwStackSize        ,
      &MyProc            ,//lpStartAddress     ,
      MyParam            ,//lpParameter        ,
      dwCreationFlags    , 
      lpThreadId
    );
    std::cout<<"CreateThread.Res: "<<Res<<"\n";
    return Res;
  }
  else
  {
    auto Res=lpStartAddress(lpParameter);
    std::cout<<"CreateThread.Proc.Res: "<<Res<<"\n";
    return (void*)113;
  }
}

unsigned long MyWaitForSingleObject(HANDLE hHandle, unsigned long dwMilliseconds)
{
  std::cout<<"WaitForSingleObject\n";
  if(EnableWrapper)
    return WaitForSingleObject(hHandle, dwMilliseconds);
  return 0;
}

int MyCloseHandle(HANDLE hObject)
{
  std::cout<<"CloseHandle\n";
  if(EnableWrapper)
    return CloseHandle(hObject);
  return 111;
}
      