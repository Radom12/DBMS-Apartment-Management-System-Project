# Apartment Management System

## Description

This is an Apartment Management System built using PHP, MySQL, HTML, CSS, and JavaScript. It provides functionalities for different user types including Admin, Owner, Tenant, and Employee.

## Features

- Admin, Owner, Tenant, and Employee can login and logout.
- Admin can view the tenant and owner details, create owner, allot parking slot, and view the complaints.
- Owner can see the Tenant details of his/her owned room, create Tenant, see the complaints from his/her owned room, and see the Room Details.
- Tenant can see the alloted parking slot, pay maintenance fee, raise complaints, and see his/her details.
- Employee can see all the complaints.

## Installation

1. Clone the repository: `https://github.com/Radom12/DBMS-Apartment-Management-System-Project`
2. Navigate to the project directory: `cd apartment-management-system`
3. Import the SQL file into your MySQL database.

## Usage

1. Start your local server (like XAMPP, WAMP, MAMP).
2. Open your web browser and go to `localhost/apartment-management-system-Project`.
3. Use the application.
4. The Username for Admin login is Abhyudith and Pssword is 12345.
5. The Passwords for Employee Login, can be set through the databse.
6. Any Mail sent through the database will need to be first configured via the PHP mailer.
7. Install PHP mailer and save it in the same Folder.

## Issues

This project was completed in a short time frame, and has quite a few issues like:
1.Database is not Normalized, hence a lot of Redundancy is Present.
2.The Owner user type was removed and merged with Admin, however some PHP files still exist for Owner type only.
3.The Dashboard pages(Admin and Employee) do not have any main section.

I will be updating the code frequently to fix any bugs, and optimize the code, to further reduce redundancy.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.Any Edits aor Suggestions are welcome.

## License

Apache 2.0 License
