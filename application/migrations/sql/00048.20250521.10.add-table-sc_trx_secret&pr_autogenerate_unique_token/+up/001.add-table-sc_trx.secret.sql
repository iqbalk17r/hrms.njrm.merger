CREATE TABLE IF NOT EXISTS sc_trx.secret(
    employee_id varchar,
    secret_id varchar,
    url varchar,
    description TEXT,
    status varchar,
    actived BOOLEAN DEFAULT TRUE,
    input_by VARCHAR,
    input_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_by VARCHAR,
    update_date TIMESTAMP,
    approve_by VARCHAR,
    approve_date TIMESTAMP,
    cancel_by VARCHAR,
    cancel_date TIMESTAMP,
    deleted BOOLEAN DEFAULT FALSE,
    delete_by VARCHAR,
    delete_date TIMESTAMP,
    properties JSONB DEFAULT '{}'
);


