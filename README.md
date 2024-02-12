# Sports-Shop
Welcome to our comprehensive sports shop system, a fully integrated platform designed to cater to all your sporting needs. Our system is meticulously structured into three distinct subsystems, each made to serve a specific role within our sports retail environment: Admin, Customer, and Employee. 

Initialization and Database Connection: The script starts by initializing the session and establishing a database connection using MySQLi.

User Registration and Login: The code handles user registration and login functionalities. It encrypts passwords using PHP's password_hash() function and verifies passwords using password_verify().

User Role Management: The system supports three user roles: Admin, Employee, and Customer. The role is stored in the session upon login and used to determine access levels and functionalities.

Admin Interface: Admins have access to user management features, including adding, editing, and deleting users. They can also filter users based on their roles and perform CRUD operations on user accounts.

Employee Interface: Employees can manage products, including adding, editing, and deleting products. They can also view orders and update their status.

Customer Interface: Customers can browse available products, add them to the cart, view their cart contents, place orders, and view their order history.

HTML Structure: The HTML structure includes forms for user registration, login, and various management interfaces. It also displays tables for listing users, products, and orders.

JavaScript: There's JavaScript code for toggling between login and registration forms.

Styling: CSS styles are provided for layout and design, including responsiveness and visual enhancements.

Overall, the code represents a functional sports shop system with role-based access control and essential management functionalities for admins, employees, and customers. It covers user authentication, product management, order processing, and user interface components. Additional features and enhancements can be implemented based on specific requirements and use cases.
