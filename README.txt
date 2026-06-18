# PASTIMES CLOTHING STORE MANAGEMENT SYSTEM

## Project Overview

Pastimes is a web-based Clothing Store Management System developed using PHP, MySQL, HTML, and CSS. The system was created as part of a Portfolio of Evidence (POE) project and is designed to provide an online platform for buying, selling, and managing second-hand branded clothing.

The application allows customers to browse clothing, create accounts, purchase items, manage shopping carts, and place orders. Administrators can manage users, clothing items, seller requests, and communication within the system.

---

# Project Objectives

The main objectives of this project are:

* To create a user-friendly online clothing store.
* To allow customers to register and login securely.
* To enable administrators to manage users and clothing products.
* To implement a shopping cart and checkout system.
* To provide a platform where sellers can request to sell clothing items.
* To allow communication between administrators, buyers, and sellers.
* To demonstrate practical web development and database management skills.

---

# Technologies Used

## Front-End

* HTML5
* CSS3
* Responsive Design

## Back-End

* PHP

## Database

* MySQL

## Development Environment

* XAMPP
* phpMyAdmin

---

# System Features

## 1. User Registration

Customers can register by providing:

* Full Name
* Email Address
* Password

New accounts are created with a "Pending" status until approved by an administrator.

---

## 2. User Login

Registered users can log into the system using:

* Email Address
* Password

Verified users are granted access to the system dashboard.

---

## 3. User Management

Administrators can:

* Add users
* Edit users
* Delete users
* Verify user accounts

This ensures proper control over customer access to the system.

---

## 4. Clothing Management

Administrators can:

* Add clothing items
* Edit clothing details
* Delete clothing items
* View all available clothing

Each clothing item contains:

* Name
* Brand
* Description
* Size
* Price
* Image

---

## 5. Image Upload System

The system allows image uploads for clothing items.

Uploaded images are stored in the uploads folder and linked to the corresponding clothing item in the database.

---

## 6. Clothing Search Feature

Users can search clothing by:

* Clothing name
* Brand

This improves the shopping experience by helping customers find products quickly.

---

## 7. Shopping Cart

Customers can:

* Add items to cart
* Update quantities
* Remove items
* Continue shopping
* View total cost

The cart is linked to the user's session and stores selected products before checkout.

---

## 8. Checkout System

Customers can complete purchases by entering:

* Full Name
* Email Address
* Delivery Address

The system generates an order and stores order details in the database.

---

## 9. Order Confirmation

After checkout:

* Order details are stored
* Order items are recorded
* Shopping cart is cleared
* Customer receives an order confirmation page

---

## 10. Seller Request System

Individuals wishing to sell clothing can submit requests containing:

* Seller Name
* Seller Email
* Brand
* Description
* Size
* Price
* Product Image

---

## 11. Seller Approval System

Administrators can:

* Approve requests
* Reject requests

Approved requests are automatically added to the clothing inventory.

---

## 12. Communication System

Administrators can communicate with:

### Buyers

Using:

* Contact Buyer page

### Sellers

Using:

* Contact Seller page

Messages are stored in the database for record keeping.

---

# Database Structure

The system uses the following database tables:

## tblUser

Stores customer information.

Fields:

* userID
* fullName
* email
* password
* status

---

## tblAdmin

Stores administrator information.

Fields:

* adminID
* username
* password

---

## tblClothes

Stores clothing products.

Fields:

* clothID
* name
* brand
* description
* size
* price
* image

---

## tblCart

Stores shopping cart information.

Fields:

* cartID
* sessionID
* userID
* clothID
* quantity

---

## tblOrder

Stores customer orders.

Fields:

* orderID
* userID
* customerName
* customerEmail
* customerAddress
* totalAmount
* status

---

## tblOrderItem

Stores products contained within each order.

Fields:

* orderItemID
* orderID
* clothID
* quantity
* price

---

## tblSellerRequest

Stores seller requests awaiting approval.

Fields:

* requestID
* sellerName
* sellerEmail
* brand
* description
* size
* price
* image
* status

---

## tblMessages

Stores communication messages.

Fields:

* messageID
* senderName
* receiverName
* receiverType
* subject
* message

---

# Security Measures

The system includes:

* Password hashing
* Input validation
* Session management
* Prepared SQL statements
* User verification before access

---

# Installation Instructions

1. Install XAMPP.
2. Start Apache and MySQL.
3. Create a database named:

```sql
clothingstore
```

4. Import or run the SQL database script.
5. Copy the project folder into:

```text
htdocs/
```

6. Open the browser and navigate to:

```text
http://localhost/ClothingStore
```

7. Register or login to begin using the system.

---

# Future Improvements

Potential enhancements include:

* Online payment integration
* Customer order history
* Product ratings and reviews
* Email notifications
* Inventory management
* Advanced reporting dashboards

---

# Conclusion

Pastimes Clothing Store Management System successfully provides a complete online platform for managing second-hand clothing sales. The project demonstrates practical implementation of PHP, MySQL, HTML, and CSS while satisfying all major Portfolio of Evidence (POE) requirements. The system offers user management, product management, shopping functionality, seller management, communication features, and responsive design, making it a comprehensive clothing store solution.
