CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'Cupcake'),
(2, 'Eclair'),
(3, 'Macaron'),
(4, 'Cookie');

-- --------------------------------------------------------

--
-- Structure de la table `commands`
--

CREATE TABLE IF NOT EXISTS `commands` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_client` int(5) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_client_2` (`id_client`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `commands`
--

INSERT INTO `commands` (`id`, `id_client`, `date_created`) VALUES
(25, 45, '2017-05-31 01:38:30'),
(27, 46, '2017-05-31 01:49:58');

-- --------------------------------------------------------

--
-- Structure de la table `command_line`
--

CREATE TABLE IF NOT EXISTS `command_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_command` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Contenu de la table `command_line`
--

INSERT INTO `command_line` (`id`, `id_command`, `id_product`, `quantity`) VALUES
(24, 25, 1, 1),
(25, 25, 2, 1),
(26, 25, 3, 1),
(27, 27, 1, 4),
(28, 27, 2, 21),
(29, 27, 3, 13),
(30, 27, 3, 1),
(31, 27, 5, 1000),
(32, 27, 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `id_category` int(2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `id_category`, `stock_quantity`) VALUES
(1, 'cupcake framboise', 12, 1, 43),
(2, 'cupcake vanille', 15, 1, 278),
(3, 'eclair vanille', 15, 2, -13),
(4, 'eclair fraise', 5, 2, 270),
(5, 'eclair chocolat', 5, 2, -802),
(6, 'macaron chocolat', 5, 3, 4),
(7, 'macaron citron', 8, 3, 15),
(8, 'Cookies Chocolat', 8, 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `adress` varchar(255) DEFAULT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `id_role` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `adress`, `confirmation_token`, `id_role`) VALUES
(43, 'jmechouche', 'jmechouche@gmail.com', '$2y$10$haopeivCkAhLcnix7IDjNeCHjm35ebbNTKRoNCtAQKqzlovBFBIfu', '555', NULL, 1),
(45, 'nancy', 'nancycamara19@gmail.com', '$2y$10$Y2sYUDboKorS4XlP0nruUOWE4eQW0KmaNYrksrW7PVXycywcuxHMm', ' 558 Evo', NULL, 2),
(46, 'Ella', 'nacamara@laposte.net', '$2y$10$L1/vgHrgV5eSTgA.LK7z5OB01mgzlwVJ9f4cxEavmjdfj3/i1lFi2', '58 popopo', NULL, 1);
