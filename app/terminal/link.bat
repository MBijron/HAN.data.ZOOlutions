@echo off
if not "%2"=="" if not "%3"=="" if not "%4"=="" (
	if "%5"=="" goto checks_3
	goto checks_4
)
exit /b 2

:checks_3
	if not exist controllers\%2.php (
		call console create controller %2
	)
	if not exist views\%3\%4.tpl (
		call console create view %3 %4
	)
	goto link_3
goto eof

:checks_4
	if not exist controllers\%2\%3.php (
		call console create controller %2 %3
	)
	if not exist views\%4\%5.tpl (
		call console create view %4 %5
	)
	goto link_4
goto eof

:link_3
	call powershell -Command "(gc controllers\%2.php) -replace 'general/samplepage', '%3/%4' | Out-File -Encoding utf8 controllers\%2.php"
	echo "The controller was linked to the view"
goto eof
	
:link_4
	call powershell -Command "(gc controllers\%2\%3.php) -replace 'general/samplepage', '%4/%5' | Out-File -Encoding utf8 controllers\%2\%3.php"
	echo "The controller was linked to the view"
goto eof

:eof