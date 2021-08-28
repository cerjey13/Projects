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

INDEX_NAME = ('enero', 'febrero' , 'marzo' , 'abril' , 'mayo' , 'junio' , 'julio' , 'agosto'  ,'septiembre','octubre' ,'noviembre' ,'diciembre' )
i = 0
# Crear el cliente de ES, crear el index
es = Elasticsearch(hosts = [ES_HOST], http_auth=('elastic','1GctIQOJzvbHJfORrN0i') )
while i<len(INDEX_NAME):
    if es.indices.exists(INDEX_NAME[i]):
        print('El indice ' + INDEX_NAME[i] + ' ya existe')
    # since we are running locally, use one shard and no replicas
    else:
        request_body = {
            "settings" : {
                "number_of_shards": 8,
                "number_of_replicas": 0
            }
        }
        print("creating '%s' index..." % (INDEX_NAME[i]))
        res = es.indices.create(index = INDEX_NAME[i], body = request_body)
        print(" response: '%s'" % (res))
    i+=1