#linux
from apscheduler.schedulers.background import BlockingScheduler
import os, csv, subprocess, datetime

loop = BlockingScheduler()

@loop.scheduled_job('interval', seconds = 300)
def ping(archivo = '/oficinas.txt', log = '/oficinas_caidas.txt'):
    print(datetime.datetime.now().strftime('%c'))
    ruta = os.path.dirname(os.path.abspath(__file__))
    lista = []
    if os.path.exists(ruta + log):
        os.remove(ruta + log)

    p = {}
    with open(ruta + archivo, 'r') as csvfile:
        spam = csv.reader(csvfile, delimiter=';')
        for row in spam: # comienza el proceso de hacer ping
            ip = row[2]
            p[ip] = subprocess.Popen(["ping -c 4 " + ip], stdout = subprocess.PIPE, shell=True)
        
    while p:
        for ip, proc in p.items():
            if proc.poll() is not None: # termina el ping?
                del p[ip]  # quitar ip de la lista de proceso
                if proc.returncode == 0:
                    pass
                elif proc.returncode == 1:
                    lista.append(str(ip))
                else:
                    pass
                break

    with open(ruta + archivo, 'r') as csvfile:
        spam = csv.reader(csvfile, delimiter=';')
        for row in spam: 
            for i in lista:
                if (i == row[2]):
                    with open(ruta + log, 'a') as f:
                        f.write(row[0] + ';' + row[1] + '\n')
    os.system('python ' + ruta + '/resumen.py')

loop.start()