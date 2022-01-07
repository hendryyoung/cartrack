<pre>
    Please execute below SQL to create the Schema and Table:
    
    CREATE SCHEMA IF NOT EXISTS hendry_cartrack;

    CREATE TABLE IF NOT EXISTS hendry_cartrack.car
    (
        id serial PRIMARY KEY,
        brand VARCHAR(50), 
        model VARCHAR(50),
        price NUMERIC(10,2),
        created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		UNIQUE(brand, model)
    );
</pre>