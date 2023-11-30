# Project Name ContractFlow

# Overview
This project, built on 
# XAMPP with PHP and MySQL, 
aims to create a comprehensive web application for efficient contract, user, and invoice management. The following objectives guide the development and functionality of the system.

# Website Objectives
# Seamless User Registration Process:
- Establish a user-friendly process for new employee onboarding. Securely store employee details in the MySQL database.

# Efficient Contract Management:
- Streamline the creation, tracking, and notification processes for contracts. Centralize reviewer comments for improved collaboration.

# Intuitive Admin Dashboard:
- Provide an intuitive admin page post-login for convenient access to system functionalities. Set the Reports Section as the default display for informed decision-making.

# Comprehensive Reports Generation:
Generate detailed reports on the newest contracts and contractors.
Allow customization and easy export of generated reports.

# Timely Notice Periods and Expiration Alerts:
+ Deliver timely alerts for notice periods and contract expirations.
Ensure proactive contract management within the organization.
Effective User Management:

# Manage user profiles and related issues seamlessly.
- Implement a robust user management system with secure access controls.

# Seamless Invoice Management:
Facilitate attaching invoices and accessing detailed invoice information.
Enable the generation of comprehensive financial reports for effective financial tracking.

# Getting Started
To run the project locally using XAMPP:

Clone the repository into your XAMPP htdocs directory.
Configure the database settings in the PHP files.
Import the provided MySQL database dump.
Start the Apache and MySQL servers using the XAMPP control panel.
Access the application through your web browser (e.g., http://localhost/project_name).
Contributing

# Contributions are welcome! If you'd like to contribute to the project, please follow the contribution guidelines outlined in the CONTRIBUTING.md file.

# License
This project is licensed under the 
# Keyan Andy Delgado Fajanoy

# Acknowledgments
Special thanks to contributors who have dedicated their time and effort to this project.
Inspiration from similar projects and open-source communities.



 insert into customers(customer_name) values('Alice', 'Bob', 'Tom' 'Jerry', 'John');
MariaDB [labexam_db]> insert into customers(customer_name) values('Alice'), ('Bob'), ('Tom'), ('Jerry'), ('John');
MariaDB [labexam_db]> insert into customers(name) values('Alice'), ('Bob'), ('Tom'), ('Jerry'), ('John');

 insert into product(product_name, price) values('Keyboard', 120), ('Mouse', 80), ('Screen', 600), ('Hard disk' 450);
MariaDB [labexam_db]> insert into product(product_name, price) values('Keyboard', 120), ('Mouse', 80), ('Screen', 600);

alter table orders add constraint fk_product_id foreign key(product_id) references product(product_id);
Query OK, 0 rows affected (0.027 sec)
Records: 0  Duplicates: 0  Warnings: 0

MariaDB [labexam_db]>  alter table orders add constraint fk_customer_id foreign key(customer_id) references customers(customer_id);
