CREATE DATABASE db_saa;

use db_saa;

CREATE TABLE usuario
(

    id        INT AUTO_INCREMENT NOT NULL,
    nome      VARCHAR(100)       NOT NULL,
    img       VARCHAR(255) DEFAULT NULL,
    matricula VARCHAR(25) UNIQUE NOT NULL,
    email     VARCHAR(100) DEFAULT NULL,
    senha     VARCHAR(255)       NOT NULL,
    categoria VARCHAR(25)        NOT NULL,
    permissao int                NOT NULL,
    PRIMARY KEY (id)

) ENGINE = InnoDB;

CREATE TABLE locais
(
    id     INT AUTO_INCREMENT NOT NULL,
    rua    VARCHAR(255)       NOT NULL,
    numero VARCHAR(10)        NOT NULL,
    Bairro VARCHAR(100)       NOT NULL,
    nome   VARCHAR(255)       NOT NULL,
    img    VARCHAR(255) DEFAULT NULL,


    PRIMARY KEY (id)

) ENGINE = InnoDB;


CREATE TABLE setor
(
    id         INT AUTO_INCREMENT NOT NULL,
    local_id   INT                NOT NULL,
    numero     VARCHAR(10)        NOT NULL,
    nome       VARCHAR(100)       NOT NULL,
    img        VARCHAR(255) DEFAULT NULL,


    PRIMARY KEY (id),
    FOREIGN KEY (local_id) REFERENCES locais (id)

) ENGINE = InnoDB;


CREATE TABLE patrimonio
(
    id            INT AUTO_INCREMENT NOT NULL,
    tombo         VARCHAR(50) UNIQUE NOT NULL,
    especificacao TEXT               NOT NULL,
    nome          VARCHAR(100)       NOT NULL,
    status        VARCHAR(30)  DEFAULT NULL,
    permissao     INT                NOT NULL,
    setor_id      INT                NOT NULL,
    img           VARCHAR(255) DEFAULT NULL,


    PRIMARY KEY (id),
    FOREIGN KEY (setor_id) REFERENCES setor (id)

) ENGINE = InnoDB;


CREATE TABLE emprestimos
(
    id                   INT AUTO_INCREMENT NOT NULL,
    user_realizou        INT                NOT NULL,
    user_solicitou       INT                NOT NULL,
    user_recebeu         INT  DEFAULT NULL,
    user_entregou        INT  DEFAULT NULL,
    patrimonio_id        INT                NOT NULL,
    status               VARCHAR(30)        NOT NULL,
    data_emprestimo      DATE               NOT NULL,
    data_prazo_devolucao DATE               NOT NULL,
    data_devolucao       DATE DEFAULT NULL,
    FOREIGN KEY (user_entregou) REFERENCES usuario (id),
    FOREIGN KEY (user_recebeu) REFERENCES usuario (id),
    FOREIGN KEY (user_realizou) REFERENCES usuario (id),
    FOREIGN KEY (user_solicitou) REFERENCES usuario (id),
    FOREIGN KEY (patrimonio_id) REFERENCES patrimonio (id),
    PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE formulario
(
    id                INT AUTO_INCREMENT NOT NULL,
    usuario_id        INT                NOT NULL,
    data_requerimento DATE               NOT NULL,
    tipo_requisicao   VARCHAR(100)       NOT NULL,
    tipo_formulario   VARCHAR(100)       NOT NULL,

    PRIMARY KEY (id)
    /* FOREIGN KEY (usuario_id) REFERENCES usuario(id)*/

) ENGINE = InnoDB;

CREATE TABLE achados_e_perdidos
(

    id                        INT AUTO_INCREMENT NOT NULL,
    nome                      VARCHAR(100)       NOT NULL,
    descricao                 TEXT               NOT NULL,
    img                       VARCHAR(255) DEFAULT NULL,
    data_achado               DATE               NOT NULL,
    id_setor                  INT                NOT NULL,
    status                    INT                NOT NULL,
    nome_pessoa_entregou      VARCHAR(255) DEFAULT NULL,
    documento_pessoa_entregou VARCHAR(255) DEFAULT NULL,
    telefone                  VARCHAR(255) DEFAULT NULL,
    tipo_documento            VARCHAR(255) DEFAULT NULL,

    FOREIGN KEY (id_setor) REFERENCES setor (id),
    PRIMARY KEY (id)

) ENGINE = InnoDB;


CREATE TABLE user_setor(

    user_id  INT NOT NULL,
    setor_id INT NOT NULL,
    FOREIGN KEY (setor_id) REFERENCES setor (id),
    FOREIGN KEY (user_id) REFERENCES usuario (id),
    PRIMARY KEY (user_id, setor_id)
);

insert into usuario(nome, matricula, email, senha, permissao, categoria)
    VALUE ('admin', '1', 'admin@admin', '14d777febb71c53630e9e843bedbd4d8', '1', 'SERVIDOR'),
    ('operacional', '2', 'operacional@operacional', '14d777febb71c53630e9e843bedbd4d8', '2', 'SERVIDOR');
    

