# Elementor HomeWork 

# WordPress Development Test
* Do not use plugins unless you MUST.
* All code should be written in the theme.
### Part 1 - Git
* Create a git repository at GitHub.
* Each of the following parts below should be a commit in git.
### Part 2 - WP preparation
* Create a child theme for “twenty-twenty” and name “twenty-twenty-child”
### Part 3 - Users
* Create a new user:
    *  Role: editor
    *  Username: wp-test
    *  Password: 123456789
    *  Email: wptest@elementor.com
* Disable wp admin bar for this user, using code
### Part 4 - Post Types
* Create a custom post type called Products
* A product should have these data items:
    *  Main image
    *  Title
    *  Description
    *  Price
    *  Sale price
    *  Is on sale?
    *  YouTube video
    *  Category (custom taxonomy)
* Create 6 products:
    *  Use dummy text and images
    *  Make 3 products “on sale”
    *  Put at least 2 products in each category (dummy name)
* Display these Products on the homepage as a grid list, and make sure that it
looks good in every screen size. Each item should display the product's main
image and a title. The item should link to the product page. If the product is on
sale, it should have a badge stating that.
* The product page should display the product data (title, description, price, sale
price if on sale and image gallery)
* The page should also display the YouTube video as part of the description.
* Under the product display related products from the same category
### Part 5 - Shortcode
* Create a product shortcode that display a product in a box:
    *  Shortcode attributes: product id, bg color
    *  Shortcode output:
        * Product image
        * Product title
        * Product price
        * Box background color

##### Example:
```sh
[ product id="27" color="red" ]
```
### Part 6 - Filters & Hooks
* Add a custom filter to the above shortcode that allows to override the returned
value of the shortcode.
* Add a custom address bar color for mobile browsers.

##### Example: 
code use filte an example
```sh
function example_shortcode_filter(string $input): string	{
    return '<div style="background: red;">'.$input.'</div>';	
}
add_filter('custom_shortcode_product', 'example_shortcode_filter');
```
### Part 8 - json-api
* Create a custom json-api endpoint that receives a category name/id and returns
a list of products in a json format (title, description, image, price, is on sale, sale
price)

##### Example:

.1) by slug:
```sh
https://yechiel-test.elementor.cloud/wp-json/products/v1/category/3.
```
.2) by id:
```sh
https://yechiel-test.elementor.cloud//wp-json/products/v1/category/eating.
```


### Part 9 - If you got this far, You're done! Simply submit your GitHub repo. 

