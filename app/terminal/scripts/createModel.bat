@echo off
if exist models\%3Model.php (
	echo "The model %3Model already exists"
	goto eof
)
copy "terminal\templates\model" "models\%3Model.php" > nul
call powershell -Command "(gc models\%3Model.php) -replace 'class_name', '%3Model' | Out-File -Encoding utf8 models\%3Model.php"
echo "The model was created succesfully"

:eof