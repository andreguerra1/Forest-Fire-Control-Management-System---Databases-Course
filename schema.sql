-- REMOVER ANTES DE ENTREGAR
drop table vigia cascade;
drop table segmento_video cascade;
drop table video cascade;
drop table camara cascade;
drop table processo_socorro cascade;
drop table localizacao cascade;
drop table meio cascade;
drop table meio_combate cascade;
drop table meio_socorro cascade;
drop table meio_apoio cascade;
drop table entidade_meio;
drop table acciona cascade;
drop table alocado cascade;
drop table transporta cascade;
drop table evento_emergencia cascade;
drop table coordenador cascade;
drop table audita cascade;
drop table solicita cascade;




----------------------------------------
-- Table Creation
----------------------------------------

-- Named constraints are global to the database.
-- Therefore the following use the following naming rules
--   1. pk_table for names of primary key constraints
--   2. fk_table_another for names of foreign key constraints

create table camara(
    n_camara 	integer not null unique,
    constraint pk_Camara primary key(n_camara)
);

create table video(
    n_camara 	        integer not null,
    data_hora_inicio 	timestamp not null,
    data_hora_fim 		 timestamp not null,
    check (data_hora_fim > data_hora_inicio),
    constraint pk_video primary key(n_camara, data_hora_inicio),
    constraint fk_video_n_camara foreign key(n_camara) references camara
);

create table segmento_video(
    n_segmento          integer   not null,
    n_camara 	        integer	not null,
    data_hora_inicio 	timestamp       not null,
    duracao             interval hour to second not null,
    constraint pk_segmento_video primary key(n_segmento, n_camara, data_hora_inicio),
    constraint fk_segmento_video_video foreign key(n_camara, data_hora_inicio) references video
    
);

create table localizacao(
    morada_local         varchar(255) not null unique,
    constraint pk_localizacao primary key(morada_local)
);

create table vigia(
    morada_local         varchar(255) not null ,
    n_camara 	         integer	  not null,
    constraint pk_vigia primary key(morada_local, n_camara),
    constraint fk_vigia_n_camara foreign key(n_camara) references camara,
    constraint fk_vigia_morada_local foreign key(morada_local) references localizacao
);

create table processo_socorro(
    n_proc_socorro          integer not null unique,
    constraint pk_process_socorro primary key(n_proc_socorro)
);

create table evento_emergencia(
    n_telefone              varchar(15) not null,
    inst_chamada            timestamp not null,
    nome_pessoa             varchar(80) not null,
    morada_local            varchar(80) not null ,
    n_proc_socorro          integer not null,
    constraint pk_evento primary key(n_telefone, inst_chamada),
    constraint fk_evento_morada_local foreign key(morada_local) references localizacao,
    constraint fk_evento_n_proc_socorro foreign key(n_proc_socorro) references processo_socorro
);


create table entidade_meio(
    nome_entidade   varchar(200) not null unique,
    constraint pk_entidade_meio primary key (nome_entidade)
);

create table meio(
    n_meio      integer not null,
    nome_meio   varchar(80) not null,
    nome_entidade   varchar(200) not null,
    constraint pk_meio primary key(n_meio, nome_entidade),
    constraint fk_meio_entidade foreign key (nome_entidade) references entidade_meio
);

create table meio_combate(
    n_meio      integer not null,
    nome_entidade   varchar(200) not null,
    constraint pk_meio_combate primary key(n_meio, nome_entidade),
    constraint fk_meio_combate_entidade foreign key (n_meio, nome_entidade) references meio
);

create table meio_apoio(
    n_meio      integer not null,
    nome_entidade   varchar(200) not null,
    constraint pk_meio_apoio primary key(n_meio, nome_entidade),
    constraint fk_meio_apoio_entidade foreign key (n_meio, nome_entidade) references meio
);

create table meio_socorro(
    n_meio      integer not null,
    nome_entidade   varchar(200) not null,
    constraint pk_meio_socorro primary key(n_meio, nome_entidade),
    constraint fk_meio_socorro_entidade foreign key (n_meio, nome_entidade) references meio
);

create table transporta(
    n_meio      integer not null,
    nome_entidade   varchar(200) not null,
    n_proc_socorro  integer not null,
    n_vitimas       integer not null,
    constraint pk_transporta primary key(n_meio, nome_entidade, n_proc_socorro),
    constraint fk_transporta_proc foreign key(n_proc_socorro) references processo_socorro,
    constraint fk_transporta_entidade foreign key (n_meio, nome_entidade) references meio_socorro
);

create table alocado(
    n_meio      integer not null,
    nome_entidade   varchar(200) not null,
    n_proc_socorro  integer not null,
    n_horas         integer not null,
    constraint pk_alocado primary key(n_meio, nome_entidade, n_proc_socorro),
    constraint fk_alocado_proc foreign key(n_proc_socorro) references processo_socorro,
    constraint fk_alocado_entidade foreign key (n_meio, nome_entidade) references meio_apoio
);


create table acciona(
    n_meio      integer not null,
    nome_entidade   varchar(200) not null,
    n_proc_socorro  integer not null,
    constraint pk_acciona primary key(n_meio, nome_entidade, n_proc_socorro),
    constraint fk_acciona_proc foreign key(n_proc_socorro) references processo_socorro,
    constraint fk_acciona_entidade foreign key (n_meio, nome_entidade) references meio
);


create table coordenador(
    id      integer not null unique,
    constraint pk_coordenador primary key (id)
);

create table audita (
    id_coord      integer not null,
    n_meio        integer not null,
    nome_entidade varchar(200) not null,
    n_proc_socorro  integer not null,
    data_hora_inicio timestamp not null,
    data_hora_fim   timestamp not null,
    data_auditoria  date not null,
    texto           text not null,
    check(data_hora_inicio < data_hora_fim),
    check(data_auditoria <= current_date),
    constraint pk_audita primary key (id_coord, n_meio, nome_entidade, n_proc_socorro),
    constraint fk_audita_id foreign key (id_coord) references coordenador(id),
    constraint fk_audita_acciona foreign key (n_meio, nome_entidade, n_proc_socorro) references acciona
);

create table solicita(
    id_coord      integer not null,
    data_hora_inicio_video timestamp not null,
    n_camara        integer not null,
    data_hora_inicio timestamp not null,
    data_hora_fim   timestamp not null,
    check(data_hora_inicio < data_hora_fim),
    constraint pk_solicita primary key (id_coord, data_hora_inicio_video, n_camara),
    constraint fk_solicita_id foreign key (id_coord) references coordenador(id),
    constraint fk_solicita_video foreign key (data_hora_inicio_video, n_camara) references video(data_hora_inicio, n_camara)
);

CREATE OR REPLACE FUNCTION delete_proc()
RETURNS TRIGGER AS $BODY$
BEGIN
    DELETE FROM evento_emergencia WHERE evento_emergencia.n_proc_socorro = OLD.n_proc_socorro;
    RETURN OLD;
END;
$BODY$ language plpgsql;


CREATE TRIGGER delete_proc_trigger
    BEFORE DELETE 
    ON processo_socorro
    FOR EACH ROW
    EXECUTE PROCEDURE delete_proc();


CREATE OR REPLACE FUNCTION delete_m()
RETURNS TRIGGER AS $BODY$
BEGIN
    DELETE FROM meio_apoio WHERE meio_apoio.n_meio = OLD.n_meio AND meio_apoio.nome_entidade=OLD.nome_entidade;
    DELETE FROM meio_combate WHERE meio_combate.n_meio = OLD.n_meio AND meio_combate.nome_entidade=OLD.nome_entidade;
    DELETE FROM meio_socorro WHERE meio_socorro.n_meio = OLD.n_meio AND meio_socorro.nome_entidade=OLD.nome_entidade;
    RETURN OLD;
END;
$BODY$ language plpgsql;

CREATE TRIGGER delete_meio
    BEFORE DELETE 
    ON meio
    FOR EACH ROW
    EXECUTE PROCEDURE delete_m();


CREATE OR REPLACE FUNCTION delete_e()
RETURNS TRIGGER AS $BODY$
BEGIN
    DELETE FROM meio WHERE meio.nome_entidade = OLD.nome_entidade;
    RETURN OLD;
END;
$BODY$ language plpgsql;

CREATE TRIGGER delete_entidade
    BEFORE DELETE 
    ON entidade_meio
    FOR EACH ROW
    EXECUTE PROCEDURE delete_e();


CREATE OR REPLACE FUNCTION insert_evento()
RETURNS TRIGGER AS $BODY$
BEGIN
    IF NOT EXISTS (SELECT * FROM processo_socorro WHERE processo_socorro.n_proc_socorro=NEW.n_proc_socorro)
    THEN 
        INSERT INTO processo_socorro VALUES(NEW.n_proc_socorro);
    END IF;

    IF NOT EXISTS (SELECT * FROM localizacao WHERE localizacao.morada_local=NEW.morada_local)
    THEN 
        INSERT INTO localizacao VALUES(NEW.morada_local);
    END IF;
    RETURN NEW;
END;
$BODY$ language plpgsql;


CREATE TRIGGER insert_evento_emergencia
BEFORE INSERT
ON evento_emergencia
FOR EACH ROW
EXECUTE PROCEDURE insert_evento();