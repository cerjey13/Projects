import pymysql, csv, os


db = pymysql.connect('localhost', 'root', '', 'prueba')

cursor = db.cursor()
#cursor.execute('SELECT * FROM Contingencia')
sql = """INSERT INTO Contingencia(ID, IP, LOG) VALUES(1, '192.168.1.1', 'prueba de log')"""

try:
    cursor.execute(sql)
    db.commit()
except:
    db.rollback()
    print('error')
db.close()