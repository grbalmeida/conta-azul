DROP DATABASE IF EXISTS conta_azul;
CREATE DATABASE conta_azul;
USE conta_azul;

CREATE TABLE groups(
  id int primary key auto_increment,
  name varchar(50) not null
);

CREATE TABLE permissions(
  id int primary key auto_increment,
  name varchar(50) not null
);

CREATE TABLE groups_has_permissions(
  id int primary key auto_increment,
  group_id int not null,
  permission_id int not null,
  foreign key (group_id) references groups (id),
  foreign key (permission_id) references permissions (id)
);

CREATE TABLE users(
  id int primary key auto_increment,
  email varchar(50) not null,
  password varchar(32) not null,
  group_id int not null,
  foreign key (group_id) references groups (id)
);

CREATE TABLE customers(
  id int primary key auto_increment,
  name varchar(100) not null,
  email varchar(100),
  phone varchar(20),
  address varchar(100),
  neighborhood varchar(100),
  city varchar(100),
  state varchar(100),
  country varchar(100),
  zipcode varchar(50),
  stars int(2) default 3,
  note text
);

CREATE TABLE inventory(
  id int primary key auto_increment,
  name varchar(100) not null,
  price float not null,
  quantity int not null,
  minimum_quantity int not null
);

CREATE TABLE inventory_history(
  id int primary key auto_increment,
  product_id int not null,
  user_id int not null,
  action varchar(3) not null,
  action_date datetime not null,
  foreign key (product_id) references inventory (id)
);

CREATE TABLE sales(
  id int primary key auto_increment,
  customer_id int not null,
  user_id int not null,
  sale_date datetime not null,
  total_price float not null,
  foreign key (customer_id) references customers (id),
  foreign key (user_id) references users (id)
);

CREATE TABLE sales_has_products(
  id int primary key auto_increment,
  sale_id int not null,
  product_id int not null,
  quantity int not null,
  sale_price float not null,
  foreign key (sale_id) references sales (id),
  foreign key (product_id) references inventory (id)
);

CREATE TABLE purchases(
  id int primary key auto_increment,
  user_id int not null,
  purchase_date datetime not null,
  total_price float not null,
  foreign key (user_id) references users (id)
);

CREATE TABLE purchases_has_products(
  id int primary key auto_increment,
  purchase_id int not null,
  name varchar(100),
  quantity float not null,
  purchase_price float not null,
  foreign key (purchase_id) references purchases(id)
);

CREATE TABLE companies(
  id int primary key auto_increment,
  name varchar(100) not null
);

ALTER TABLE groups ADD COLUMN company_id int not null;
ALTER TABLE groups ADD CONSTRAINT fk_group_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE permissions ADD COLUMN company_id int not null;
ALTER TABLE groups ADD CONSTRAINT fk_permission_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE groups_has_permissions ADD COLUMN company_id int not null;
ALTER TABLE groups_has_permissions ADD CONSTRAINT fk_group_has_permissions_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE users ADD COLUMN company_id int not null;
ALTER TABLE users ADD CONSTRAINT fk_user_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE customers ADD COLUMN company_id int not null;
ALTER TABLE customers ADD CONSTRAINT fk_customer_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE inventory ADD COLUMN company_id int not null;
ALTER TABLE inventory ADD CONSTRAINT fk_inventory_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE inventory_history ADD COLUMN company_id int not null;
ALTER TABLE inventory_history ADD CONSTRAINT fk_inventory_history_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE sales ADD COLUMN company_id int not null;
ALTER TABLE sales ADD CONSTRAINT fk_sale_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE sales_has_products ADD COLUMN company_id int not null;
ALTER TABLE sales_has_products ADD CONSTRAINT fk_sale_product_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE purchases ADD COLUMN company_id int not null;
ALTER TABLE purchases ADD CONSTRAINT fk_purchase_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE purchases_has_products ADD COLUMN company_id int not null;
ALTER TABLE purchases_has_products ADD CONSTRAINT fk_purchase_product_company FOREIGN KEY (company_id) REFERENCES companies (id);

ALTER TABLE users ADD COLUMN name varchar(100) not null;
