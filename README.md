## Project Details
This product is extended from my e-commerce template
* Stripe integration (Not paypal)
* Create products (need Category & Brand)
* Products has relation with category & brand
* Upload images for product details body using CKEditor
* Category for products (Relation with products)
* Brands for products (Relation with products)
* Manually upload images for product details body
* Created Order DB to store product orders
* Complete Order routes, show cancel / complete page
* Tags for the products to quick search related products
* Tags and products has a relation and separate system
* Tag for product should be unique (protect tags from duplication)
* Pending email (url - string)
* Processed email (orderID - string)
* Canceled email (orderID - string)
* Refunded email (orderID - string)
* Transit email (orderID, transit, logistics - string)
* Completed email (orderID - string)
* Change shipping status of order
* In Transit will require TrackingID & Logistics name
* Option to Send email or not when status change
* Gallery to upload pictures about the product
* Gallery images will showup in the single product page
* Home, product, cart & products pages are build with Livewire