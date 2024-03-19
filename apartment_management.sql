CREATE DATABASE apartment_management;

USE apartment_management;

CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL
);

CREATE TABLE owner (
    owner_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    admin_id INT,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE CASCADE
);

CREATE TABLE tenant (
    tenant_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    age INT NOT NULL,
    dob DATE NOT NULL,
    owner_id INT,
    FOREIGN KEY (owner_id) REFERENCES owner(owner_id) ON DELETE CASCADE
);

CREATE TABLE employee (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    admin_id INT,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE CASCADE
);

CREATE TABLE parking_slot (
    parking_slot_id INT AUTO_INCREMENT PRIMARY KEY,
    slot_number INT NOT NULL,
    owner_id INT,
    FOREIGN KEY (owner_id) REFERENCES owner(owner_id) ON DELETE CASCADE
);

CREATE TABLE room (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    building_name VARCHAR(255) NOT NULL,
    unit_number INT NOT NULL,
    owner_id INT,
    FOREIGN KEY (owner_id) REFERENCES owner(owner_id) ON DELETE CASCADE
);

CREATE TABLE complaint (
    complaint_id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT NOT NULL,
    tenant_id INT,
    owner_id INT,
    employee_id INT,
    FOREIGN KEY (tenant_id) REFERENCES tenant(tenant_id) ON DELETE CASCADE,
    FOREIGN KEY (owner_id) REFERENCES owner(owner_id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employee(employee_id) ON DELETE CASCADE
);

CREATE TABLE service_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id INT,
    service_id INT,
    requested_time DATETIME,
    FOREIGN KEY (tenant_id) REFERENCES tenant(tenant_id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE
);

INSERT INTO admin (username, password, email, phone_number)
VALUES ('Abhyudith', '12345', 'abhyudith@gmail.com', '9742911000');

CREATE TABLE maintenance_payment (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id INT,
    amount_paid DECIMAL(10, 2),
    payment_date DATE,
    FOREIGN KEY (tenant_id) REFERENCES tenant(tenant_id) ON DELETE CASCADE
);

-- For the owner table
ALTER TABLE owner
ADD COLUMN password VARCHAR(255) NOT NULL;

-- For the tenant table
ALTER TABLE tenant
ADD COLUMN password VARCHAR(255) NOT NULL;

ALTER TABLE tenant
ADD COLUMN username VARCHAR(255) NOT NULL;

-- For the employee table
ALTER TABLE employee
ADD COLUMN password VARCHAR(255) NOT NULL;

ALTER TABLE employee ADD COLUMN username VARCHAR(255) NOT NULL;

ALTER TABLE employee ADD COLUMN password VARCHAR(255) NOT NULL;

ALTER TABLE employee
ADD COLUMN owner_id INT,
ADD FOREIGN KEY (owner_id) REFERENCES owner(owner_id) ON DELETE CASCADE;

ALTER TABLE employee ADD COLUMN name VARCHAR(50) NOT NULL;

ALTER TABLE owner
ADD COLUMN username VARCHAR(100) NOT NULL UNIQUE,
ADD COLUMN password VARCHAR(100) NOT NULL;

CREATE TABLE hotel (
    building_id INT AUTO_INCREMENT PRIMARY KEY,
    building_name VARCHAR(255) NOT NULL
);

CREATE TABLE apartment (
    apartment_id INT AUTO_INCREMENT PRIMARY KEY,
    building_name VARCHAR(255) NOT NULL,
    unit_number VARCHAR(10) NOT NULL,
    owner_id INT NOT NULL,
    FOREIGN KEY (owner_id) REFERENCES owner(owner_id)
);

INSERT INTO apartment (building_name, unit_number, owner_id) VALUES ('Prestige Shantiniketan', 'A1', 1);
INSERT INTO apartment (building_name, unit_number, owner_id) VALUES ('Salarpuria Sattva Greenage', 'B2', 2);
INSERT INTO apartment (building_name, unit_number, owner_id) VALUES ('Sobha Silicon Oasis', 'C3', 3);
INSERT INTO apartment (building_name, unit_number, owner_id) VALUES ('Brigade Millennium', 'D4', 4);
INSERT INTO apartment (building_name, unit_number, owner_id) VALUES ('Purva Riviera', 'E5', 5);

ALTER TABLE maintenance_payment
ADD COLUMN service_id INT,
ADD COLUMN service_name VARCHAR(255) NOT NULL,
ADD COLUMN fee_amount DECIMAL(10, 2) NOT NULL,
ADD FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE;

CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(255) NOT NULL,
    fee_amount DECIMAL(10, 2) NOT NULL
);


INSERT INTO services (service_name, fee_amount) VALUES ('Plumbing Repair', 50.00);
INSERT INTO services (service_name, fee_amount) VALUES ('Electrical Maintenance', 60.00);
INSERT INTO services (service_name, fee_amount) VALUES ('HVAC Service', 70.00);
INSERT INTO services (service_name, fee_amount) VALUES ('Pest Control', 40.00);
INSERT INTO services (service_name, fee_amount) VALUES ('Appliance Repair', 80.00);

CREATE TABLE enquiries (
    enquiry_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    enquiry_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE salary_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    current_salary DECIMAL(10, 2),
    requested_increment DECIMAL(10, 2),
    reason TEXT
);

CREATE TABLE parking (    id INT(11) AUTO_INCREMENT PRIMARY KEY,    employee_id INT(11) NOT NULL,    parking_slot VARCHAR(50) NOT NULL);  


ALTER TABLE complaints
ADD COLUMN tenant_id INT,
ADD FOREIGN KEY (tenant_id) REFERENCES Complaints(complaint_id) ON DELETE CASCADE;

ALTER TABLE room ADD COLUMN total_flats INT;
UPDATE room SET total_flats = 70;

SELECT CONCAT(tenant.first_name, ' ', tenant.last_name) AS tenant_name, 
       SUM(maintenance_payment.amount_paid) AS total_fees_paid,
       GROUP_CONCAT(maintenance_payment.description SEPARATOR ', ') AS fees_description
FROM tenant
LEFT JOIN maintenance_payment ON tenant.tenant_id = maintenance_payment.tenant_id
GROUP BY tenant_name;
