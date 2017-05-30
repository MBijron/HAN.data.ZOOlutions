@echo off
if "%4"=="" (
	if exist controllers\%3.php (
		echo "The controller %3 already exists"
		goto eof
	)
	copy "terminal\templates\controller" "controllers\%3.php" > nul
	call powershell -Command "(gc controllers\%3.php) -replace 'class_name', '%3' | Out-File -Encoding utf8 controllers\%3.php"
	echo "The controller was created succesfully"
)
if NOT "%4"=="" (
	if exist controllers\%3\%4.php (
		echo "The controller %3/%4 already exists"
		exit
	)
	if NOT exist controllers\%3 mkdir controllers\%3
	copy "terminal\templates\controller" "controllers\%3\%4.php" > nul
	call powershell -Command "(gc controllers\%3\%4.php) -replace 'class_name', '%4' | Out-File -Encoding utf8 controllers\%3\%4.php"
	echo "The controller was created succesfully"
)

:eof