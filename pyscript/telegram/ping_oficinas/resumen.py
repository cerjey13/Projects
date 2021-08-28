import os, csv

conexiones = [0] * 10
metro1, metro2, metro3, centro, andina, carabobo, occidente, oriente, sur, coccidente = ([] for i in range(10))

def resumen(conexiones):
    total = 0
    for datos in conexiones:
        total = total + datos
    metro1tot = "Region - Metro1: " + str(conexiones[0]) + " de 21" + "\n"
    resu.write(metro1tot)
    resu.writelines(metro1)
    resu.write("\n")
    resu.write("\n")
    metro2tot = "Region - Metro2: " + str(conexiones[1]) + " de 26" + "\n"
    resu.write(metro2tot)
    resu.writelines(metro2)
    resu.write("\n")
    resu.write("\n")
    metro3tot = "Region - Metro3: " + str(conexiones[2]) + " de 38" + "\n"
    resu.write(metro3tot)
    resu.writelines(metro3)
    resu.write("\n")
    resu.write("\n")
    centrotot = "Region - Centro: " + str(conexiones[3]) + " de 21" + "\n"
    resu.write(centrotot)
    resu.writelines(centro)
    resu.write("\n")
    resu.write("\n")
    andinatot = "Region - Andina: " + str(conexiones[4]) + " de 16" + "\n"
    resu.write(andinatot)
    resu.writelines(andina)
    resu.write("\n")
    resu.write("\n")
    carabobotot = "Region - Carabobo: " + str(conexiones[5]) + " de 22" + "\n"
    resu.write(carabobotot)
    resu.writelines(carabobo)
    resu.write("\n")
    resu.write("\n")
    coccidentetot = "Region - Centro Occidente: " + str(conexiones[6]) + " de 21" + "\n"
    resu.write(coccidentetot)
    resu.writelines(coccidente)
    resu.write("\n")
    resu.write("\n")
    occidentetot = "Region - Occidente: " + str(conexiones[7]) + " de 23" + "\n"
    resu.write(occidentetot)
    resu.writelines(occidente)
    resu.write("\n")
    resu.write("\n")
    oritentetot = "Region - Oriente: " + str(conexiones[8]) + " de 21" + "\n"
    resu.write(oritentetot)
    resu.writelines(oriente)
    resu.write("\n")
    resu.write("\n")
    surtot = "Region - Sur: " + str(conexiones[9]) + " de 19" + "\n"
    resu.write(surtot)
    resu.writelines(sur)
    resu.write("\n")
    resu.write("\n")
    total = "Total general de oficinas sin conexion: " + str(total)
    resu.write(total)


ruta = os.path.dirname(os.path.abspath(__file__))
if os.path.exists(ruta + '/resumen.txt'):
    os.remove(ruta + '/resumen.txt')
with open(ruta + "/oficinas_caidas.txt", 'r') as ofi, open(ruta + "/resumen.txt", 'a') as resu:
    obj = csv.reader(ofi, delimiter=';')
    for row in obj:
        if row[0] == 'Metro 1':
            conexiones[0] += 1
            metro1.append(row[1].strip() + ", ")
        if row[0] == 'Metro 2':
            conexiones[1] += 1
            metro2.append(row[1].strip() + ", ")
        if row[0] == 'Metro 3':
            conexiones[2] += 1
            metro3.append(row[1].strip() + ", ")
        if row[0] == 'Centro':
            conexiones[3] += 1
            centro.append(row[1].strip() + ", ")
        if row[0] == 'Andina':
            conexiones[4] += 1
            andina.append(row[1].strip() + ", ")
        if row[0] == 'Carabobo':
            conexiones[5] += 1
            carabobo.append(row[1].strip() + ", ")
        if row[0] == 'Centro Occidente':
            conexiones[6] += 1
            coccidente.append(row[1].strip() + ", ")
        if row[0] == 'Occidente':
            conexiones[7] += 1
            occidente.append(row[1].strip() + ", ")
        if row[0] == 'Oriente':
            conexiones[8] += 1
            oriente.append(row[1].strip() + ", ")
        if row[0] == 'SUR':
            conexiones[9] += 1
            sur.append(row[1].strip() + ", ")      
    resumen(conexiones)
        

    
