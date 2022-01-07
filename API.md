## REST API

API request need to include the Bearer token.

`-H "Authorization: Bearer 7fa41899bffc8dc6c9ee8447a0df6fda"`

## 1. Get list of cars

METHOD: **GET**

List all cars or search by keyword or filter by minimum price.

| Query Parameters | Description |
| ------------- | ------------- |
| keyword  | **Optional**, case-sensitive.<br/>search by brand or model |
| price  | **Optional**.<br/>search by minimum price  |

### Request

`GET /list`

    curl /list -X GET
    curl /list?keyword=Bentley -X GET
    curl /list?price=100000 -X GET

### Response

```
{
    "code": 0,
    "message": [],
    "cars": [
        {
            "id": 1,
            "brand": "Infiniti",
            "model": "Q50",
            "price": "86888.00"
        },
        {
            "id": 2,
            "brand": "Hyundai",
            "model": "Avante",
            "price": "98588.00"
        },
        {
            "id": 3,
            "brand": "Bentley",
            "model": "Continental GT",
            "price": "325888.00"
        }
    ]
}
```

## 2. Get a car

METHOD: **GET**

Get the details of a car.

| Query Parameters | Description |
| ------------- | ------------- |
| id  | car id |

### Request

`GET /get/:car_id`

    curl /get/3  -X GET

### Response

```
{
    "code": 0,
    "message": [],
    "car": {
        "id": 3,
        "brand": "Bentley",
        "model": "Continental GT",
        "price": "325888.00"
    }
}
```

## 3. Upsert

METHOD: **POST**

Insert or update a car.

| Query Parameters | Description |
| ------------- | ------------- |
| id  | car id |
| brand  | brand name |
| model  | model name |
| price  | price |

### Request

`POST /upsert`

    curl /upsert -X POST -d 'id=3&brand=Bentley&model=Continental%20GT&price=325888'

### Response

```
{
    "code": 0,
    "message": [],
    "car": {
        "id": 3,
        "brand": "Bentley",
        "model": "Continental GT",
        "price": "325888"
    }
}
```

## 3. Delete

METHOD: **DELETE**

Delete a car.

| Query Parameters | Description |
| ------------- | ------------- |
| id  | car id |

### Request

`DELETE /delete/:car_id`

    curl /delete/3 -X POST

### Response

```
{
    "code": 0,
    "message": []
}
```
