@echo off
echo ����������ʡ�洢�ռ�
echo=
echo 1. ֹͣ����
echo 2. ��ɾ�����»����ļ���
echo %cd%\cache\*
echo %cd%\debug(debugging).log
echo %cd%\debug(chrome).log
echo=
echo=
echo ֹͣ���򡭡�
taskkill /f /im !������������ϲ�ѯ����.exe
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