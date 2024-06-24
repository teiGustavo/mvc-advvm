CREATE TABLE IF NOT EXISTS users(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(100) NOT NULL,
    password VARCHAR(64) NOT NULL,
    adm TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS reports(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL DEFAULT "2024-01-01",
    report VARCHAR(100) NOT NULL DEFAULT 'INDEFINIDO',
    type VARCHAR(7) NOT NULL DEFAULT "TYPE",
    amount DOUBLE NOT NULL DEFAULT 0.0	
);

INSERT INTO users(email, password, adm) VALUES ('root@root', "$2y$10$O/H/mw2ya8k6NJ6EK7MenemWdrq6Suvx88j2xQ5oMX6khB2Qk.lJK", 1);

INSERT INTO `reports` (`id`, `date`, `report`, `type`, `amount`) VALUES
(19, '2022-07-01', 'Saldo Anterior', 'Entrada', 975.46),
(20, '2022-07-01', 'Dízimo', 'Entrada', 100),
(21, '2022-07-03', 'Dízimo', 'Entrada', 120),
(22, '2022-07-08', 'Dízimo', 'Entrada', 190),
(23, '2022-07-08', 'Dízimo', 'Entrada', 150),
(24, '2022-07-13', 'Dízimo', 'Entrada', 628.25),
(25, '2022-07-20', 'Dízimo', 'Entrada', 180),
(26, '2022-07-24', 'Dízimo', 'Entrada', 170),
(27, '2022-07-24', 'Dízimo', 'Entrada', 400),
(28, '2022-07-24', 'Dízimo', 'Entrada', 100),
(29, '2022-07-27', 'Dízimo', 'Entrada', 215),
(30, '2022-07-27', 'Dízimo', 'Entrada', 120),
(31, '2022-07-29', 'Dízimo', 'Entrada', 200),
(32, '2022-07-31', 'Dízimo', 'Entrada', 400),
(33, '2022-07-31', 'Dízimo', 'Entrada', 197),
(34, '2022-07-31', 'Dízimo', 'Entrada', 160),
(35, '2022-07-03', 'Ofertas', 'Entrada', 52.8),
(36, '2022-07-06', 'Ofertas', 'Entrada', 28),
(37, '2022-07-08', 'Ofertas', 'Entrada', 30.05),
(38, '2022-07-10', 'Ofertas', 'Entrada', 98.15),
(39, '2022-07-13', 'Ofertas', 'Entrada', 13),
(40, '2022-07-15', 'Ofertas', 'Entrada', 40.65),
(41, '2022-07-17', 'Ofertas', 'Entrada', 50.5),
(42, '2022-07-20', 'Ofertas', 'Entrada', 37.2),
(43, '2022-07-24', 'Ofertas', 'Entrada', 44.5),
(44, '2022-07-27', 'Ofertas', 'Entrada', 13),
(45, '2022-07-29', 'Ofertas', 'Entrada', 58.45),
(46, '2022-07-31', 'Ofertas', 'Entrada', 36),
(47, '2022-07-10', 'Ajuda Preletora', 'Saida', 150),
(48, '2022-07-08', 'Pg Pedreiro', 'Saida', 30),
(49, '2022-07-08', 'Lembrancinhas Diácono', 'Saida', 200),
(50, '2022-07-11', 'Rio', 'Saida', 540),
(51, '2022-07-10', 'Passagem Rio', 'Saida', 82.1),
(52, '2022-07-11', 'Água', 'Saida', 161.32),
(53, '2022-07-11', 'Luz', 'Saida', 143.44),
(54, '2022-07-10', 'Material Ceia', 'Saida', 16),
(55, '2022-07-20', 'Impressora', 'Saida', 249),
(56, '2022-07-29', 'Ajuda de Custo', 'Saida', 100),
(57, '2022-07-20', 'Aluguel Igreja', 'Saida', 700),
(58, '2022-07-29', 'Ajuda de Custo', 'Saida', 700),
(59, '2022-07-30', 'Limpeza Igreja', 'Saida', 150),
(60, '2022-07-20', '1ª Parcela Material de Construção', 'Saida', 140.52),
(61, '2022-04-01', 'Saldo Anterior', 'Entrada', 1425.06),
(62, '2022-04-01', 'Dízimo', 'Entrada', 100),
(63, '2022-04-03', 'Dízimos', 'Entrada', 120),
(64, '2022-04-06', 'Dízimos', 'Entrada', 100),
(65, '2022-04-08', 'Dízimos', 'Entrada', 100),
(66, '2022-04-08', 'Dízimos', 'Entrada', 180),
(67, '2022-04-08', 'Dízimos', 'Entrada', 100),
(68, '2022-04-13', 'Dízimos', 'Entrada', 205),
(69, '2022-04-19', 'Dízimos', 'Entrada', 150),
(70, '2022-04-23', 'Dízimos', 'Entrada', 400),
(71, '2022-04-23', 'Dízimos', 'Entrada', 296),
(72, '2022-04-27', 'Dízimo', 'Entrada', 170.65),
(73, '2022-04-24', 'Dízimo', 'Entrada', 100),
(74, '2022-04-30', 'Dízimo', 'Entrada', 160),
(75, '2022-04-30', 'Dízimo', 'Entrada', 98),
(76, '2022-04-27', 'Dízimo', 'Entrada', 120),
(78, '2022-04-29', 'Dízimo', 'Entrada', 110),
(79, '2022-04-29', 'Dízimo', 'Entrada', 300),
(80, '2022-04-01', 'Ofertas', 'Entrada', 42),
(81, '2022-04-03', 'Ofertas', 'Entrada', 86.95),
(82, '2022-04-06', 'Ofertas', 'Entrada', 60.45),
(83, '2022-04-08', 'Ofertas', 'Entrada', 42.45),
(84, '2022-04-10', 'Ofertas', 'Entrada', 103.5),
(85, '2022-04-13', 'Ofertas', 'Entrada', 28.75),
(86, '2022-04-15', 'Ofertas', 'Entrada', 57.3),
(87, '2022-04-17', 'Ofertas', 'Entrada', 70.35),
(88, '2022-04-23', 'Ofertas', 'Entrada', 73.5),
(89, '2022-04-24', 'Ofertas', 'Entrada', 18.7),
(90, '2022-04-27', 'Ofertas', 'Entrada', 28.75),
(91, '2022-04-29', 'Ofertas', 'Entrada', 86.35),
(92, '2022-04-03', 'Ajuda Preletora Itaperuna', 'Saida', 140),
(93, '2022-04-30', 'Limpeza Mensal', 'Saida', 150),
(94, '2022-04-30', 'Produtos de Limpeza', 'Saida', 56.65),
(95, '2022-04-30', '1ª Parcela da Impressora', 'Saida', 249),
(96, '2022-04-20', 'Aluguel', 'Saida', 700),
(97, '2022-04-06', 'Água', 'Saida', 149.45),
(98, '2022-04-06', 'Luz', 'Saida', 178.57),
(99, '2022-04-20', 'Som e Vídeo', 'Saida', 36),
(100, '2022-04-16', 'Material Crianças', 'Saida', 141.92),
(101, '2022-04-20', 'Bateria Violão', 'Saida', 20),
(102, '2022-04-09', 'Material de Limpeza', 'Saida', 56.65),
(103, '2022-04-12', 'Gasto com Alimentação', 'Saida', 156.88),
(104, '2022-04-12', 'Utensílios de Cozinha Kitnet', 'Saida', 131.94),
(105, '2022-04-30', 'Ajuda de Custo', 'Saida', 100),
(106, '2022-04-30', 'Ajuda de Custo', 'Saida', 700),
(107, '2022-05-01', 'Saldo Anterior', 'Entrada', 1966.7),
(108, '2022-05-04', 'Dízimo', 'Entrada', 120),
(109, '2022-05-08', 'Dízimo', 'Entrada', 100),
(110, '2022-05-13', 'Dízimo', 'Entrada', 150),
(111, '2022-05-18', 'Dízimo', 'Entrada', 180),
(112, '2022-05-18', 'Dízimo', 'Entrada', 280),
(113, '2022-05-20', 'Dízimo', 'Entrada', 160),
(114, '2022-05-22', 'Dízimo', 'Entrada', 100),
(115, '2022-05-22', 'Dízimo', 'Entrada', 400),
(116, '2022-05-25', 'Dízimo', 'Entrada', 100),
(117, '2022-05-27', 'Dízimo', 'Entrada', 110),
(118, '2022-05-29', 'Dízimo', 'Entrada', 262.7),
(119, '2022-05-29', 'Dízimo', 'Entrada', 120),
(120, '2022-05-29', 'Dízimo', 'Entrada', 210),
(121, '2022-05-30', 'Dízimo', 'Entrada', 120),
(122, '2022-05-01', 'Ofertas', 'Entrada', 40.55),
(123, '2022-05-04', 'Ofertas', 'Entrada', 29.5),
(124, '2022-05-08', 'Ofertas', 'Entrada', 115),
(125, '2022-05-11', 'Ofertas', 'Entrada', 20.75),
(126, '2022-05-13', 'Ofertas', 'Entrada', 59),
(127, '2022-05-18', 'Ofertas', 'Entrada', 124.05),
(128, '2022-05-20', 'Ofertas', 'Entrada', 44),
(129, '2022-05-22', 'Ofertas', 'Entrada', 16.7),
(130, '2022-05-25', 'Ofertas', 'Entrada', 29),
(131, '2022-05-27', 'Ofertas', 'Entrada', 29),
(132, '2022-05-29', 'Ofertas', 'Entrada', 35.6),
(133, '2022-05-02', 'Pastor', 'Saida', 500),
(134, '2022-05-20', 'Aluguel', 'Saida', 700),
(135, '2022-05-03', 'Luz', 'Saida', 313.22),
(136, '2022-05-16', 'Passagem Rio', 'Saida', 165.52),
(137, '2022-05-25', 'Preletora', 'Saida', 50),
(138, '2022-05-16', 'Gasolina Gilmar', 'Saida', 30),
(139, '2022-05-27', 'Carro de Aplicativo', 'Saida', 73.8),
(140, '2022-05-03', 'Água', 'Saida', 149.4),
(141, '2022-05-15', 'Gasto com Alimentação', 'Saida', 97.88),
(142, '2022-05-30', 'Limpeza Mensal', 'Saida', 150),
(143, '2022-05-17', 'Ajuda de Custo', 'Saida', 100),
(144, '2022-05-29', 'Ajuda de Custo', 'Saida', 700),
(145, '2022-05-20', '2ª Parcela da Impressora', 'Saida', 249),
(146, '2022-08-07', 'Dízimo', 'Entrada', 150),
(147, '2022-08-07', 'Dízimo', 'Entrada', 110),
(148, '2022-08-08', 'Dizimo', 'Entrada', 210),
(149, '2022-08-07', 'Dizimo', 'Entrada', 100),
(150, '2022-08-12', 'Dizimo', 'Entrada', 205),
(151, '2022-08-19', 'Dízimos', 'Entrada', 280),
(152, '2022-08-21', 'Dízimo', 'Entrada', 100),
(153, '2022-08-25', 'Dízimo', 'Entrada', 160),
(154, '2022-08-29', 'Dízimos', 'Entrada', 435),
(155, '2022-08-30', 'Dízimos', 'Entrada', 270),
(156, '2022-08-31', 'Dízimo', 'Entrada', 120),
(157, '2022-08-05', 'Ofertas', 'Entrada', 45.85),
(158, '2022-08-05', 'Ofertas', 'Entrada', 40),
(159, '2022-08-07', 'Ofertas', 'Entrada', 25.5),
(160, '2022-08-10', 'Ofertas', 'Entrada', 21.35),
(161, '2022-08-12', 'Ofertas', 'Entrada', 64.35),
(162, '2022-08-14', 'Ofertas', 'Entrada', 58.1),
(163, '2022-08-14', 'Ofertas', 'Entrada', 20.8),
(164, '2022-08-19', 'Ofertas', 'Entrada', 46.7),
(165, '2022-08-21', 'Ofertas', 'Entrada', 44),
(166, '2022-08-24', 'Ofertas', 'Entrada', 17.5),
(167, '2022-08-26', 'Ofertas', 'Entrada', 25),
(168, '2022-08-29', 'Ofertas', 'Entrada', 46.5),
(169, '2022-08-31', 'Ofertas', 'Entrada', 27.75),
(170, '2022-08-02', 'Lembranças dos Presbíteros', 'Saida', 100),
(171, '2022-08-07', 'Joubert - Material de Construção', 'Saida', 140.52),
(172, '2022-08-08', 'Copo Descartável', 'Saida', 59.88),
(173, '2022-08-08', 'Suporte e corda para violão', 'Saida', 114.9),
(174, '2022-08-08', 'Chaves kitnet', 'Saida', 30),
(175, '2022-08-08', 'Água', 'Saida', 161.73),
(176, '2022-08-08', 'Luz', 'Saida', 91.72),
(177, '2022-08-20', 'Aluguel', 'Saida', 700),
(178, '2022-08-20', 'Ajuda de custo', 'Saida', 100),
(179, '2022-08-20', 'Parcela Impressora', 'Saida', 249),
(180, '2022-08-14', 'Adesivo Dia dos Pais', 'Saida', 25),
(181, '2022-08-04', 'Ajuda Benefic. e Produtos Limpeza', 'Saida', 130.23),
(182, '2022-08-09', 'Compra de Pendrive', 'Saida', 35),
(183, '2022-08-09', 'Ajuda Beneficente (cx. de leite)', 'Saida', 77.88),
(184, '2022-08-30', 'Ajuda de custo', 'Saida', 700),
(185, '2022-08-30', 'Ajuda de custo', 'Saida', 600),
(186, '2022-08-19', 'Envelopes (100 und.)', 'Saida', 20),
(187, '2022-08-30', 'Limpeza Igreja', 'Saida', 150),
(188, '2022-08-30', 'Carro de aplicativo', 'Saida', 47),
(189, '2022-08-01', 'Saldo Anterior', 'Entrada', 1445.63),
(190, '2022-11-30', 'Dízimo', 'Entrada', 152),
(191, '2022-11-02', 'Dízimo', 'Entrada', 305),
(192, '2022-11-05', 'Dízimos', 'Entrada', 450),
(193, '2022-11-06', 'Dízimos', 'Entrada', 390),
(194, '2022-11-09', 'Dízimo', 'Entrada', 200),
(195, '2022-11-10', 'Dízimo', 'Entrada', 50),
(196, '2022-11-11', 'Dízimos', 'Entrada', 305),
(197, '2022-11-13', 'Dízimo', 'Entrada', 100),
(198, '2022-11-16', 'Dízimos', 'Entrada', 340),
(199, '2022-11-20', 'Dízimo', 'Entrada', 100),
(200, '2022-11-27', 'Dízimos', 'Entrada', 450),
(201, '2022-11-28', 'Dízimo', 'Entrada', 160),
(202, '2022-11-30', 'Dízimos', 'Entrada', 270),
(203, '2022-11-02', 'Ofertas', 'Entrada', 16),
(204, '2022-11-05', 'Ofertas', 'Entrada', 29.2),
(205, '2022-11-06', 'Ofertas', 'Entrada', 31.7),
(206, '2022-11-09', 'Ofertas', 'Entrada', 26),
(207, '2022-11-10', 'Ofertas', 'Entrada', 32.35),
(208, '2022-11-13', 'Ofertas', 'Entrada', 82.6),
(209, '2022-11-16', 'Ofertas', 'Entrada', 7.35),
(210, '2022-11-18', 'Ofertas', 'Entrada', 8),
(211, '2022-11-20', 'Ofertas', 'Entrada', 24),
(212, '2022-11-23', 'Ofertas', 'Entrada', 31.85),
(213, '2022-11-27', 'Ofertas', 'Entrada', 17.2),
(214, '2022-11-30', 'Ofertas', 'Entrada', 22.75),
(215, '2022-11-30', 'Dízimo', 'Entrada', 120),
(216, '2022-11-02', 'Presente Helenice', 'Saida', 100),
(217, '2022-11-05', 'Ajuda de Custo', 'Saida', 600),
(218, '2022-11-10', 'Frete da Mesa de Computador', 'Saida', 60),
(219, '2022-11-20', 'Ajuda Beneficente', 'Saida', 94.83),
(220, '2022-11-10', 'Compra Cooler', 'Saida', 123),
(222, '2022-11-27', 'Ajuda de Custo', 'Saida', 700),
(223, '2022-11-20', 'Serviços de Computador', 'Saida', 100),
(224, '2022-11-15', 'Ajuda RJ', 'Saida', 600),
(225, '2022-11-20', 'Du Festas', 'Saida', 152.39),
(226, '2022-11-19', 'Material Telhado', 'Saida', 21.98),
(227, '2022-11-11', 'Material Telhado', 'Saida', 61.98),
(228, '2022-11-20', 'Aluguel', 'Saida', 700),
(229, '2022-11-27', 'Água', 'Saida', 163.07),
(230, '2022-11-07', 'Água', 'Saida', 166.96),
(231, '2022-11-28', 'Luz', 'Saida', 108.68),
(232, '2022-11-07', 'Luz', 'Saida', 99.28),
(233, '2022-11-30', 'Devolução Valor Emprestado', 'Saida', 350),
(234, '2022-11-30', 'Carro de Aplicativo', 'Saida', 42),
(235, '2022-11-01', 'Saldo Anterior', 'Entrada', -452.4),
(236, '2022-10-01', 'Saldo Anterior', 'Entrada', 95.93),
(237, '2022-10-06', 'Dízimo', 'Entrada', 187),
(238, '2022-10-07', 'Dízimos', 'Entrada', 552),
(239, '2022-10-09', 'Dízimos', 'Entrada', 355),
(240, '2022-10-12', 'Dízimos', 'Entrada', 240),
(241, '2022-10-19', 'Dízimo', 'Entrada', 120),
(242, '2022-10-21', 'Dízimo', 'Entrada', 182),
(243, '2022-10-23', 'Dízimos', 'Entrada', 260),
(244, '2022-10-30', 'Dízimos', 'Entrada', 608),
(246, '2022-10-23', 'Dízimo', 'Entrada', 80),
(247, '2022-10-05', 'Ofertas', 'Entrada', 31),
(248, '2022-10-07', 'Ofertas', 'Entrada', 32.6),
(249, '2022-10-09', 'Ofertas', 'Entrada', 24.6),
(250, '2022-10-12', 'Ofertas', 'Entrada', 21.45),
(251, '2022-10-14', 'Ofertas', 'Entrada', 16),
(252, '2022-10-16', 'Ofertas', 'Entrada', 44.6),
(253, '2022-10-19', 'Ofertas', 'Entrada', 47),
(254, '2022-10-21', 'Ofertas', 'Entrada', 20),
(255, '2022-10-22', 'Ofertas', 'Entrada', 27.85),
(256, '2022-10-23', 'Ofertas', 'Entrada', 39.1),
(257, '2022-10-30', 'Ofertas', 'Entrada', 33.5),
(258, '2022-10-26', 'Ofertas', 'Entrada', 12),
(259, '2022-10-07', 'Água', 'Saida', 167.06),
(260, '2022-10-07', 'Luz', 'Saida', 38.52),
(261, '2022-10-10', 'Ceia + Ajuda Beneficente', 'Saida', 72.47),
(262, '2022-10-20', 'Última Parcela Impressora', 'Saida', 250),
(263, '2022-10-25', 'Ajuda de Custo', 'Saida', 100),
(264, '2022-10-20', 'Aluguel', 'Saida', 700),
(265, '2022-10-20', 'Chaveiros', 'Saida', 28),
(266, '2022-10-19', 'Ajuda Gasolina RJ', 'Saida', 700),
(267, '2022-10-29', 'Ajuda de Custo', 'Saida', 700),
(268, '2022-10-27', 'Ajuda de Custo', 'Saida', 400),
(269, '2022-10-30', 'Limpeza Mensal', 'Saida', 150),
(270, '2022-10-30', 'Carro de Aplicativo', 'Saida', 72),
(271, '2022-10-22', 'Post-its', 'Saida', 10),
(272, '2022-10-22', 'Material Outubro Rosa', 'Saida', 13.98),
(273, '2022-10-10', 'Revista Dominical', 'Saida', 80),
(274, '2022-09-01', 'Saldo Anterior', 'Entrada', 536.17),
(275, '2022-09-09', 'Lembranças para Missionárias', 'Saida', 100),
(276, '2022-09-23', 'RJ', 'Saida', 800),
(277, '2022-09-23', 'Bateria Violão', 'Saida', 13),
(278, '2022-09-09', 'Folha de Papel', 'Saida', 28.9),
(279, '2022-09-13', 'Material para Crianças', 'Saida', 70.47),
(280, '2022-09-10', 'Globo Microfone', 'Saida', 45),
(281, '2022-09-10', 'Material Ceia e Outros', 'Saida', 38.42),
(282, '2022-09-12', 'Água', 'Saida', 160.52),
(283, '2022-09-13', 'Luz', 'Saida', 126.08),
(284, '2022-09-30', 'Ajuda de Custo', 'Saida', 700),
(285, '2022-09-20', 'Aluguel', 'Saida', 700),
(286, '2022-09-30', 'Serviços de Computador', 'Saida', 100),
(287, '2022-09-30', 'Limpeza Mensal', 'Saida', 150),
(288, '2022-09-30', 'Ajuda de Custo', 'Saida', 400),
(289, '2022-09-20', 'Parcela Impressora', 'Saida', 249),
(290, '2022-09-09', 'Dízimo', 'Entrada', 140),
(291, '2022-09-07', 'Dízimo', 'Entrada', 122),
(292, '2022-09-09', 'Dízimos', 'Entrada', 305),
(293, '2022-09-11', 'Dízimos', 'Entrada', 337),
(294, '2022-09-14', 'Dízimos', 'Entrada', 400),
(295, '2022-09-23', 'Dízimos', 'Entrada', 340),
(296, '2022-09-25', 'Dízimo', 'Entrada', 100),
(297, '2022-09-28', 'Dízimo', 'Entrada', 120),
(298, '2022-09-30', 'Dízimos', 'Entrada', 480),
(299, '2022-09-02', 'Ofertas', 'Entrada', 78),
(300, '2022-09-04', 'Ofertas', 'Entrada', 31.25),
(301, '2022-09-07', 'Ofertas', 'Entrada', 21.4),
(302, '2022-09-09', 'Ofertas', 'Entrada', 15),
(303, '2022-09-11', 'Ofertas', 'Entrada', 31.1),
(304, '2022-09-16', 'Ofertas', 'Entrada', 20),
(305, '2022-09-14', 'Ofertas', 'Entrada', 21),
(306, '2022-09-18', 'Ofertas', 'Entrada', 45.65),
(307, '2022-09-22', 'Ofertas', 'Entrada', 10.2),
(308, '2022-09-25', 'Ofertas', 'Entrada', 44),
(309, '2022-09-28', 'Ofertas', 'Entrada', 20),
(310, '2022-09-30', 'Ofertas', 'Entrada', 15.55),
(311, '2022-09-25', 'Oferta (Voto)', 'Entrada', 344),
(312, '2022-09-02', 'Oferta (Voluntária)', 'Entrada', 200),
(313, '2022-12-01', 'Saldo Anterior', 'Entrada', -526.17),
(314, '2022-12-07', 'Dízimo', 'Entrada', 200),
(315, '2022-12-11', 'Dízimo', 'Entrada', 120),
(316, '2022-12-14', 'Dízimo', 'Entrada', 120),
(317, '2022-12-16', 'Dízimos', 'Entrada', 440),
(318, '2022-12-18', 'Dízimo', 'Entrada', 100),
(319, '2022-12-24', 'Dízimo', 'Entrada', 180),
(320, '2022-12-22', 'Dízimo', 'Entrada', 150),
(321, '2022-12-25', 'Dízimos', 'Entrada', 450),
(322, '2022-12-28', 'Dízimo', 'Entrada', 120),
(323, '2022-12-30', 'Dízimos', 'Entrada', 270),
(324, '2022-12-04', 'Ofertas', 'Entrada', 59.25),
(325, '2022-12-07', 'Ofertas', 'Entrada', 68),
(326, '2022-12-09', 'Ofertas', 'Entrada', 20),
(327, '2022-12-11', 'Ofertas', 'Entrada', 53),
(328, '2022-12-14', 'Ofertas', 'Entrada', 34.75),
(329, '2022-12-16', 'Ofertas', 'Entrada', 15.25),
(330, '2022-12-18', 'Ofertas', 'Entrada', 95.75),
(331, '2022-12-19', 'Ofertas', 'Entrada', 100),
(332, '2022-12-23', 'Ofertas', 'Entrada', 5),
(333, '2022-12-22', 'Ofertas', 'Entrada', 24.75),
(334, '2022-12-25', 'Ofertas', 'Entrada', 17.75),
(335, '2022-12-28', 'Ofertas', 'Entrada', 55.05),
(336, '2022-12-30', 'Ofertas', 'Entrada', 28),
(337, '2022-12-31', 'Ofertas', 'Entrada', 149),
(338, '2022-12-05', 'Água', 'Saida', 83.62),
(339, '2022-12-17', 'Pastor Gasolina', 'Saida', 500),
(340, '2022-12-20', 'Serviços de Computador', 'Saida', 100),
(341, '2022-12-20', 'Aluguel', 'Saida', 700),
(342, '2022-12-29', 'Ajuda de Custo', 'Saida', 700),
(343, '2022-12-31', 'Luz', 'Saida', 109.3),
(344, '2022-12-31', 'Água', 'Saida', 83.49),
(345, '2022-12-30', 'Devolução - Valor Emprestado', 'Saida', 200),
(346, '2022-12-30', 'Carro de Aplicativo', 'Saida', 41.5),
(347, '2022-12-20', 'Ajuda Beneficente', 'Saida', 46.8),
(348, '2022-12-09', 'Bateria de Violão - 1und', 'Saida', 15),
(349, '2022-12-20', 'Material Telhado', 'Saida', 369),
(350, '2022-12-30', 'Limpeza Mensal Igreja', 'Saida', 150),
(352, '2023-01-01', 'Saldo Anterior', 'Entrada', -811.78),
(353, '2023-01-02', 'Dízimo', 'Entrada', 120),
(354, '2023-01-04', 'Dízimo', 'Entrada', 197.2),
(355, '2023-01-06', 'Dízimo', 'Entrada', 100),
(356, '2023-01-08', 'Dízimo', 'Entrada', 150),
(357, '2023-01-12', 'Dízimos', 'Entrada', 320),
(358, '2023-01-14', 'Dízimo', 'Entrada', 300),
(359, '2023-01-15', 'Dízimos', 'Entrada', 260),
(360, '2023-01-18', 'Dízimo', 'Entrada', 180),
(361, '2023-01-30', 'Dízimo', 'Entrada', 130),
(362, '2023-01-29', 'Dízimo', 'Entrada', 300),
(363, '2023-01-31', 'Dízimos', 'Entrada', 210),
(364, '2023-01-30', 'Dízimo', 'Entrada', 150),
(365, '2023-01-02', 'Ofertas', 'Entrada', 35),
(366, '2023-01-04', 'Ofertas', 'Entrada', 17.65),
(367, '2023-01-06', 'Ofertas', 'Entrada', 74),
(368, '2023-01-08', 'Ofertas', 'Entrada', 27.9),
(369, '2023-01-12', 'Ofertas', 'Entrada', 70),
(370, '2023-01-15', 'Ofertas', 'Entrada', 88),
(371, '2023-01-18', 'Ofertas', 'Entrada', 21.25),
(372, '2023-01-20', 'Ofertas', 'Entrada', 14),
(373, '2023-01-22', 'Ofertas', 'Entrada', 42.45),
(374, '2023-01-25', 'Ofertas', 'Entrada', 32),
(375, '2023-01-27', 'Ofertas', 'Entrada', 47.5),
(376, '2023-01-29', 'Ofertas', 'Entrada', 47.3),
(377, '2023-01-05', 'Valor Emprestado - Helenice', 'Saida', 120),
(378, '2023-01-20', 'Rio', 'Saida', 500),
(379, '2023-01-20', 'Copos Descartáveis', 'Saida', 85.75),
(380, '2023-01-10', 'Gasto com a Confraternização', 'Saida', 291.62),
(381, '2023-01-20', 'Aluguel', 'Saida', 700),
(382, '2023-01-20', 'Ajuda Beneficente Leite - Helenice', 'Saida', 65.88),
(383, '2023-01-23', 'Luz', 'Saida', 161.13),
(384, '2023-01-23', 'Água', 'Saida', 84.06),
(385, '2023-01-30', 'Ajuda de Custo', 'Saida', 700),
(386, '2023-01-25', 'Ajuda de Custo', 'Saida', 100),
(387, '2023-01-29', 'Limpeza Mensal', 'Saida', 150),
(388, '2023-01-29', 'Carro de Aplicativo', 'Saida', 61),
(389, '2023-02-01', 'Saldo Anterior', 'Entrada', -896.97),
(390, '2023-02-03', 'Dízimo', 'Entrada', 30),
(391, '2023-02-05', 'Dízimo', 'Entrada', 100),
(392, '2023-02-08', 'Dízimo', 'Entrada', 130),
(393, '2023-02-09', 'Dízimos', 'Entrada', 525),
(394, '2023-02-12', 'Dízimos', 'Entrada', 300),
(395, '2023-02-17', 'Dízimos', 'Entrada', 280),
(396, '2023-02-28', 'Dízimos', 'Entrada', 540),
(397, '2023-02-01', 'Ofertas', 'Entrada', 50),
(398, '2023-02-03', 'Ofertas', 'Entrada', 15.4),
(399, '2023-02-05', 'Ofertas', 'Entrada', 21),
(400, '2023-02-08', 'Oertas', 'Entrada', 27),
(401, '2023-02-09', 'Ofertas', 'Entrada', 119),
(402, '2023-02-12', 'Ofertas', 'Entrada', 58.3),
(403, '2023-02-15', 'Ofertas', 'Entrada', 22.3),
(404, '2023-02-17', 'Ofertas', 'Entrada', 43.75),
(405, '2023-02-19', 'Ofertas', 'Entrada', 24.8),
(406, '2023-02-22', 'Ofertas', 'Entrada', 65.8),
(407, '2023-02-26', 'Ofertas', 'Entrada', 13.15),
(408, '2023-02-17', 'Preletora', 'Saida', 70),
(409, '2023-02-18', 'Carimbo', 'Saida', 79),
(410, '2023-02-18', 'Revista Dominical', 'Saida', 87),
(411, '2023-02-20', 'Aluguel', 'Saida', 700),
(412, '2023-02-18', 'Rio', 'Saida', 500),
(413, '2023-02-20', 'Serviços de Computador', 'Saida', 100),
(414, '2023-02-28', 'Água', 'Saida', 80.87),
(415, '2023-02-28', 'Luz', 'Saida', 135.21),
(416, '2023-02-28', 'Limpeza Mensal', 'Saida', 150),
(417, '2023-02-07', 'Ajuda Beneficente', 'Saida', 44.28),
(418, '2023-02-22', 'Material Campanha', 'Saida', 19.96),
(419, '2023-02-28', 'Carro de Aplicativo', 'Saida', 47.45),
(420, '2023-02-28', 'Ajuda de Custo', 'Saida', 700),
(421, '2023-02-28', 'Ajuda Preletora RJ', 'Saida', 170),
(422, '2023-03-05', 'Dízimos', 'Entrada', 450),
(423, '2023-03-08', 'Dízimos', 'Entrada', 225),
(424, '2023-03-10', 'Dízimo', 'Entrada', 160),
(425, '2023-03-12', 'Dízimos', 'Entrada', 325),
(426, '2023-03-15', 'Dízimo', 'Entrada', 120),
(427, '2023-03-17', 'Dízimo', 'Entrada', 180),
(428, '2023-03-19', 'Dízimo', 'Entrada', 250),
(429, '2023-03-24', 'Dízimo', 'Entrada', 160),
(430, '2023-03-23', 'Dízimo', 'Entrada', 400),
(431, '2023-03-26', 'Dízimos', 'Entrada', 200),
(432, '2023-03-29', 'Dízimo', 'Entrada', 130),
(433, '2023-03-31', 'Dízimos', 'Entrada', 417),
(434, '2023-03-01', 'Ofertas', 'Entrada', 30.85),
(435, '2023-03-03', 'Ofertas', 'Entrada', 14.95),
(436, '2023-03-05', 'Ofertas', 'Entrada', 27.5),
(437, '2023-03-08', 'Ofertas', 'Entrada', 26.65),
(438, '2023-03-10', 'Ofertas', 'Entrada', 32),
(439, '2023-03-12', 'Ofertas', 'Entrada', 60.5),
(440, '2023-03-15', 'Ofertas', 'Entrada', 49.8),
(441, '2023-03-17', 'Ofertas', 'Entrada', 14.5),
(442, '2023-03-19', 'Ofertas', 'Entrada', 108),
(443, '2023-03-24', 'Ofertas', 'Entrada', 15.95),
(444, '2023-03-22', 'Ofertas', 'Entrada', 16.5),
(445, '2023-03-26', 'Ofertas', 'Entrada', 40),
(446, '2023-03-29', 'Ofertas', 'Entrada', 39),
(447, '2023-03-31', 'Ofertas', 'Entrada', 7),
(448, '2023-03-01', 'Saldo Anterior', 'Entrada', -1415.24),
(449, '2023-03-21', 'Água', 'Saida', 67.36),
(450, '2023-03-21', 'Luz', 'Saida', 200.38),
(451, '2023-03-20', 'Aluguel', 'Saida', 700),
(452, '2023-03-26', 'Gasto com Material de Limpeza', 'Saida', 25.7),
(453, '2023-03-27', 'Ajuda de Custo', 'Saida', 700),
(454, '2023-03-01', 'Gasto com Alimentação RJ', 'Saida', 34),
(455, '2023-03-30', 'Devolução Valor Emprestado', 'Saida', 515),
(456, '2023-03-30', 'RJ', 'Saida', 400),
(457, '2023-03-30', 'Limpeza Mensal', 'Saida', 150),
(458, '2023-03-18', 'Ajuda de Custo', 'Saida', 100),
(459, '2023-03-30', 'Carro de Aplicativo', 'Saida', 67),
(460, '2023-04-01', 'Saldo Anterior', 'Entrada', -874.48),
(461, '2023-04-09', 'Dízimos', 'Entrada', 250),
(462, '2023-04-11', 'Dízimo', 'Entrada', 101.5),
(463, '2023-04-14', 'Dízimo', 'Entrada', 200),
(464, '2023-04-12', 'Dízimos', 'Entrada', 200),
(465, '2023-04-14', 'Dízimos', 'Entrada', 485),
(466, '2023-04-15', 'Dízimo', 'Entrada', 100),
(467, '2023-04-17', 'Dízimo', 'Entrada', 150),
(468, '2023-04-19', 'Dízimos', 'Entrada', 245.56),
(469, '2023-04-28', 'Dízimos', 'Entrada', 265),
(470, '2023-04-30', 'Dízimos', 'Entrada', 280),
(471, '2023-04-02', 'Ofertas', 'Entrada', 25.5),
(472, '2023-04-05', 'Ofertas', 'Entrada', 16),
(473, '2023-04-07', 'Ofertas', 'Entrada', 12),
(474, '2023-04-09', 'Ofertas', 'Entrada', 14.5),
(475, '2023-04-12', 'Ofertas', 'Entrada', 49.6),
(476, '2023-04-14', 'Ofertas', 'Entrada', 10),
(477, '2023-04-16', 'Ofertas', 'Entrada', 101.5),
(478, '2023-04-19', 'Ofertas', 'Entrada', 64.75),
(479, '2023-04-23', 'Ofertas', 'Entrada', 27),
(480, '2023-04-21', 'Ofertas', 'Entrada', 7),
(481, '2023-04-26', 'Ofertas', 'Entrada', 18),
(482, '2023-04-30', 'Ofertas', 'Entrada', 29),
(483, '2023-04-08', 'Material Ceia + Copo', 'Saida', 20.96),
(484, '2023-04-18', 'Azeite Campanha', 'Saida', 42),
(485, '2023-04-20', 'Aluguel', 'Saida', 700),
(486, '2023-04-18', 'Ajuda de Custo', 'Saida', 100),
(487, '2023-04-24', 'Água', 'Saida', 67.38),
(488, '2023-04-24', 'Luz', 'Saida', 195.49),
(489, '2023-04-28', 'Limpeza Mensal', 'Saida', 150),
(490, '2023-04-15', 'Ajuda RJ', 'Saida', 450),
(491, '2023-04-30', 'Ajuda de Custo', 'Saida', 750),
(492, '2023-04-30', 'Gasto com Carro de Aplicativo', 'Saida', 74.15),
(493, '2023-04-09', 'Ajuda Beneficente + Material Ceia', 'Saida', 78.42),
(494, '2023-04-25', 'Material Papelaria', 'Saida', 72.8);