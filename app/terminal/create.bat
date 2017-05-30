@echo off
	if "%2"=="controller" if NOT "%3"=="" goto create_controller
	if "%2"=="model" if NOT "%3"==""  goto create_model
	if "%2"=="view" if NOT "%3"=="" if NOT "%4"==""  goto create_view
	exit /b 2
goto eof

:create_controller
	call terminal\scripts\createController.bat %*
goto eof

:create_model
	call terminal\scripts\createModel.bat %*
goto eof

:create_view
	call terminal\scripts\createView.bat %*
goto eof

:eof