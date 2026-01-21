CREATE USER 'lerestaurantdudev_user'@'localhost' IDENTIFIED BY 'LeRestaurantDuDevUser69';
GRANT SELECT, INSERT, UPDATE, DELETE ON lerestaurantdudev.* TO 'lerestaurantdudev_user'@'localhost';

CREATE USER 'lerestaurantdudev_admin'@'localhost' IDENTIFIED BY 'LeRestaurantDuDevAdmin69';
GRANT ALL PRIVILEGES ON lerestaurantdudev.* TO 'lerestaurantdudev_admin'@'localhost';
