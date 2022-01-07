## REST API

API request need to include the Bearer token.

`-H "Authorization: Bearer 7fa41899bffc8dc6c9ee8447a0df6fda"`

## 1. Get list of cars

METHOD:

List all cars or search by keyword or filter by minimum price.

| Query Parameters | Description |
| ------------- | ------------- |
| keyword  | **Optional**, case-sensitive.<br/>search by brand or model |
| price  | **Optional**.<br/>search by minimum price  |

### Request

`GET /list`

    curl -i /list
    curl -i /list?keyword=Bentley
    curl -i /list?price=100000

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

Get the details of a car.

| Query Parameters | Description |
| ------------- | ------------- |
| id  | car id |

### Request

`GET /get`

    curl -i -H 'Accept: application/json' /get/3

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
