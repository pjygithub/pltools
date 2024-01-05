@echo off
echo 定期清理·节省存储空间
echo=
echo 1. 停止程序
echo 2. 将删除以下缓存文件：
echo %cd%\cache\*
echo %cd%\debug(debugging).log
echo %cd%\debug(chrome).log
echo=
echo=
echo 停止程序……
taskkill /f /im !电镀线生产资料查询工具.exe
ping -n 2 127.1 >nul 2>nul
echo=
echo= 
del /f /q %cd%\debug(debugging).log
del /f /q %cd%\debug(chrome).log
del /f /q %cd%\cache\*
del /f /q %cd%\cache\Cache\*
rd /s /q %cd%\cache\Cache\
rd /s /q %cd%\cache
echo=
echo=
@pause