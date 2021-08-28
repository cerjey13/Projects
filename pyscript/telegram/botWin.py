#windows
import telebot, os, datetime, logging
TOKEN = '' #TOKEN

tb = telebot.TeleBot(TOKEN)
ruta = os.path.dirname(os.path.abspath(__file__))

logging.basicConfig(filename= ruta + '/Logs/log.log', filemode='a', level=logging.DEBUG, format='%(asctime)s - %(name)s - %(levelname)s - %(message)s')

#getMe
user = tb.get_me()

def fecha():
    fecha = datetime.datetime.now().strftime('%Y'+ '-' + '%m' + '-' +'%d')
    return fecha

def archivo(inicio, final): 
    dia = fecha()
    try:
        with open("C:/wamp64/www/trabajo/php/fallas/logs/log." + dia + '.txt', 'r', encoding='utf-8') as f:
            fallas = f.readlines()
            mensaje = ''
            for row in range(len(fallas)):
                if fallas[row].startswith(inicio):
                    desde = row
                if isinstance(final, str):
                    if fallas[row].startswith(final):
                        hasta = row
                else:
                    hasta = len(fallas)
            for i in range(desde, hasta, 1):
                mensaje = mensaje + fallas[i]
            if mensaje == "":
                mensaje = 'Log vacio'
    except FileNotFoundError as Error2:
        mensaje = 'Log Vacio'
        logging.exception('LOG', exc_info=Error2)
    except Exception as error:
        mensaje = 'Error ❌'
        logging.exception('LOG', exc_info=error)
    return mensaje

@tb.message_handler(commands=['start'])
def start_command(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, 'Bienvenido')

@tb.message_handler(commands=['estado'])
def estado_command(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, 'El bot esta en linea')

@tb.message_handler(commands=['oficinas'])
def oficina_command(message):
    estado = []
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    try:
        with open(ruta + "/ping_oficinas/resumen.txt", 'r') as f:
            estado = f.readlines()
            mensaje = ''
            for row in estado:
                mensaje = mensaje + row
    except FileNotFoundError as Error2:
        mensaje = 'Archivo No Encontrado.'
        logging.exception('LOG', exc_info=Error2)
    except Exception as error:
        mensaje = 'Error ❌'
        logging.exception('LOG', exc_info=error)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['oficinas_actual'])
def oficinas_actual_command(message):
    estado = []
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    try:
        os.system('python ' + ruta + '/ping_oficinas/ping.py')
        with open(ruta + "/ping_oficinas/resumen.txt", 'r') as f:
            estado = f.readlines()
            mensaje = ''
            for row in estado:
                mensaje = mensaje + row
    except FileNotFoundError as Error2:
        mensaje = 'Archivo No Encontrado.'
        logging.exception('LOG', exc_info=Error2)
    except Exception as error:
        mensaje = 'Error ❌'
        logging.exception('LOG', exc_info=error)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['covid19'])
def covid_command(message):
    estado = []
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    try:
        with open(ruta + "/covid/resumen_covid.txt", 'r') as f:
            estado = f.readlines()
            mensaje = ''
            mensaje = mensaje.encode()
            for row in estado:
                mensaje = mensaje + row.encode()
    except FileNotFoundError as Error2:
        mensaje = 'Archivo No Encontrado.'
        logging.exception('LOG', exc_info=Error2)
    except Exception as error:
        mensaje = 'Error ❌'
        logging.exception('LOG', exc_info=error)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje.decode())

@tb.message_handler(commands=['fallas'])
def falla_command(message):
    fallas = []
    dia = fecha()
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    try:
        with open("C:/wamp64/www/trabajo/php/fallas/logs/log." + dia + '.txt', 'r', encoding='utf-8') as f:
            fallas = f.readlines()
            mensaje = ''
            for row in fallas:
                mensaje = mensaje + row
            if mensaje == "":
                mensaje = 'Log vacio'
    except FileNotFoundError as Error2:
        mensaje = 'Log Vacio'
        logging.exception('LOG', exc_info=Error2)
    except Exception as error:
        mensaje = 'Error ❌'
        logging.exception('LOG', exc_info=error)
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['bancaenlinea'])
def bancaenlineaCommand(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    mensaje = archivo('Banca', 'TPago')
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['tpago'])
def tpagoCommand(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    mensaje = archivo('TPago', 'IVR')
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['ivr_cam'])
def ivrCamCommand(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    mensaje = archivo('IVR', 'Oficinas')
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['ofi'])
def ofiCommand(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    mensaje = archivo('Oficinas', 'Puntos')
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['pdventas'])
def PDVCommand(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    mensaje = archivo('Puntos', 'Cadenas')
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['cadenas'])
def cadenasCommand(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    mensaje = archivo('Cadenas', 'Cajeros')
    tb.send_chat_action(message.chat.id, 'typing')
    tb.send_message(message.chat.id, mensaje)

@tb.message_handler(commands=['cajeros'])
def cajerosCommand(message):
    print(str(message.chat.first_name) + " [" + str(message.chat.id) + "]: " + message.text)
    mensaje = archivo('Cajeros', 1)
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