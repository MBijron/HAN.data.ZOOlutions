@echo off
set errorlevel=0
if NOT EXIST terminal (
	echo "The terminal folder of the framework was not found. Cant use the terminal"
	goto eof
)

if "%1"=="" (
	echo Framework console V1.0 created by quesoft
	echo Type /help or /? for help
	echo.
	goto console
)
if "%1"=="/?" goto help
if "%1"=="/help" goto help

if exist terminal\%1.bat (
	call terminal\%1.bat %*
	if ERRORLEVEL 2 goto inv_args
	goto eof
)

goto inv_args

:inv_args
	echo "Invalid args where given. Use /help or /? to see all available commands"
goto eof

:console
	title Framework Console
	set /p command=enter command: 
	if "%command%"=="exit" goto eof
	call console %command%
	echo.
goto console

:help
	type terminal\help.txt
	echo.
goto eof

:eof