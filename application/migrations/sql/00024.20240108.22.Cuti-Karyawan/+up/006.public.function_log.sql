CREATE TABLE IF NOT EXISTS public.function_log(
     log_id SERIAL PRIMARY KEY,
     branch varchar DEFAULT 'SBYNSA',
     function_name VARCHAR NOT NULL,
     actived BOOLEAN DEFAULT NULL,
     actived_by VARCHAR,
     actived_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);