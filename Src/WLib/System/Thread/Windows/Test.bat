@echo off

set PhpFile=Test.php8
set PHP_Path=C:\php-sdk\phpmaster\vs17\x64\php-src\x64\Debug
set Arg=
set Arg=%Arg% -d memory_limit=512M
set Arg=%Arg% -d "extension_dir=%PHP_Path%"
set Arg=%Arg% -c "%PHP_Path%"
@%PHP_Path%\php.exe -q %Arg% -f "%PhpFile%" -- %2 %3 %4 %5 %6 %7 %8 %9
