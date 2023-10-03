CREATE DATABASE IF NOT EXISTS banco;

USE banco;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`nombre`, `email`, `password`) VALUES
('Gunar Castro', 'profcodegunar@gmail.com', '$2y$10$x.dFM4ehPPoWoH4m14gtWeBL252g7A.6NdoYo0eeGr70z5Lqof7di');
