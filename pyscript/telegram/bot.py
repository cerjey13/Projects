#linux
import telebot, os, datetime, logging
TOKEN = '' #TOKEN

tb = telebot.TeleBot(TOKEN)
ruta = os.path.dirname(os.path.abspath(__file__))

logging.basicConfig(filename= ruta + '/Logs/log.log', filemode='a', level=logging.DEBUG, format='%(asctime)s - %(name)s - %(levelname)s - %(message)s')

#getMe
user = tb.get_me()

@tb.message_handler(commands=['start'])
def start_command(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, 'Bienvenido')

@tb.message_handler(commands=['estado'])
def estado_command(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, 'El bot esta en lineaa')

@tb.message_handler(commands=['oficinas'])
def oficina_command(message):
    estado = []
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    with open(ruta + "/ping_oficinas/resumen.txt", 'r') as f:
        estado = f.readlines()
        mensaje = ''
        for row in estado:
            mensaje = mensaje + row
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['oficinas_actual'])
def oficinas_actual_command(message):
    estado = []
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    os.system('python ' + ruta + '/ping_oficinas/ping.py')
    with open(ruta + "/ping_oficinas/resumen.txt", 'r') as f:
        estado = f.readlines()
        mensaje = ''
        for row in estado:
            mensaje = mensaje + row
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['covid19'])
def covid_command(message):
    estado = []
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    with open(ruta + "/covid/resumen_covid.txt", 'r') as f:
        estado = f.readlines()
        mensaje = ''
        mensaje = mensaje.encode()
        for row in estado:
            mensaje = mensaje + row.encode()
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje.decode())

@tb.message_handler(commands=['fallas'])
def falla_command(message):
    fallas = []
    fecha = datetime.datetime.now()
    dia = fecha.strftime('%Y'+ '-' + '%m' + '-' +'%d')
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    try:
        with open("/var/www/html/fallas/logs/log." + dia + '.txt', 'r') as f:
            fallas = f.readlines()
            mensaje = ''
            for row in fallas:
                mensaje = mensaje + row
            if mensaje == "":
                mensaje = 'Log vacio'
    except Exception as e:
        mensaje = 'Log Vacio'
        logging.exception('LOG', exc_info=e)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['resumen'])
def resumenCommand(message):
    resumen= []
    fecha = datetime.datetime.now()
    dia = fecha.strftime('%Y'+ '-' + '%m' + '-' +'%d')
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    try:
        with open(r"C:\wamp64\www\trabajo\php\resumen\logs\log." + dia + '.txt', 'r', encoding='utf8') as f:
            resumen= f.readlines()
            mensaje = ''
            for row in resumen:
                mensaje = mensaje + row
            if mensaje == "":
                mensaje = 'Log vacio'
    except Exception as e:
        mensaje = 'Log Vacio'
        logging.exception('LOG', exc_info=e)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

#getUpdates
print("Activo")
tb.polling(none_stop=True, interval=0, timeout=20)
"""while True:
    try:
        print("Activo")
        tb.polling(True)
    except Exception as e:
        logging.basicConfig(filename= ruta + '/Logs/log.log', filemode='a', level=logging.DEBUG, format='%(asctime)s - %(name)s - %(levelname)s - %(message)s')
        logging.exception('LOG', exc_info=e)
        logging.error("Error", exc_info=True)"""
