@echo off
if exist views\%3\%4.tpl (
	echo "The view %3/%4 already exists"
	goto eof
)
if NOT exist views\%3 mkdir views\%3
copy "terminal\templates\view" "views\%3\%4.tpl" > nul
call powershell -Command "(gc views\%3\%4.tpl) -replace 'view_name', '%4' | Out-File -Encoding utf8 views\%3\%4.tpl"
echo "The view was created succesfully"

:eof