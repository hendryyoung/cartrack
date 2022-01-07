## 1. Schema and table need to be created.

```
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
```

To be able to connect to your specific PostgreSQL databaase, please change the credentials in file [dbstr.php](https://github.com/hendryyoung/cartrack/blob/master/dbstr.php)

## 2. API Usage

* Bearer token is need from md5 of **hendry_cartrack**
