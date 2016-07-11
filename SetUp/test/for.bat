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

@echo off
set a=bbs. verybat.cn
echo 替换前的值:"%a%"
set  var=%a:.=伤脑筋%
echo 替换后的值:"%var%"
pause
