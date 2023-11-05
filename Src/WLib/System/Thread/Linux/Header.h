//#define FFI_SCOPE "Linux_Threads"
#define FFI_LIB "libpthread.so.0"

//typedef void* ThreadResult;
typedef uint64_t ThreadResult;
//typedef void* ThreadParam;
typedef uint64_t ThreadParam;
typedef ThreadResult (*ThreadProc)(ThreadParam);

typedef uint64_t pthread_t;

struct pthread_attr_t
{
  uint32_t flags          ;
  void    *stack_base     ;
  size_t   stack_size     ;
  size_t   guard_size     ;
  int32_t  sched_policy   ;
  int32_t  sched_priority ;
};

int pthread_create(
        pthread_t      *thread        ,
  const pthread_attr_t *attr          ,
        ThreadProc      start_routine ,
        ThreadParam     arg
);

int pthread_join(
  pthread_t     thread,
  ThreadResult *value_ptr
);
