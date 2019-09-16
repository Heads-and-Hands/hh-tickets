@echo off

rem -------------------------------------------------------------
rem  Yii command line bootstrap script for Windows.
<<<<<<< HEAD
rem
rem  @author Qiang Xue <qiang.xue@gmail.com>
rem  @link http://www.yiiframework.com/
rem  @copyright Copyright (c) 2008 Yii Software LLC
rem  @license http://www.yiiframework.com/license/
=======
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
rem -------------------------------------------------------------

@setlocal

set YII_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%YII_PATH%yii_test" %*

@endlocal
