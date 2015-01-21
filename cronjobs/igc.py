import subprocess
import time
while True:
    subprocess.call("C:/xamp2/php/php.exe C:/xamp2/htdocs/cronjobs/igcmds.php")
    time.sleep(5)
