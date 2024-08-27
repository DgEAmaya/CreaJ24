create database subastaDona;
use subastaDona;


-- Tabla Cliente
create table Cliente(
    idCliente int auto_increment,
    nombre varchar (30),
    apellido varchar (30),
    email varchar (100),
    dui varchar (10),
    direccion varchar (200),
    tarjetaCredito varchar(12),
    telefono varchar (8),
    contraseña varchar (20),
    constraint idClie primary key (idCliente)
);

create table Subasta(
    idSubasta int auto_increment,
    nombreProduc varchar (100),
	categoProduc varchar (30),
    detallesProduc varchar(100),
	estadoProduc varchar (100),
	precioFijo double,
    precioInicial double,
    direccionEnvio varchar (200),
    constraint idSubas primary key(idSubasta)
);

Create table donacion(
    idDonacion int auto_increment,
    categoDona varchar(100),
    constraint idDona primary key (idDonacion)
);

Create table Inspector (
    idInspector int auto_increment,
    nombreInspec varchar (200),
    dui varchar(10),
    contraseña varchar (20),
    direccioninspec varchar (200),
    constraint idInspe  primary key (idInspector)
);

create table realizarDonacion (
	idEmisor int auto_increment,
    nomDonador varchar (50),
    emailDonador varchar (50),
    direccionEnvio varchar (100),
    telDonador varchar (8),
    producDonar varchar (100),
    cantDonar int,
    estadoProduc varchar (50),
    constraint primary key (idEmisor)
);

create table solicitarDonacion (
	idReceptor int auto_increment,
    nomReceptor varchar (50),
    emailReceptor varchar (50),
    direccionReceptora varchar (100),
    telReceptor varchar (8),
    producSolicitar varchar (100),
    cantSolicitar int,
    estadoProduc varchar (50),
    constraint primary key (idReceptor)
);

Create table Administrador (
    idAdmin int auto_increment,
    nombre varchar (30),
    email varchar (100),
    contraseña varchar (100),
    constraint idAdmi primary key (idAdmin)
);

Create table Categoria(
    idCategoria int auto_increment,
    tipo varchar(20),
    nombreCategoria varchar(20),
    constraint idCatego primary key (idCategoria)
);

create table CarritoSubasta(
idCarritoSubasta int auto_increment,
constraint primary key (idCarritoSubasta)
);

create table Reclamos (
idReclamos int auto_increment,
idCliente1 int,
mensaje varchar(100),
fecha date,
constraint idReclam primary key (idReclamos),
constraint idClient foreign key (idCliente1) references Cliente(idCliente)
);

create table subastaGanada (
idSubastaganada int auto_increment,
idCliente int,
idCarritoSubasta int,
constraint primary key (idSubastaganada),
constraint foreign key (idCliente) references Cliente(idCliente),
constraint foreign key (idCarritoSubasta) references CarritoSubasta(idCarritoSubasta) 
);

create table Productos (
    idProducto int,
    estadoProduc varchar (100),
    categoProduc varchar (100),
    detallesProduc varchar (200),
    cantProduc int,
    constraint primary key (idProducto)
);

-- Tabla CasaSubastasDonaciones
create table CasaSubastaDonacion(
    idSubastaDona int auto_increment,
	idAdmin int,
    nombre varchar (100),
    email varchar (100),
    descripcion varchar (300),
    direccionWeb varchar (300),
    constraint primary key (idSubastaDona),
    constraint foreign key (idAdmin) references Administrador (idAdmin)
);


-- TABLAS INTERMEDIAS --

create table cliente_CasaSubastaDonacion(
	idCliente int,
    idSubastaDona int,
    constraint foreign key (idCliente) references cliente(idCliente),
    constraint foreign key(idSubastaDona) references CasaSubastaDonacion(idSubastaDona)
);

Create table ProductoCasaSubastaDona (
    idProducto1 int,
    idSubastaDona2 int,
    constraint foreign key (idProducto1) references Productos(idProducto),
    constraint foreign key (idSubastaDona2) references CasaSubastaDonacion(idSubastaDona)
);
    
create table CasaSubastaDona_SubastasDona (
	idSubastaDona int,
	idSubasta int,
	idDonacion int,
	constraint foreign key (idSubastaDona) references CasaSubastaDonacion(idSubastaDona),
	constraint foreign key (idSubasta) references Subasta (idSubasta),
	constraint foreign key (idDonacion) references donacion(idDonacion)
);
    
create table casaSubastaDona_Categoria(
	idSubastaDona int,
	idCategoria int,
	foreign key (idSubastaDona) references  CasaSubastaDonacion(idSubastaDona),
	foreign key (idCategoria) references Categoria(idCategoria)
);
    
create table donacion_Inspector(
	idInspector int,
	idDonacion int,
	constraint foreign key (idDonacion) references donacion(idDonacion),
	constraint foreign key (idInspector) references Inspector(idInspector)
);

create table Donacion_Solicitar_Realizar(
idReceptor int,
idEmisor int,
idDonacion int,
constraint foreign key (idReceptor) references solicitarDonacion(idReceptor),
constraint foreign key (idEmisor) references realizarDonacion(idEmisor),
constraint foreign key (idDonacion) references donacion(idDonacion)
);











