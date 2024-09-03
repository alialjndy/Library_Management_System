# Library Management System

**This is a web-based Library Management System built using Laravel, allowing users to borrow books, rate them. The system provides features for both regular users and administrators. Admins have full control over user management, book management, and more.**

## Features

### 1. Authentication

-   User Registration
-   User Login and Logout
-   JWT (JSON Web Token) based authentication for secure access
-   Roles and Permissions (Admin and Regular User)

### 2. Admin User Management

-   Admins can view, create, and delete user accounts.
-   View all users registered in the system

### 3. Admin Book Management

-   Admins can manage the books in the library including adding, updating, and removing books.
-   Book details include title, author, description, availability, and publication date.

### 4. Rating Operation

-   Registered users can rate books
-   Users can update or delete their ratings.

### 5. Borrow Book Operation

-   Users can borrow available books from the library.
-   Borrow records include borrowing date, due date (14 days from the borrowed date), and returned date.

## Requirments

-   PHP Version 8.3 or earlier
-   Laravel Version 11 or earlier
-   composer
-   XAMPP: Local development environment (or a similar solution)

## API Endpoints

### 1.Authentication

-   POST /api/register: Register a new user
-   POST /api/login: Log in with email and password
-   POST /api/logout: Log out the current user

### 2.Admin User Management

-   GET /api/user : View all users(admin only)
-   POST /api/user : Create a new user(admin only)
-   DELETE /api/user/{id} : Delete user (admin only)

### 3. Admin Book Management

-   GET /api/book : View all books (Admin only)
-   POST /api/book : Add a new book (Admin only)
-   PUT /api/book/{id} : Update book details (Admin only)
-   DELETE /api/book/{id} : Delete a book (Admin only)

### 4.Rating Operation

-   GET /api/rating : View all rating
-   POST /api/rating : Add a rating for a book
-   PUT /api/rating/{id} : Update a rating for a book
-   DELETE /api/rating/{id} : Delete a rating

### 5. Borrow Book Operation

-   GET /api/borrow : View all borrowRecord
-   POST /api/borrow : Borrow a book
-   PUT /api/borrow : Mark a book as returned
-   DELETE /api/borrow : Delete a borrow (admin only)

## Postman Collection:

You can access the Postman collection for this project by following this [link](https://lively-resonance-695697.postman.co/workspace/My-Workspace~f4d36390-4463-41a5-819e-d347e13c96b0/collection/37833857-0939764b-fe87-4639-864a-efef1a6f3e8c?action=share&creator=37833857). The collection includes all the necessary API requests for testing the application.
