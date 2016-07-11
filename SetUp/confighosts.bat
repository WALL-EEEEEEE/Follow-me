@REM @Author: Bian-Share
@REM @Date:   2016-07-10 16:31:37
@REM @Last Modified by:   Bian-Share
@REM Modified time: 2016-07-11 21:04:45

::Introduaction

::This script just for configing the host file, 
::registering the specific domain name into local dns file "hosts" 
::to making it can be access by entering domain  from you internent explorer.

@ECHO OFF
setlocal enabledelayedexpansion
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

::show the original hosts file content

:: type  %win_host_file_path%

:: clear existed variable
if defined register_domain_name   set  register_domain_name=  

set /p  register_domain_name= Enter the domain name to be registered^(Default-"%default_register_domain_name%"^):


if not "%register_domain_name%"=="" (  
                                    set register_domain_name=127.0.0.1   %register_domain_name%
                                    :: check wether domain registers in hosts file
                                    findstr   /I  /C:"!register_domain_name!"   %win_host_file_path%  
                                    if !errorlevel! == 0   echo "domain has registered !" && goto end
                                  ) else ( 
                                    set register_domain_name=127.0.0.1 @REM %default_register_domain_name%
                                    echo !register_domain_name!
                                    :: echo %win_host_file_path%
                                    findstr /i /C:"!register_domain_name!"   %win_host_file_path%  
                                    if !errorlevel!==0 ( echo domain has been registered!  && goto end )
                                  )


:: echo "test"
echo %register_domain_name% >>%win_host_file_path%
echo !errorlevel!
if !errorlevel! ==1  echo Please run the commond under administrator roles! && goto end

:: echo %register_domain_name%


 type %win_host_file_path%
:end
pause









