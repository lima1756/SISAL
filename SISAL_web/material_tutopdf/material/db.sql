create database if not exists tutorialpdf;
use tutorialpdf;

create table productos(
	id int primary key auto_increment,
	nombre varchar(255),
	descripcion varchar(2000),
	precio float,
	cantidad int	
);

insert into productos(nombre, descripcion, precio, cantidad) values('TABLET HUAWEY T1 - A21W : 8GB - WIFFI - BLANCA', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 99.99, 7);
insert into productos(nombre, descripcion, precio, cantidad) values('VIDRIO TEMPLADO HUAWEI P8', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 5.99, 50);
insert into productos(nombre, descripcion, precio, cantidad) values('DISPLAY HUAWEI Y300','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 59.99, 10);
insert into productos(nombre, descripcion, precio, cantidad) values('CABLE VGA 10 METROS','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 99.99, 5);
insert into productos(nombre, descripcion, precio, cantidad) values('CONVERTIDOR USB 3.0 A ETHERNET','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 19.99, 4);
insert into productos(nombre, descripcion, precio, cantidad) values('D.D 3 TERAS SATA SEAGATE 3.5','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 199.99, 2);
insert into productos(nombre, descripcion, precio, cantidad) values('MEM CRUCIAL DDR III 4 GB 1600MHZ ','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 49.99, 3);

select * from productos;