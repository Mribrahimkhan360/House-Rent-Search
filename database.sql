-- Create Database
CREATE DATABASE IF NOT EXISTS house_rent;
USE house_rent;

-- Table: users (Admin)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: houses
CREATE TABLE houses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    rent DECIMAL(10,2) NOT NULL,
    rooms INT NOT NULL,
    bathrooms INT NOT NULL,
    description TEXT,
    image VARCHAR(255),
    contact_number VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Default Admin (password: admin123)
INSERT INTO users (email, password) VALUES 
('admin1@houserent.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert Sample Houses
INSERT INTO houses (title, location, rent, rooms, bathrooms, description, image, contact_number) VALUES
('Modern 2BHK Apartment', 'Dhanmondi, Dhaka', 25000.00, 2, 2, 'Beautiful modern apartment with all amenities. Close to schools and shopping centers.', 'house1.jpg', '01712345678'),
('Spacious 3BHK House', 'Gulshan, Dhaka', 45000.00, 3, 3, 'Luxurious house with parking space. Prime location in Gulshan.', 'house2.jpg', '01812345678'),
('Cozy 1BHK Studio', 'Mirpur, Dhaka', 12000.00, 1, 1, 'Perfect for students and single professionals. Affordable and clean.', 'house3.jpg', '01912345678'),
('Family 4BHK Villa', 'Banani, Dhaka', 60000.00, 4, 4, 'Spacious villa with garden. Ideal for large families.', 'house4.jpg', '01612345678'),
('Budget 2BHK Flat', 'Mohammadpur, Dhaka', 18000.00, 2, 1, 'Affordable flat in residential area. Good transport links.', 'house5.jpg', '01512345678');