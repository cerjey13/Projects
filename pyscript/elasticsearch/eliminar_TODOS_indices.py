from elasticsearch6 import Elasticsearch
from datetime import datetime
#fecha del momento a ejecutarse el script
x = datetime.now()
año = x.strftime('%Y')
mes = x.month - 1
#servidor del elastic
ES_HOST = {
    "host" : "",   #IP DEL SERVIDOR
    "port" : 9200
}

i = 0

INDEX_NAME = ('enero'+ año, 'febrero' + año, 'marzo' + año, 'abril' + año, 'mayo' + año, 'junio' + año, 'julio' + año, 'agosto' + año ,'septiembre'+ año,'octubre' + año,'noviembre' + año,'diciembre' + año)

#preparar cliente de elasticsearch
es = Elasticsearch(hosts = [ES_HOST], http_auth=('elastic','1GctIQOJzvbHJfORrN0i') )
while i<len(INDEX_NAME):
    if es.indices.exists(INDEX_NAME[i]):
        #Eliminar todos los indices menos los 3 ultimos meses
        if ((INDEX_NAME[i] == INDEX_NAME[mes]) or (INDEX_NAME[i] == INDEX_NAME[mes - 1]) or (INDEX_NAME[i] == INDEX_NAME[mes - 2])):
            print(INDEX_NAME[i])
        else:
            res = es.indices.delete(index = INDEX_NAME[i])
    else:
        print('El indice no existe')
    i+=1