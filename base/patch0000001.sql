/***********************************I-SCP-JRR-SIGEP-1-01/11/2018****************************************/
CREATE TABLE sigep.ttype_sigep_service_request (
    id_type_sigep_service_request serial NOT NULL,
    id_type_service_request INTEGER NOT NULL,
    sigep_service_name VARCHAR(200),
    sigep_url VARCHAR(200) NOT NULL,
    method_type VARCHAR(8) NOT NULL,
    time_to_refresh INTEGER,
    exec_order INTEGER NOT NULL,
    queue_url VARCHAR(200),
    queue_method VARCHAR(8),
    revert_url VARCHAR(200),
    revert_method VARCHAR(8),   
    user_param VARCHAR(100),
    json_main_container VARCHAR(200) ,
    sigep_main_container VARCHAR(200) 
) INHERITS (pxp.tbase);

ALTER TABLE ONLY sigep.ttype_sigep_service_request
    ADD CONSTRAINT pk_type_sigep_service_request
    PRIMARY KEY (id_type_sigep_service_request);
    
CREATE TABLE sigep.ttype_service_request (
    id_type_service_request serial NOT NULL,    
    service_code VARCHAR(50) NOT NULL,
    description TEXT NOT NULL
) INHERITS (pxp.tbase);

ALTER TABLE ONLY sigep.ttype_service_request
    ADD CONSTRAINT pk_type_service_request
    PRIMARY KEY (id_type_service_request);
    
CREATE TABLE sigep.tparam (
	id_param SERIAL NOT NULL,
    id_type_sigep_service_request INTEGER NOT NULL,    
    sigep_name VARCHAR(200),
    erp_json_container VARCHAR(200),
    erp_name VARCHAR(200),
    ctype VARCHAR(50) NOT NULL,
    input_output VARCHAR(10) NOT NULL,
    def_value VARCHAR(500), 
) INHERITS (pxp.tbase);

ALTER TABLE ONLY sigep.tparam
    ADD CONSTRAINT pk_tparam
    PRIMARY KEY (id_param);
    

CREATE TABLE sigep.tservice_request (
	id_service_request SERIAL NOT NULL,
    id_type_service_request INTEGER NOT NULL,    
    sys_origin VARCHAR(100) NOT NULL,
    ip_origin VARCHAR(50) NOT NULL,
    status VARCHAR(100) NOT NULL,
    date_finished TIMESTAMP,
    last_message TEXT, 
    last_message_revert TEXT
) INHERITS (pxp.tbase);

ALTER TABLE ONLY sigep.tservice_request
    ADD CONSTRAINT pk_tservice_request
    PRIMARY KEY (id_service_request);
    
CREATE TABLE sigep.tsigep_service_request (
	id_sigep_service_request SERIAL NOT NULL,
    id_service_request INTEGER NOT NULL,
    id_type_sigep_service_request INTEGER NOT NULL,    
    date_request_sent TIMESTAMP,
    date_queue_sent TIMESTAMP,
    status VARCHAR(100) NOT NULL,    
    last_message TEXT,
    last_message_revert TEXT,
    exec_order INTEGER NOT NULL,
    user_name VARCHAR(100),
    queue_id VARCHAR(100),
    queue_revert_id VARCHAR(100)
     
) INHERITS (pxp.tbase);

ALTER TABLE ONLY sigep.tsigep_service_request
    ADD CONSTRAINT pk_tsigep_service_request
    PRIMARY KEY (id_sigep_service_request);
    
CREATE TABLE sigep.trequest_param (
	id_request_param SERIAL NOT NULL,
    id_sigep_service_request INTEGER NOT NULL,    
    name VARCHAR(200) NOT NULL,
    value TEXT NOT NULL,
    ctype VARCHAR(50) NOT NULL,
    input_output VARCHAR(10) NOT NULL
) INHERITS (pxp.tbase);

ALTER TABLE ONLY sigep.trequest_param
    ADD CONSTRAINT pk_trequest_param
    PRIMARY KEY (id_request_param);
    
    
/***********************************F-SCP-JRR-SIGEP-1-01/11/2018****************************************/