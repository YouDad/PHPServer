@echo off
echo       ͳ�ƴ������� ver3.0
echo ���bat����ͳ����д�˶����д���
echo ��������:���Լ���·�����ո���ļ����еĴ�������
set cppnum=0
set cpplinenum=0
set cnum=0
set clinenum=0
set hnum=0
set hlinenum=0
set temp=0
set /p path=������Ҫ��ͳ�Ƶ��ļ���·��:
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
echo ����%cppnum%��PHP�ļ�
echo ����%cpplinenum%��
echo ����%cnum%��C�ļ�
echo ����%clinenum%��
echo ����%hnum%��H�ļ�
echo ����%hlinenum%��
pause