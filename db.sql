DROP DATABASE IF EXISTS jibk;
CREATE DATABASE IF NOT EXISTS jibk;

USE jibk;

DROP TABLE IF EXISTS expenses;
CREATE TABLE IF NOT EXISTS expenses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(30) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    description TEXT DEFAULT NULL,
    date DATE DEFAULT (current_time)
); 


DROP TABLE IF EXISTS incomes;
CREATE TABLE IF NOT EXISTS incomes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(30) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    description TEXT DEFAULT NULL,
    date DATE DEFAULT (current_time)
); 

select *, "expense" as type from expenses
UNION
select *, "income" as type from incomes
order by date;


INSERT INTO incomes (title, amount, description, date) VALUES('Salary Payment', 3500.00, 'Monthly salary for January', '2025-01-31'),
('Salary Payment', 3500.00, 'Monthly salary for February', '2025-02-28'),
('Freelance Project', 450.00, 'Mobile app UI work', '2025-02-18'),
('Salary Payment', 3500.00, 'Monthly salary for March', '2025-03-31'),
('Online Sales', 320.00, 'Sold items online', '2025-03-25'),
('Salary Payment', 3500.00, 'Monthly salary for April', '2025-04-30'),
('Interest Income', 48.10, 'Bank interest payout', '2025-04-20'),
('Salary Payment', 3500.00, 'Monthly salary for May', '2025-05-31'),
('Freelance Project', 900.00, 'WordPress site development', '2025-05-10'),
('Gift', 150.00, 'Received from family', '2025-05-25'),
('Salary Payment', 3500.00, 'Monthly salary for June', '2025-06-30'),
('Rental Income', 1000.00, 'Apartment rent', '2025-06-01'),
('Stock Dividend', 125.00, 'Dividend payout', '2025-06-12'),
('Salary Payment', 3500.00, 'Monthly salary for July', '2025-07-31'),
('Freelance Project', 700.00, 'Backend API development', '2025-07-08'),
('Refund', 85.50, 'Refund for software return', '2025-07-20'),
('Salary Payment', 3500.00, 'Monthly salary for August', '2025-08-31'),
('Rental Income', 1000.00, 'Apartment rent', '2025-08-01'),
('Consulting Fee', 1100.00, 'Business consulting', '2025-08-18'),
('Salary Payment', 3500.00, 'Monthly salary for September', '2025-09-30'),
('Interest Income', 50.25, 'Quarterly interest', '2025-09-15'),
('Freelance Project', 820.00, 'Frontend redesign', '2025-09-22'),
('Salary Payment', 3500.00, 'Monthly salary for October', '2025-10-31'),
('Bonus', 600.00, 'Special project bonus', '2025-10-10'),
('Online Sales', 400.00, 'Sold old electronics', '2025-10-20'),
('Salary Payment', 3500.00, 'Monthly salary for November', '2025-11-30'),
('Rental Income', 1000.00, 'Apartment rent', '2025-11-01'),
('Freelance Project', 550.00, 'API integration task', '2025-11-18'),
('Salary Payment', 3500.00, 'Monthly salary for December', '2025-12-31'),
('Stock Dividend', 130.00, 'Quarterly dividend', '2025-12-05'),
('Gift', 200.00, 'Early holiday gift', '2025-12-08');


INSERT INTO expenses (title, amount, description, date) VALUES
('Rent', 1500.00, 'Monthly apartment rent', '2025-01-01'),
('Groceries', 220.45, 'Weekly groceries', '2025-01-05'),
('Electricity Bill', 120.60, 'Monthly electricity', '2025-01-10'),
('Internet Bill', 70.00, 'Monthly internet', '2025-01-12'),
('Restaurant', 95.30, 'Dinner out', '2025-01-15'),
('Gas', 110.00, 'Car fuel', '2025-01-18'),
('Gym Membership', 60.00, 'Monthly gym', '2025-01-20'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-02-01'),
('Groceries', 230.20, 'Weekly groceries', '2025-02-03'),
('Transportation', 45.50, 'Public transport', '2025-02-01'),
('House Supplies', 60.80, 'Cleaning items', '2025-02-03'),
('Electricity Bill', 125.10, 'Monthly electricity', '2025-02-10'),
('Restaurant', 85.00, 'Lunch with friends', '2025-02-18'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-03-01'),
('Groceries', 225.90, 'Weekly groceries', '2025-03-05'),
('Internet Bill', 70.00, 'Monthly internet', '2025-03-12'),
('Healthcare', 250.00, 'Medical check-up', '2025-03-15'),
('Gas', 120.00, 'Fuel refill', '2025-03-20'),
('Clothing', 185.40, 'Bought shoes and jacket', '2025-03-25'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-04-01'),
('Groceries', 232.75, 'Weekly groceries', '2025-04-04'),
('Electricity Bill', 135.00, 'Monthly electricity', '2025-04-10'),
('Restaurant', 75.50, 'Dinner outing', '2025-04-14'),
('Subscription', 20.99, 'Streaming service', '2025-04-18'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-05-01'),
('Groceries', 240.30, 'Weekly groceries', '2025-05-06'),
('Internet Bill', 70.00, 'Monthly internet', '2025-05-12'),
('Gas', 115.00, 'Fuel refill', '2025-05-15'),
('Entertainment', 85.00, 'Cinema tickets', '2025-05-22'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-06-01'),
('Groceries', 255.50, 'Weekly groceries', '2025-06-05'),
('Electricity Bill', 145.20, 'Monthly electricity', '2025-06-10'),
('Restaurant', 110.00, 'Dinner with family', '2025-06-18'),
('Healthcare', 260.00, 'Dentist visit', '2025-06-25'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-07-01'),
('Groceries', 265.90, 'Weekly groceries', '2025-07-04'),
('Internet Bill', 70.00, 'Monthly internet', '2025-07-12'),
('Gas', 130.20, 'Fuel refill', '2025-07-16'),
('House Supplies', 60.99, 'Cleaning supplies', '2025-07-22'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-08-01'),
('Groceries', 258.30, 'Weekly groceries', '2025-08-03'),
('Electricity Bill', 140.10, 'Monthly electricity', '2025-08-10'),
('Restaurant', 98.50, 'Dinner with coworkers', '2025-08-16'),
('Entertainment', 120.00, 'Concert ticket', '2025-08-28'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-09-01'),
('Groceries', 272.60, 'Weekly groceries', '2025-09-05'),
('Internet Bill', 70.00, 'Monthly internet', '2025-09-12'),
('Gas', 128.50, 'Fuel refill', '2025-09-18'),
('Clothing', 210.00, 'Bought fall clothing', '2025-09-22'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-10-01'),
('Groceries', 282.90, 'Weekly groceries', '2025-10-04'),
('Electricity Bill', 150.30, 'Monthly electricity', '2025-10-10'),
('Restaurant', 115.40, 'Dinner out', '2025-10-15'),
('House Supplies', 75.20, 'Cleaning and home items', '2025-10-26'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-11-01'),
('Groceries', 288.45, 'Weekly groceries', '2025-11-06'),
('Internet Bill', 70.00, 'Monthly internet', '2025-11-12'),
('Gas', 140.10, 'Fuel refill', '2025-11-18'),
('Healthcare', 230.00, 'General check-up', '2025-11-22'),

('Rent', 1500.00, 'Monthly apartment rent', '2025-12-01'),
('Groceries', 295.70, 'Weekly groceries', '2025-12-05'),
('Electricity Bill', 155.80, 'Monthly electricity', '2025-12-08'),
('Restaurant', 130.60, 'Weekend dinner', '2025-12-07'),
('Gift Shopping', 200.00, 'Holiday gifts', '2025-12-20');