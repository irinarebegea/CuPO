CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  role BOOLEAN NOT NULL
);

CREATE TABLE pantry (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL UNIQUE,
	FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255)
);

CREATE TABLE ingredients (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255),
	category_id INT NOT NULL,
	FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE pantry_items (
	id INT AUTO_INCREMENT PRIMARY KEY,
	pantry_id INT NOT NULL,
	ingredient_id INT NOT NULL,
	quantity FLOAT,
	in_stock BOOLEAN,
	bought DATE,
	expires DATE,
	FOREIGN KEY (pantry_id) REFERENCES pantry(id),
	FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
);

CREATE TABLE grocery_lists (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	title VARCHAR(255),
	created_at DATE,
	FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE grocery_list_items (
	id INT AUTO_INCREMENT PRIMARY KEY,
	list_id INT NOT NULL,
	ingredient_id INT NOT NULL,
	quantity FLOAT,
	notes VARCHAR(255),
	FOREIGN KEY (list_id) REFERENCES grocery_lists(id),
	FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
);