from elasticsearch6 import Elasticsearch
from datetime import datetime
#fecha del momento a ejecutarse el script
x = datetime.now()
año = x.strftime('%Y')

#servidor del elastic
ES_HOST = {
    "host" : "",   #IP DEL SERVIDOR
    "port" : 9200
}

mes = x.month - 4
INDEX_NAME = ('enero'+ año, 'febrero' + año, 'marzo' + año, 'abril' + año, 'mayo' + año, 'junio' + año, 'julio' + año, 'agosto' + año ,'septiembre'+ año,'octubre' + año,'noviembre' + año,'diciembre' + año)

#preparar cliente de elasticsearch
es = Elasticsearch(hosts = [ES_HOST], http_auth=('elastic','1GctIQOJzvbHJfORrN0i') )

#eliminar el index 
if es.indices.exists(INDEX_NAME[mes]):
    res = es.indices.delete(index = INDEX_NAME[mes])
else:
    print('El indice ' + INDEX_NAME[mes] + ' no existe')