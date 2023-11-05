@echo off

setlocal

::@call "%~dp0Build/.Build.bat" Mock "Fast Debug" Win64 Build

set Root=%~dp0

if "%LogPath%"==""  set LogPath=%Root%
if not exist "%LogPath%" mkdir "%LogPath%"
if "%OutError%"=="" set OutError=%LogPath%/Build.err
if "%OutLog%"==""   set OutLog=%LogPath%/Build.log

pushd "%Root%"

set Params=
set Params=%Params% -cache "%Root%\.Build"
set Params=%Params% -modules "%Root%"
set Params=%Params% -target "Mock"
set Params=%Params% -configuration "Fast Debug"
set Params=%Params% -platform "Win64"
set Params=%Params% -log "%OutLog%"
set Params=%Params% -op Build

call "%Root%\WBuild/Build.bat" %Params% 2>"%OutError%"

popd

endlocal
