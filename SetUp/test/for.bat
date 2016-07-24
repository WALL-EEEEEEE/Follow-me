::learn for syntax in ms-dos


:: open serveral command windows 

:: for  /L  %%a  in (1,1,5)  DO  start cmd

:: FOR /F "delims==" %%i IN ('dir /b') DO @echo  %%~pi 
:: pause 


:: @echo off
:: set /p input= 算数表达式
:: set /a var=%input%
:: echo 结果:  %input%=%var%

:: pause

:: @echo off
:: set /p n=请输入2的几次方
:: set /a num=1^<^<n
:: echo %num%
:: pause

:: @echo off
:: set a=bbs. verybat.commentsn
:: echo 替换前的值:"%a%"
:: set  var=%a:.=伤脑筋%
:: echo 替换后的值:"%var%"
:: pause
:: @echo off
:: set hello=bianjianhuang
:: for /F "tokens=2 delims=" %%I in ("%hello%") do echo %%I %%J %%K *

:: pause

::  @echo off
::  setlocal EnableExtensions EnableDelayedExpansion
::  set "Line=32768 004:47 2686976 2200:03 11707819 10000:01 (xfer#5264, to-check=1020/6975)"

:: set "Last="
:: for /f "delims=" %%A in ( 'echo("%Line::="^&echo("%"' ) do (
::   for /f "tokens=2" %%B in ("%%A") do (
::        if defined This set "Last=!This!"
::        set "This=%%B"
::    )
::)
::echo %Last%

::endlocal
::pause >nul

:: @echo off
:: rem 首先建立临时文件test.txt 
:: echo ;注释行,这是临时文件,用完删除 >test.txt
:: echo 11段 12段 13段 14段 15段 16段 >>test.txt 
:: echo 21段,22段,23段,24段,25段,26段 >>test.txt 
:: echo 31段-32段-33段-34段-35段-36段 >>test.txt 


:: FOR /F "eol=; tokens=3 delims=,- " %%i in (test.txt) do echo %%i  
:: Pause 
:: Del test.txt

@echo off
setlocal EnableExtensions EnableDelayedExpansion
set register_domain_name=www.baidu.com
set register_domain_name=127.0.0.1   %register_domain_name%


set "replace_pattern="
for /f "delims=" %%A in ("%register_domain_name%") do (
    
    for /f "tokens=1,2 delims= " %%B in ("%%A") do (
    	 set "replace_pattern=%%B^ *%%C"
    )

)  

echo  %replace_pattern%