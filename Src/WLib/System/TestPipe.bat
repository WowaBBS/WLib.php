@echo off
if '%1'=='' (
 call TestErr.bat Test 1>Out1.txt 2>Out2.txt 3>Out3.txt
) else (
 echo Hello1
rem echo Hello con
rem echo Hello0 0
rem echo Hello1>&1
 echo Hello2>&2
 echo Hello3>&3
)
