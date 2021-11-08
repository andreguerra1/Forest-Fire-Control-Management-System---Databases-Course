#!/usr/bin/env python3
from random import *
from copy import *
from datetime import *
import lorem

n_camaras = 100
meios = [[("Camiao", ["Combate"]), ("Ambulancia", ["Socorro"])], [("Carro de Combate", ["Combate", "Apoio"]), ("Camiao Trator", ["Combate", "Apoio"])], 
        [("Helicoptero", ["Combate", "Socorro"]), ("Aviao", ["Combate"])], [("Carro", ("Apoio")), ("Mota", ("Apoio")), ("Cavalo", ("Apoio")), ("Bicicleta", ("Apoio"))], 
        [("Carro", ("Apoio")), ("Autocarro", ("Apoio")), ("Carrinha Mercadorias", ("Apoio"))]]

locais = []


def generate_numbers(prefix,n):
    numbers =  n // len(prefix) + 1
    lst = []

    for p in prefix:
        for i in range(numbers):
            num = p*10000000 + randint(1000000,9999999)
            lst += ["'" + str(num) + "'"]
    return lst


def generate_timestamp(n):
    lst = []
    for i in range(n):
        timestamp = ""
        year = randint(2017,2018)
        month = randint(1,9)
        day = randint(1,28)
        hour = randint(0,23)
        minutes = randint(0,59)
        seconds = (randint(0,59))

        timestamp += "'" + str(year) + "-" + str(month).rjust(2, "0") +  "-" + str(day).rjust(2, "0") + " " + str(hour).rjust(2, "0") + ":" + str(minutes).rjust(2, "0") + ":" + str(seconds).rjust(2, "0") + "'"
        
        lst += [timestamp]

    return lst

def generate_segmentos(videos):

    lst = []

    for v in videos:
        datai = datetime(int(v[1][0:4], 10), int(v[1][5:7], 10), int(v[1][8:10], 10), int(v[1][11:13], 10), int(v[1][14:16], 10), int(v[1][17:19], 10))
        for i in range(23):

            dataf = datai + timedelta(minutes=59, seconds=59)
            lst += [[i, v[0], str(datai), str(dataf), "0 00:59:59.00"]]
            #datai = dataf + timedelta(seconds=1)
        dataf = datai + timedelta(hours=1)
        lst += [[i, v[0], str(datai), str(dataf), "0 01:00:00.00"]]
    return lst


def generate_singularTimestamp():
    timestamp = ""
    year = randint(2017,2018)
    month = randint(1,9)
    day = randint(1,28)
    hour = randint(0,23)
    minutes = randint(0,59)
    seconds = (randint(0,59))

    timestamp += "'" + str(year) + "-" + str(month).rjust(2, "0") +  "-" + str(day).rjust(2, "0") + " " + str(hour).rjust(2, "0") + ":" + str(minutes).rjust(2, "0") + ":" + str(seconds).rjust(2, "0") + "'"
    
    return timestamp

def generate_video():
    lst = []

    for i in range(100):
        v_rand = randint(5, 15)
        date = generate_singularTimestamp()
        datai = datetime(int(date[1:5], 10), int(date[6:8], 10), int(date[9:11], 10), int(date[12:14], 10), int(date[15:17], 10), int(date[18:20], 10))
        for j in range(v_rand): 
            dataf = datai + timedelta(days=1)
            lst += [[i, str(datai), str(dataf)]]
            datai = dataf + timedelta(seconds=1)
        

    return lst

def generate_cidades():
    global locais
    file = open("loc.txt", "r")
    locs = file.readlines()
    file.close()

    for l in locs:
        locais += [l[:-1]]
    

def generate_entities(entities, n):
    numbers = n // len(entities)
    lst = []
    
    for e in entities:
        for i in range(numbers):
            num = str(i).rjust(3, "0")
            lst += [e + num]

    return lst

def generate_meios(entities, n, type, start):
    #n_meio
    #nome_meio
    #nome_entidade
    global meios
    lst = []
    for i in range(start, n + start):
        m = 0
        meio_idx = 0
        while(True):
            idx = randint(0, len(entities) - 1)
            meio_idx = idx // 20
            m = randint(0, len(meios[meio_idx]) - 1)
            if type in meios[meio_idx][m][1]:
                break

        lst += [[i, meios[meio_idx][m][0], entities[idx]]]
    
    return lst

def generate_id(n):
    lst = []
    for i in range(n):
        lst += [i]

    return lst


def generate_events(proc, extra):
    lst = []
    for n in proc:
        lst += []

def generate_names(n):
    f_names = open("names.txt", "r")
    f_apelidos = open("apelidos.txt", "r")
    
    names = f_names.readlines()
    apelidos = f_apelidos.readlines()

    lst = []

    for i in range(n):
        idx_n = randint(0, len(names)-1)
        idx_a = randint(0, len(apelidos)-1)
        name = names[idx_n][:-1] + " " + apelidos[idx_a][:-1]
        lst += [name]

    f_names.close()
    f_apelidos.close()

    return lst



def generate_acciona(meios, proc):
    meio_r = deepcopy(meios)

    lst = []
    meio_r = meio_r[1:]
    shuffle(meio_r)

    for i in proc:
        n = randint(1, 10)
        shuffle(meio_r)
        for j in range(n):
            lst += [[meio_r[j][0], meio_r[j][2], i]]
        
        lst += [[meios[0][0], meios[0][2], i]]

    return lst

def generate_transports(meios, acciona, n):
    m = []
    acc = []
    lst = []
    for meio in meios:
        m += [[meio[0], meio[2]]]
    
    for a in acciona:
        if [a[0], a[1]] in m:
            lst += [[a[0], a[1], randint(1, n), a[2]]]
    return lst
    

def generate_audita(acciona, coords):
    a = deepcopy(acciona)
    shuffle(a)
    lst = []
    datesi = generate_timestamp(len(coords))
    datesf = []
    
    for i in range(len(coords)):
        date = datesi[i]

        datesf += [datetime(int(date[1:5], 10), int(date[6:8], 10), int(date[9:11], 10), int(date[12:14], 10), int(date[15:17], 10), int(date[18:20], 10))]
        datesf[i] = datesf[i] + timedelta(hours=randint(1, 23), days=randint(0, 3), minutes=randint(0, 59), seconds=randint(0, 59))
        
        lst += [[coords[randint(0, len(coords) - 1)], a[i][0], a[i][1], a[i][2], datesi[i], "'" + str(datesf[i]) + "'", "'" + datesi[i][1:11] + "'", "\'" + lorem.sentence() + "\'"]]

    return lst

def generate_solicita(coords, videos):
    lst = []
    for i in range(2*len(coords)):
        idx_c = randint(0, len(coords) - 1)
        idx_v = randint(0, len(videos) - 1)
        date = videos[idx_v][1]
        dateiv = datetime(int(date[0:4], 10), int(date[5:7], 10), int(date[8:10], 10), int(date[11:13], 10), int(date[14:16], 10), int(date[17:19], 10))
        
        datei = dateiv + timedelta(days=randint(10, 40))
        datef = datei + timedelta(days=randint(2, 4))

        lst += [[str(coords[idx_c]), str(dateiv), str(videos[idx_v][0]), str(datei), str(datef)]]

    return lst

def Main():
    global n_camaras
    generate_cidades()
    file_name = "populate.sql"
    file = open(file_name, "w")
    ent = ["Bombeiros", "Exercito", "Forca Aerea", "Policia", "Municipios"]
    ent = generate_entities(ent, 100)
    aux = []
    lst = []

    for i in range(len(ent)):
        lst += ["insert into entidade_meio values(\'" + ent[i] + "\');\n"]
    lst += ["\n"]
    
    file.writelines(lst)

    combate = generate_meios(ent, 100, "Combate", 0)
    socorro = generate_meios(ent, 100, "Socorro", 100)
    apoio = generate_meios(ent, 100, "Apoio", 200)
    
    meios = combate + socorro + apoio
    for i in range(len(meios)):
        aux += ["insert into meio values(" + str(meios[i][0]) + ", \'" + meios[i][1] + "\', \'" + meios[i][2] + "\');\n"]
    
    aux += ["\n"]

    for i in range(len(combate)):
        aux += ["insert into meio_combate values(" + str(combate[i][0]) + ",\'" + combate[i][2] + "\');\n"]
    
    aux += ["\n"]

    for i in range(len(apoio)):
        aux += ["insert into meio_apoio values(" + str(apoio[i][0]) + ",\'" + apoio[i][2] + "\');\n"]
    
    aux += ["\n"]

    for i in range(len(socorro)):
        aux += ["insert into meio_socorro values(" + str(socorro[i][0]) + ",\'" + socorro[i][2] + "\');\n"]
    
    aux += ["\n"]

    file.writelines(aux)

    coordenador = generate_id(100)

    aux = []
    for i in coordenador:
        aux += ["insert into coordenador values(" + str(i) + ");\n"]
    aux += ["\n"]

    file.writelines(aux)

    processos = generate_id(100)

    aux = []
    # inserir processos socorro
    for i in range(len(processos)):
        aux += ["insert into processo_socorro values(" + str(processos[i]) + ");\n"]
    aux += ["\n"]
    file.writelines(aux)

    aux = []
    for i in locais:
        aux += ["insert into localizacao values('" + i + "');\n"]
    aux += ["\n"]
    file.writelines(aux)

    prefix = [91,92,96]

    phoneN = generate_numbers(prefix,150)
    timestamp = generate_timestamp(150)
    names = generate_names(150)

    aux = []
    for i in range(len(processos)):
        morada = locais[randint(0, len(locais) - 1)]
        aux += ["insert into evento_emergencia values(" + phoneN[i] + ", " + timestamp[i] + ", '" + names[i] + "', '" +  morada + "', " + str(processos[i]) + ");\n"]

    for i in range(len(processos), len(names)):
        morada = locais[randint(0, len(locais) - 1)]
        processos += [processos[randint(0, len(processos) - 1)]]
        date = timestamp[processos[i]]
        datei = datetime(int(date[1:5], 10), int(date[6:8], 10), int(date[9:11], 10), int(date[12:14], 10), int(date[15:17], 10), int(date[18:20], 10))
        datei += timedelta(days=randint(0, 4), hours=randint(0, 19), minutes=randint(0, 59), seconds=randint(0, 59))
        aux += ["insert into evento_emergencia values(" + phoneN[i] + ", '" + str(datei) + "', '" + names[i] + "', '" +  morada + "', " + str(processos[i]) + ");\n"]


    aux += ["\n"]

    file.writelines(aux)

    lst = generate_acciona(meios, processos)
    
    aux = []
    for l in lst:
        aux += ["insert into acciona values(" + str(l[0]) + ", '" + l[1] + "', " + str(l[2]) + ");\n"]
    aux += ["\n"]

    file.writelines(aux)

    transport = generate_transports(socorro, lst, 10)
    aux = []
    for l in transport:
        aux += ["insert into transporta values(" + str(l[0]) + ", '" + l[1] + "', " + str(l[2]) + ", " + str(l[3]) + ");\n"]

    aux += ["\n"]

    file.writelines(aux)

    transport = generate_transports(apoio, lst, 72)
    aux = []
    for l in transport:
        aux += ["insert into alocado values(" + str(l[0]) + ", '" + l[1] + "', " + str(l[2]) + ", " + str(l[3]) + ");\n"]

    aux += ["\n"]

    file.writelines(aux)

    audita = generate_audita(lst, coordenador)

    aux = []
    for l in audita:
        aux += ["insert into audita values(" + str(l[0]) + ", " + str(l[1]) + ", '" + str(l[2]) + "', " + str(l[3]) + ", " + l[4] + ", " + l[5] + ", "+ l[6] + ", "+ l[7] + ");\n"]

    aux += ["\n"]
    file.writelines(aux)


    aux = []

    for i in range(n_camaras):
        aux += ["insert into camara values(" + str(i) + ");\n"]
    
    aux += ["\n"]

    file.writelines(aux)

    aux = []

    videos = generate_video()

    for i in range(len(videos)):
        aux += ["insert into video values(" + str(videos[i][0]) + ", '" + videos[i][1] + "', '" + videos[i][2] + "');\n"]
    aux+= ["\n"]

    file.writelines(aux)
    
    aux = []
    
    segmentos = generate_segmentos(videos)
    
    for i in range(len(segmentos)):
        aux += ["insert into segmento_video values(" + str(segmentos[i][0]) + " ," + str(segmentos[i][1]) + " ,'" + segmentos[i][2]  + "', '" + segmentos[i][4] + "');\n"]
    
    aux += ["\n"]

    file.writelines(aux)


    aux = []
    for i in range(n_camaras):
        aux += ["insert into vigia values('" + locais[i%len(locais)] + "', " + str(i) + ");\n"]
    aux += ["\n"]
    file.writelines(aux)
    
    solicita = generate_solicita(coordenador, videos)
    
    aux = []
    for l in solicita:
        aux += ["insert into solicita values(%s, '%s', %s, '%s', '%s');\n" % (l[0], l[1], l[2], l[3], l[4])]

    aux += ["\n"]
    
    file.writelines(aux)
    file.close()

"""
FAZER LOCALIZACAO
"""

if __name__ == '__main__':
    Main()


