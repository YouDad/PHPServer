@echo off
echo       统计代码行数 ver3.0
echo 这个bat用来统计您写了多少行代码
echo 新增功能:可以计算路径带空格的文件夹中的代码行数
set cppnum=0
set cpplinenum=0
set cnum=0
set clinenum=0
set hnum=0
set hlinenum=0
set temp=0
set /p path=请输入要被统计的文件夹路径:
for /r "%path%" %%i in ("*.php") do (
for /f "usebackq" %%j in ("%%i") do set /a cpplinenum+=1
echo %%i
set /a cppnum+=1
)
set temp=0
for /r "%path%" %%i in ("*.c") do (
for /f "usebackq" %%j in ("%%i") do set /a clinenum+=1
echo %%i
set /a cnum+=1
)
set temp=0
for /r "%path%" %%i in ("*.h") do (
for /f "usebackq" %%j in ("%%i") do set /a hlinenum+=1
echo %%i
set /a hnum+=1
)
echo 共有%cppnum%个PHP文件
echo 共有%cpplinenum%行
echo 共有%cnum%个C文件
echo 共有%clinenum%行
echo 共有%hnum%个H文件
echo 共有%hlinenum%行
pause