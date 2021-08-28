#linux
import os, csv, subprocess, datetime
conexiones = [0] * 10
metro1, metro2, metro3, centro, andina, carabobo, occidente, oriente, sur, coccidente = ([] for i in range(10))

def resumen():
    ruta = os.path.dirname(os.path.abspath(__file__))
    if os.path.exists(ruta + '/resumen_covid.txt'):
        os.remove(ruta + '/resumen_covid.txt')
    if os.path.exists(ruta + '/covid19.txt'):
        with open(ruta + "/covid19.txt", 'r') as ofi, open(ruta + "/resumen_covid.txt", 'a') as resu:
            obj = csv.reader(ofi, delimiter=';')
            for row in obj:
                if 'Metro 1' in row[0]:
                    conexiones[0] += 1
                    metro1.append(row[1].strip() + ", ")
                if  'Metro 2' in row[0]:
                    conexiones[1] += 1
                    metro2.append(row[1].strip() + ", ")
                if  'Metro 3' in row[0]:
                    conexiones[2] += 1
                    metro3.append(row[1].strip() + ", ")
                if  'Centro' in row[0]:
                    conexiones[3] += 1
                    centro.append(row[1].strip() + ", ")
                if  'Andina' in row[0]:
                    conexiones[4] += 1
                    andina.append(row[1].strip() + ", ")
                if  'Carabobo' in row[0]:
                    conexiones[5] += 1
                    carabobo.append(row[1].strip() + ", ")
                if  'Centro' in row[0]:
                    conexiones[6] += 1
                    coccidente.append(row[1].strip() + ", ")
                if  'Occidente' in row[0]:
                    conexiones[7] += 1
                    occidente.append(row[1].strip() + ", ")
                if  'Oriente' in row[0]:
                    conexiones[8] += 1
                    oriente.append(row[1].strip() + ", ")
                if  'SUR' in row[0]:
                    conexiones[9] += 1
                    sur.append(row[1].strip() + ", ")
            total = 0
            for datos in conexiones:
                total = total + datos
            metro1tot = "Region - Metro1: " + str(conexiones[0]) + "\n"
            resu.write(metro1tot)
            resu.writelines(metro1)
            resu.write("\n")
            resu.write("\n")
            metro2tot = "Region - Metro2: " + str(conexiones[1]) + "\n"
            resu.write(metro2tot)
            resu.writelines(metro2)
            resu.write("\n")
            resu.write("\n")
            metro3tot = "Region - Metro3: " + str(conexiones[2]) + "\n"
            resu.write(metro3tot)
            resu.writelines(metro3)
            resu.write("\n")
            resu.write("\n")
            centrotot = "Region - Centro: " + str(conexiones[3]) + "\n"
            resu.write(centrotot)
            resu.writelines(centro)
            resu.write("\n")
            resu.write("\n")
            andinatot = "Region - Andina: " + str(conexiones[4]) + "\n"
            resu.write(andinatot)
            resu.writelines(andina)
            resu.write("\n")
            resu.write("\n")
            carabobotot = "Region - Carabobo: " + str(conexiones[5]) + "\n"
            resu.write(carabobotot)
            resu.writelines(carabobo)
            resu.write("\n")
            resu.write("\n")
            coccidentetot = "Region - Centro Occidente: " + str(conexiones[6]) + "\n"
            resu.write(coccidentetot)
            resu.writelines(coccidente)
            resu.write("\n")
            resu.write("\n")
            occidentetot = "Region - Occidente: " + str(conexiones[7]) + "\n"
            resu.write(occidentetot)
            resu.writelines(occidente)
            resu.write("\n")
            resu.write("\n")
            oritentetot = "Region - Oriente: " + str(conexiones[8]) + "\n"
            resu.write(oritentetot)
            resu.writelines(oriente)
            resu.write("\n")
            resu.write("\n")
            surtot = "Region - Sur: " + str(conexiones[9]) + "\n"
            resu.write(surtot)
            resu.writelines(sur)
            resu.write("\n")
            resu.write("\n")
            total = "Total general de oficinas sin conexion: " + str(total)
            resu.write(total)
            tiempo = datetime.datetime.now()
            if int(tiempo.strftime('%H')) < 13:
                fecha = tiempo.strftime('%Y-%m-%d %H:%M:%S am')
            else:
                fecha = tiempo.strftime('%Y-%m-%d %H:%M:%S pm')
                rep = "\nReporte automatico del: " + str(fecha) + "\n"
                resu.write(rep)
    else:
        with open(ruta + "/resumen_covid.txt", 'a') as resu:
            metro1tot = "Region - Metro1: " + str(conexiones[0]) + "\n"
            resu.write(metro1tot)
            resu.write("\n")
            metro2tot = "Region - Metro2: " + str(conexiones[1]) + "\n"
            resu.write(metro2tot)
            resu.write("\n")
            metro3tot = "Region - Metro3: " + str(conexiones[2]) + "\n"
            resu.write(metro3tot)
            resu.write("\n")
            centrotot = "Region - Centro: " + str(conexiones[3]) + "\n"
            resu.write(centrotot)
            resu.write("\n")
            andinatot = "Region - Andina: " + str(conexiones[4]) + "\n"
            resu.write(andinatot)
            resu.write("\n")
            carabobotot = "Region - Carabobo: " + str(conexiones[5]) + "\n"
            resu.write(carabobotot)
            resu.write("\n")
            coccidentetot = "Region - Centro Occidente: " + str(conexiones[6]) + "\n"
            resu.write(coccidentetot)
            resu.write("\n")
            occidentetot = "Region - Occidente: " + str(conexiones[7]) + "\n"
            resu.write(occidentetot)
            resu.write("\n")
            oritentetot = "Region - Oriente: " + str(conexiones[8]) + "\n"
            resu.write(oritentetot)
            resu.write("\n")
            surtot = "Region - Sur: " + str(conexiones[9]) + "\n"
            resu.write(surtot)
            resu.write("\n")
            total = "Total general de oficinas sin conexion: 0"
            resu.write(total)
            tiempo = datetime.datetime.now()
            if int(tiempo.strftime('%H')) < 13:
                fecha = tiempo.strftime('%Y-%m-%d %H:%M:%S am')
            else:
                fecha = tiempo.strftime('%Y-%m-%d %H:%M:%S pm')
                rep = "\nReporte automatico del: " + str(fecha) + "\n"
                resu.write(rep)
    if os.path.exists(ruta + '/covid19.txt'):
        os.remove(ruta + '/covid19.txt')
        
def ping(archivo = '/covid.txt', log = '/covid19.txt'):
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
            #p[ip] = subprocess.Popen(['ping ', ip], stdout = subprocess.DEVNULL) #Windows
            p[ip] = subprocess.Popen(["ping -c 4 " + ip], stdout = subprocess.PIPE, shell=True) #linux
        
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
    print(datetime.datetime.now().strftime('%c'))

ping()
resumen()