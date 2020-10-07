/**************************************
---------------------------------------
--           db nueva cyc            --
---------------------------------------
**************************************/


/* tabla de contratos convenios y tratos directos */
CREATE TABLE cyc (
    /* llave */
    id NUMBER(10,0) NOT NULL,
    /* llaves foraneas */
    RUT_PROVEEDOR VARCHAR2(10) NOT NULL,
    nro_licitacion NUMBER(10,0) NOT NULL,
    id_boleta NUMBER(10,0) NOT NULL,
    id_detalle NUMBER(10,0) NOT NULL,
    id_admin NUMBER(10,0) NOT NULL,
    id_moneda NUMBER(10,0) NOT NULL,
    id_admin NUMBER(10,0) NOT NULL,
    /* datos cyc */
    tipo char(2) NOT NULL,
    precio FLOAT(24) NOT NULL,
    diferencial FLOAT(24) NOT NULL,
    estado_alerta NUMBER(1,0) NOT NULL,
    /* fechas */
    fecha_inicio DATE NOT NULL,
    fecha_termino DATE DEFAULT NULL,
    fecha_aprovacion DATE DEFAULT NULL,
    fecha_alerta_vencimiento DATE DEFAULT NULL,
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL,
    /*
    PRIMARY KEY (id)
    */
)
/* constraints */
/* PK */
ALTER TABLE CYC ADD CONSTRAINT PK_CYC_ID PRIMARY KEY (NRO_LICITACION);
/* FK */
-- ALTER TABLE CYC ADD CONSTRAINT FK_CYC_ID_PROV FOREIGN KEY (ID_PROVEEDOR)   REFERENCES PROVEEDORES (ID)
-- ALTER TABLE CYC ADD CONSTRAINT FK_CYC_NRO_LIC FOREIGN KEY (NRO_LICITACION) REFERENCES LICITACIONES (NRO_LICITACION)
/*ALTER TABLE CYC ADD CONSTRAINT FK_CYC_ID_BOL  FOREIGN KEY (ID_BOLETA)      REFERENCES LICITACIONES (NRO_LICITACION)*/
/*ALTER TABLE CYC ADD CONSTRAINT FK_CYC_ID_DET  FOREIGN KEY (ID_DETALLE)     REFERENCES DETALLE_CONTRATO (DETALLE_CONTRATO)*/
-- ALTER TABLE CYC ADD CONSTRAINT FK_CYC_ID_ADM  FOREIGN KEY (ID_ADMIN)       REFERENCES LICITACIONES (ID)
-- ALTER TABLE CYC ADD CONSTRAINT FK_CYC_ID_MON  FOREIGN KEY (ID_MONEDA)      REFERENCES LICITACIONES (NRO_LICITACION)

/*CONSTRAINT cargos_nombre_unique UNIQUE (nombre)*/

CREATE TABLE licitaciones (
    nro_licitacion VARCHAR2(200) NOT NULL,
    nro_documento NUMBER(10,0) DEFAULT NULL,
    detalle VARCHAR2(200) NOT NULL,
    presupuesto NUMBER(10,0),
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL,
    /*
    PRIMARY KEY (nro_licitacion)
    */
)
/* constraints */
ALTER TABLE LICITACIONES ADD CONSTRAINT PK_LIC_NRO_LIC PRIMARY KEY (NRO_LICITACION);


CREATE TABLE detalle_contrato (
/*    id NUMBER(10,0) NOT NULL,*/ 
    nro_licitacion VARCHAR2(200) NOT NULL,
    nro_documento NUMBER(10,0) DEFAULT NULL, 
    detalle VARCHAR2(200) DEFAULT NULL,
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL,
    /* constraints */
    /*PRIMARY KEY (nro_licitacion, nro_documento)*/
)
/* constraints */
ALTER TABLE DETALLE_CONTRATO ADD CONSTRAINT PK_DET_CON_NRO_LIC PRIMARY KEY (NRO_LICITACION);

CREATE TABLE doc_detalle (
    nro_documento NUMBER(10,0) NOT NULL,
    nombre VARCHAR2(200) NOT NULL,
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL,
    /* constraints */
    PRIMARY KEY (nro_documento)
)
/* constraints */
ALTER TABLE DOC_DETALLE ADD CONSTRAINT PK_DOC_DET_NRO_ORD_COM PRIMARY KEY (NRO_DOCUMENTO);



CREATE TABLE orden_compra(
    nro_orden_compra NUMBER(10,0) NOT NULL,
    fecha_envio DATE NOT NULL,
    total FLOAT DEFAULT NULL,
    ESTADO VARCHAR2(200) DEFAULT NULL,
    doc_ordencompra VARCHAR2(200) DEFAULT NULL,
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL,
    /* constraints */
    /*PRIMARY KEY (nro_orden_compra)*/
)
/* constraints */
ALTER TABLE ORDEN_COMPRA ADD CONSTRAINT PK_ORD_COM_NRO_OC PRIMARY KEY (NRO_ORDEN_COMPRA);



CREATE TABLE bitacora(
    id NUMBER(10,0) NOT NULL,
    glosa VARCHAR2(200) DEFAULT NULL,
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL,
    /* constraints */
    /*PRIMARY KEY (id)*/
)
/* constraints */
ALTER TABLE BITACORA ADD CONSTRAINT PK_BIT_ID PRIMARY KEY (ID);



CREATE TABLE proveedores(
    RUT varchar2(10) NOT NULL,
    NOMBRE VARCHAR2(200),
    TELEFONO NUMBER DEFAULT NULL,
    EMAIL VARCHAR2(200),
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL,
    /* constraints */
    /*PRIMARY KEY (id)*/
)
/* constraints */
ALTER TABLE PROVEEDORES ADD CONSTRAINT PK_PROV_ID PRIMARY KEY (RUT);

CREATE TABLE contrato_productos (
    id_contrato NUMBER(10,0) NOT NULL,
    codigo NUMBER(10,0) NOT NULL,
    /* constraints */
    /*PRIMARY KEY (id_contrato, codigo)*/
)
/* constraints */
ALTER TABLE CONTRATO_PRODUCTOS ADD CONSTRAINT PK_CON_PROD PRIMARY KEY (ID_CONTRATO, CODIGO);

CREATE TABLE productos(
    codigo NUMBER(10,0) NOT NULL,
    nombre VARCHAR2(200) NOT NULL,
    valor NUMBER NOT NULL,
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL,
    /* constraints */
    /*PRIMARY KEY (codigo)*/
)
/* constraints */
ALTER TABLE PRODUCTOS ADD CONSTRAINT PK_PROD_COD PRIMARY KEY (CODIGO);

CREATE TABLE contrato_prestaciones(
    id_contrato NUMBER(10,0) NOT NULL,
    codigo NUMBER(10,0) NOT NULL,
    /* constraints */
    /*PRIMARY KEY (id_contrato, codigo)*/
)
/* constraints */
ALTER TABLE CONTRATO_PRESTACIONES ADD CONSTRAINT PK_CON_PRES PRIMARY KEY (ID_CONTRATO, CODIGO);

CREATE TABLE prestaciones(
    codigo NUMBER(10,0) NOT NULL,
    nombre VARCHAR2(200) NOT NULL,
    valor NUMBER NOT NULL,
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL,
    /* constraints */
    /*PRIMARY KEY (codigo)*/
);
/* constraints */
ALTER TABLE PRESTACIONES ADD CONSTRAINT PK_PRES_COD PRIMARY KEY (CODIGO);






CREATE TABLE usuarios(
    mail VARCHAR2(200),
    nombre VARCHAR2(200),
    password VARCHAR2(200) NOT NULL,
    id_cargo NUMBER(10,0) NOT NULL,
    id_area VARCHAR2(200) NOT NULL,
    /* registro traking del registro */
    fecha_creacion DATE NOT NULL,
    fecha_actualizacion DATE DEFAULT NULL,
    fecha_eliminacion DATE DEFAULT NULL
);
/* constraints */
ALTER TABLE USUARIOS ADD CONSTRAINT PK_USR_MAIL PRIMARY KEY (MAIL);


CREATE TABLE USUARIOS_PERMISOS(
    MAIL_USUARIO  varchar2(200) NOT NULL,
    ID_PERMISO NUMBER(10,0) NOT NULL
)
/* contraints */
ALTER TABLE USUARIOS_PERMISOS ADD CONSTRAINT PK_USR_PERM_MAIL_ID PRIMARY KEY (MAIL_USUARIO, ID_PERMISO);


CREATE TABLE PERMISOS(
    ID_PERMISO NUMBER(10,0) NOT NULL,
    NOMBRE_PERMISO VARCHAR2(200) NOT NULL
)
/* constraints */
ALTER TABLE PERMISOS ADD CONSTRAINT PK_ID_PERMISOS PRIMARY KEY(ID_PERMISO);


CREATE TABLE cargos(
    id NUMBER(10,0),
    nombre VARCHAR2(200),
    ELIMINADO number(1,0)
);
/* constraints */
ALTER TABLE CARGOS ADD CONSTRAINT PK_CARGOS_ID PRIMARY KEY (ID);

CREATE TABLE areas(
    id NUMBER(10,0),
    area VARCHAR2(200)
);
/* constraints */
ALTER TABLE AREAS ADD CONSTRAINT PK_AREAS_ID PRIMARY KEY (ID);


CREATE TABLE MONEDA(
    CODIGO varchar2(5) NOT NULL,
    NOMBRE VARCHAR2(200) NOT NULL,
    EQUIVALENCIA FLOAT(24) NOT NULL

);
/* constraints */
ALTER TABLE MONEDA ADD CONSTRAINT PK_MONEDA_NOM PRIMARY KEY (CODIGO);






