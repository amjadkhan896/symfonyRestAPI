```
 1) GET http://localhost:8000/api/products
 2) POST http://localhost:8000/api/products
    params

      {
        "name":"Iphone",
        "product_discount_id":1,
        "description":"Test Desc",
        "price":2000,
        "quantity":200
      }
  3) PATCH http://localhost:8000/api/products/6
  4) DELETE http://localhost:8000/api/products/3
  5) GET http://127.0.0.1:8000/api/product/list-discount
  6) POST http://127.0.0.1:8000/api/product/post-discount

    params:

      {
      	"discount_name":"10% off",
      	"discount_value":"0.20"
      }
   7) PATCH http://127.0.0.1:8000/api/product/update-discount/1

        params

        {
        	"product_id":2,
        	"discount_name":"10% off",
        	"discount_value":0.40

        }

   8) DELETE http://127.0.0.1:8000/api/product/delete-discount/10

   9) GET http://127.0.0.1:8000/api/list-groups
   10) POST http://127.0.0.1:8000/api/post-group

            params

        {
        	"name":"Test Group",
        	"description": "This is test description",
        	"price":30.00
        }
   11) GET http://127.0.0.1:8000/api/group/2

   12)  GET http://127.0.0.1:8000/api/list-groups
   13) PATCH http://127.0.0.1:8000/api/update-group/1

            params

            {
                "name": "Test Groupssssssssssss",
                "description": "This is test descriptionssssssssssss",
                "price": "30"
            }
   14) DELETE http://127.0.0.1:8000/api/delete-group/1

   15) GET http://127.0.0.1:8000/api/list-group-products
   16) POST http://127.0.0.1:8000/api/post-group-product
        params

        http://127.0.0.1:8000/api/post-group-product

   17) GET http://127.0.0.1:8000/api/get-group-product/3
   18) PUT http://127.0.0.1:8000/api/update-group-product/3
        params

        {

        	"product_id":[5,6,7]
        }

   19) DELETE http://127.0.0.1:8000/api/delete-group-product/3

   20) GET http://127.0.0.1:8000/api/list-orders
   21) POST http://127.0.0.1:8000/api/post-order

        params
        {
          "group_id":3,
          "quantity":2,
          "status":0
        }
   22) PATCH http://127.0.0.1:8000/api/update-order/9
     params

      {
        "quantity":3,
        "group_id":3
      }

   23) DELETE http://127.0.0.1:8000/api/delete-order/9


```