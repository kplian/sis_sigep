/***********************************I-DEP-JRR-SIGEP-1-01/11/2018****************************************/

ALTER TABLE ONLY sigep.ttype_sigep_service_request
    ADD CONSTRAINT fk_type_sigep_service_request__id_type_service_request
    FOREIGN KEY (id_type_service_request) REFERENCES sigep.ttype_service_request(id_type_service_request);

ALTER TABLE ONLY sigep.tparam
    ADD CONSTRAINT fk_tparam__id_type_sigep_service_request
    FOREIGN KEY (id_type_sigep_service_request) REFERENCES sigep.ttype_sigep_service_request(id_type_sigep_service_request);
    
ALTER TABLE ONLY sigep.tservice_request
    ADD CONSTRAINT fk_tservice_request__id_type_service_request
    FOREIGN KEY (id_type_service_request) REFERENCES sigep.ttype_service_request(id_type_service_request);
    
ALTER TABLE ONLY sigep.tsigep_service_request
    ADD CONSTRAINT fk_sigep_service_re,muhtyt5 6gnyutcvbrgd6uj   quest__id_service_request
    FOREIGN KEY (id_type_service_request) REFERENCES sigep.ttype_service_request(id_type_service_request);
    
ALTER TABLE ONLY sigep.tsigep_service_request
    ADD CONSTRAINT fk_tsigep_service_request__id_type_sigep_service_request
    FOREIGN KEY (id_type_sigep_service_request) REFERENCES sigep.ttype_sigep_service_request(id_type_sigep_service_request);

ALTER TABLE ONLY sigep.trequest_param
    ADD CONSTRAINT fk_trequest_param__id_sigep_service_request
    FOREIGN KEY (id_sigep_service_request) REFERENCES sigep.tsigep_service_request(id_sigep_service_request);
    
/***********************************F-DEP-JRR-SIGEP-1-01/11/2018****************************************/