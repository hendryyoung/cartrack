## REST API

## Get list of cars

List all cars or search by keyword or filter by minimum price.

| Query Parameters | Description |
| ------------- | ------------- |
| keyword  | **Optional**.\search by brand or model |
| price  | **Optional**.\search by minimum price  |

### Request

`GET /list`

    curl -i -H 'Accept: application/json' /list

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
