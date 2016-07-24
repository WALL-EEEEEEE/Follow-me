@REM @Author: Bian-Share
@REM @Date:   2016-07-10 16:31:37
@REM @Last Modified by:   Bian-Share
@REM Modified time: 2016-07-14 22:43:12

:: Introduaction

:: This script just for configing the host file, 
:: registering the specific domain name into local dns file "hosts" 
:: to making it can be access by entering domain  from you internent explorer.

@ECHO OFF
setlocal  EnableExtensions enabledelayedexpansion
ECHO "Your hosts will be changed for you domains registeration...";




rem  init some enviorment variable

if defined win_host_file_path(  set win_host_file_path=
  set win_host_file_path=C:\Windows\System32\Drivers\etc\hosts
  ) else (  
  set  win_host_file_path=C:\Windows\System32\Drivers\etc\hosts
  )



  if defined default_register_domain_name ( set default_register_domain_name=  
   set default_register_domain_name=www.followme.com
   ) else (  
   set  default_register_domain_name=www.followme.com
   )


   if not exist %win_host_file_path% (  echo  %win_host_file_path% is not exists, Please check your correct pathname!
    set /p  win_host_file_path=Please Enter your correct hosts path:
    )

   rem show the original hosts file content

   rem type  %win_host_file_path%

   rem clear existed variable
   if defined register_domain_name   set  register_domain_name=  

   set /p  register_domain_name= Enter the domain name to be registered^(Default-"%default_register_domain_name%"^):


   if not "%register_domain_name%"=="" (  
    set register_domain_name=127.0.0.1   %register_domain_name%

    rem generate regex parttern
    set replace_pattern=
    for /f "delims=" %%A in ("!register_domain_name!") do (
      for /f "tokens=1,2 delims= " %%B in ("%%A") do (
        set replace_pattern=^.*%%B\ *%%C.*$
        )

      )  

    @echo off
    : check wether domain registers in hosts file
    findstr  /I  /R /C:"!replace_pattern!"   %win_host_file_path% >nul 
    if !errorlevel! == 0   echo "domain has registered !" && goto end
    ) else ( 
    set register_domain_name=127.0.0.1   %default_register_domain_name%

    rem generate regex parttern
    set replace_pattern=
    for /f "delims=" %%A in ("!register_domain_name!") do (
     for /f "tokens=1,2 delims= " %%B in ("%%A") do (
       set replace_pattern=^.*%%B\ *%%C.*$
       )

     )  
    @echo off
    findstr /i /R /C:"!replace_pattern!"   %win_host_file_path%  >nul
    if !errorlevel!==0 ( echo domain has been registered!  && goto end )
    )


    rem check if cmd is running as administrator
    net session >nul 2>&1
    if not %errorlevel% == 0 (

      rem check write permission with current user for hosts file 
      cacls %win_host_file_path% | findstr  ".*%USERNAME%:(ID)[F|W]"

      if !errorlevel! == 1  (
       echo You don't have write permission on this file^^!Please run this command under administrator^^!  &&  goto end
       )

      )



    echo %register_domain_name% >>%win_host_file_path%

    rem echo %register_domain_name%


    type %win_host_file_path%
    :end
    pause









