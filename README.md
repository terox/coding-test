# Discounts Microservice
> A module that applies discounts to orders ([based on discounts exercise](./1-discounts.md))

I made some assumptions in this exercise:
- I assumed that Customers, Products and Orders are isolated microservices... So, when I need information from one
of these services I need to query them from a bus (cache, for example) or from an API endpoints.
- Discount microservice is responsable for any kind of calculations to resolve available  discounts from an order. So, 
it can't apply directly the discounts to orders. It emits an event(s) to a bus, and the last check must be done by the 
order microservice or any other service listening the events.
- The main use case is located in ```src/Core/Discount/Resolver/*```
- The use case emit an event to apply the discount if order has an ID, if not I can assume that is only a query.
- I don't control if there are multiple discounts with the same configuration repeated in this exercise.

## How to add new discounts algorithms
Before add a new discount type, you should think to arrive to a generalization to avoid repeat discount type. Remember,
that the different types of discounts can be configured via parameters. For example, same type of discount but for different
categories and final discounts.

1. Go to the module ```src/Core/Discount/Domain/Type/*```
2. Create a new class that extend the DiscountBase or implement the interface Discount (it's preferable the first option)
3. Add your validations to check the configuration parameters are valid. Remember that it could arrive from a fronted and must be validated.
4. Add your business logic into the apply method.
5. Create a unit test.

## How to test the service
### Launching Docker environment
```bash
docker compose up
```
If you need access to project terminal, you can access to container:
```bash
sh bin/container
```
### Running tests
```bash
sh bin/tests
```

### Test API endpoint
We can introduce an input to the microservice to see what is the result calling a little endpoint. First init the 
test server:
```bash
sh bin/server
```

Then send a POST to http://127.0.0.1:8080/api.php with the next bodies:

#### Order 1
````json
{
  "id": "1",
  "customer-id": "1",
  "items": [
    {
      "product-id": "B102",
      "quantity": "10",
      "unit-price": "4.99",
      "total": "49.90"
    }
  ],
  "total": "49.90"
}
````

#### Order 2
```json
{
  "id": "2",
  "customer-id": "2",
  "items": [
    {
      "product-id": "B102",
      "quantity": "5",
      "unit-price": "4.99",
      "total": "24.95"
    }
  ],
  "total": "24.95"
}
```

#### Order 3
```json
{
  "id": "3",
  "customer-id": "3",
  "items": [
    {
      "product-id": "A101",
      "quantity": "2",
      "unit-price": "9.75",
      "total": "19.50"
    },
    {
      "product-id": "A102",
      "quantity": "1",
      "unit-price": "49.50",
      "total": "49.50"
    }
  ],
  "total": "69.00"
}
```

Then in the response, if there are some valid discount, you will see some similar to:

```json
[
    {
        "discount_id": 1,
        "amount": 2.495
    }
]
```

That indicates the discount applied and the total amount.
