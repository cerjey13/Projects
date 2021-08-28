import os, re

lista = []
statusDiferente = []
nodoErr = []
started, starting, queque = 0, 0, 0

with open(r"C:\wamp64\www\trabajo\php\pos_atm\cmitout", 'r') as log:
    for i in log:
        if re.findall(r'.PROC1.*', i):
            lista.append(re.findall(r'.PROC1.*', i))
        if 'STATUS' in i:
            lista.append(i)

for i in lista:
    started = len(re.findall('STARTED', str(i))) + started
    starting = len(re.findall('STARTING', str(i))) + starting
    queque = len(re.findall('status failed, no obj met filter criteria', str(i))) + queque

started = str(started)
starting = str(starting)
queque = str(queque)

if (started != 727) or (starting != 17): #or (queque != 8):
    for i in lista:
        if len(re.findall('STARTED', str(i))) == 2:
            pass
        elif len(re.findall('STARTED', str(i))) == 1 and len(re.findall('STARTING', str(i))) == 1:
            pass
        elif "status failed, no obj met filter criteria." in i:
            pass
        else:
            statusDiferente.append(i)

    for j in statusDiferente:
        if re.findall(r'.PROC1.*', str(j)):
            if re.findall('status failed, no obj met filter criteria', str(j)) or len(re.findall('STARTED', str(j))) == 2:
                pass
            else:
                nodoErr.append(re.findall(r'(.PROC1[^\s]+)', str(j)))

with open(r"C:\wamp64\www\trabajo\php\pos_atm\output.txt", 'w') as f:
    f.write(started + "\n" + starting + "\n" + queque)
    for i in nodoErr:
        f.write("\n" + str(i).strip("[]'\\"))


