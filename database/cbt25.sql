-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 28, 2025 at 05:19 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbt25`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `auth` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(1028) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `level` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`id`, `username`, `password`, `nama`, `level`) VALUES
(1, 'K01030098', '243778a3e45875976f29ec9d19450bb2', 'Administrator', 'admin'),
(2, 'K01030098-AKL', '30c87aa2df2fd8fc61079ffc1f10e6cc', 'ADMINISTRATOR AKL', 'adminakl'),
(3, 'K01030098-PM', '30c87aa2df2fd8fc61079ffc1f10e6cc', 'ADMINISTRATOR PM', 'adminbdp'),
(4, 'K01030098-MPLB', '30c87aa2df2fd8fc61079ffc1f10e6cc', 'ADMINISTRATOR MPLB', 'adminotkp'),
(5, 'K01030098-TJKT', '30c87aa2df2fd8fc61079ffc1f10e6cc', 'ADMINISTRATOR TJKT', 'admintkj'),
(6, 'K01030098-DKV', '30c87aa2df2fd8fc61079ffc1f10e6cc', 'ADMINISTRATOR DKV', 'admindkv');

-- --------------------------------------------------------

--
-- Table structure for table `a_jurusan`
--

CREATE TABLE `a_jurusan` (
  `id` int(11) NOT NULL,
  `kode` varchar(8) NOT NULL,
  `jurusan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_jurusan`
--

INSERT INTO `a_jurusan` (`id`, `kode`, `jurusan`) VALUES
(101, 'AKL', 'AKUTANSI KEUANGAN LEMBAGA'),
(202, 'PM', 'PEMASARAN'),
(303, 'MPLB', 'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS'),
(404, 'TJKT', 'TEKNIK JARINGAN KOMPUTER DAN TELEKOMUNIKASI'),
(505, 'DKV', 'DESAIN KOMUNIKASI VISUAL');

-- --------------------------------------------------------

--
-- Table structure for table `a_kelas`
--

CREATE TABLE `a_kelas` (
  `id` int(11) NOT NULL,
  `kode` varchar(8) NOT NULL,
  `kelas` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_kelas`
--

INSERT INTO `a_kelas` (`id`, `kode`, `kelas`) VALUES
(10012526, 'AKL', 'X AKL 1'),
(10022526, 'AKL', 'X AKL 2'),
(10032526, 'PM', 'X PM'),
(10042526, 'MPLB', 'X MPLB 1'),
(10052526, 'MPLB', 'X MPLB 2'),
(10062526, 'TJKT', 'X TJKT 1'),
(10072526, 'TJKT', 'X TJKT 2'),
(10082526, 'TJKT', 'X TJKT 3'),
(10092526, 'TJKT', 'X TJKT 4'),
(10102526, 'DKV', 'X DKV'),
(10112526, 'AKL', 'XI AKL 1'),
(10122526, 'AKL', 'XI AKL 2'),
(10132526, 'PM', 'XI PM '),
(10142526, 'MPLB', 'XI MPLB 1'),
(10152526, 'MPLB', 'XI MPLB 2'),
(10162526, 'TJKT', 'XI TJKT 1'),
(10172526, 'TJKT', 'XI TJKT 2'),
(10182526, 'TJKT', 'XI TJKT 3'),
(10192526, 'DKV', 'XI DKV'),
(10202526, 'AKL', 'XII AKL 1'),
(10212526, 'AKL', 'XII AKL 2'),
(10222526, 'PM', 'XII PM '),
(10232526, 'MPLB', 'XII MPLB 1'),
(10242526, 'MPLB', 'XII MPLB 2'),
(10252526, 'TJKT', 'XII TJKT 1'),
(10262526, 'TJKT', 'XII TJKT 2'),
(10272526, 'TJKT', 'XII TJKT 3'),
(10282526, 'DKV', 'XII DKV');

-- --------------------------------------------------------

--
-- Table structure for table `a_mapel`
--

CREATE TABLE `a_mapel` (
  `id_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nama_mapel` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_mapel`
--

INSERT INTO `a_mapel` (`id_mapel`, `id_kelas`, `nama_mapel`, `timestamp`) VALUES
(1001, 10102526, 'AGAMA ISLAM ( X DKV )', '2025-09-28 14:54:28'),
(1002, 10102526, 'AGAMA KRISTEN ( X DKV )', '2025-09-28 14:54:28'),
(1003, 10102526, 'B.INDONESIA ( X DKV )', '2025-09-28 14:54:28'),
(1004, 10102526, 'MTK ( X DKV )', '2025-09-28 14:54:28'),
(1005, 10102526, 'JEPANG ( X DKV )', '2025-09-28 14:54:28'),
(1006, 10102526, 'B. INGGRIS ( X DKV )', '2025-09-28 14:54:28'),
(1007, 10102526, 'PEND. PANCASILA ( X DKV )', '2025-09-28 14:54:28'),
(1008, 10102526, 'SEJARAH ( X DKV )', '2025-09-28 14:54:28'),
(1009, 10102526, 'INFORMATIKA ( X DKV )', '2025-09-28 14:54:28'),
(1010, 10102526, 'PROJEK IPAS ( X DKV )', '2025-09-28 14:54:28'),
(1011, 10102526, 'PJOK ( X DKV )', '2025-09-28 14:54:28'),
(1012, 10102526, 'SENI BUDAYA ( X DKV )', '2025-09-28 14:54:28'),
(1013, 10102526, 'E.1,2,3,4 ( X DKV )', '2025-09-28 14:54:28'),
(1014, 10102526, 'CODING ( X DKV )', '2025-09-28 14:54:28'),
(1015, 10102526, 'E.6,8,9 ( X DKV )', '2025-09-28 14:54:28'),
(1016, 10102526, 'E.5,7 ( X DKV )', '2025-09-28 14:54:28'),
(1017, 10192526, 'AGAMA ISLAM ( XI DKV )', '2025-09-28 14:54:28'),
(1018, 10192526, 'AGAMA KRISTEN ( XI DKV )', '2025-09-28 14:54:28'),
(1019, 10192526, 'B. IND ( XI DKV )', '2025-09-28 14:54:28'),
(1020, 10192526, 'MTK ( XI DKV )', '2025-09-28 14:54:28'),
(1021, 10192526, 'JEPANG ( XI DKV )', '2025-09-28 14:54:28'),
(1022, 10192526, 'B. INGGRIS ( XI DKV )', '2025-09-28 14:54:28'),
(1023, 10192526, 'PEND. PANCASILA ( XI DKV )', '2025-09-28 14:54:28'),
(1024, 10192526, 'PKK ( XI DKV )', '2025-09-28 14:54:28'),
(1025, 10192526, 'F.3 ( XI DKV )', '2025-09-28 14:54:28'),
(1026, 10192526, 'F.2 ( XI DKV )', '2025-09-28 14:54:28'),
(1027, 10192526, 'PJOK ( XI DKV )', '2025-09-28 14:54:28'),
(1028, 10192526, 'SEJARAH ( XI DKV )', '2025-09-28 14:54:28'),
(1029, 10192526, 'CODING ( XI DKV )', '2025-09-28 14:54:28'),
(1030, 10192526, 'F.4 ( XI DKV )', '2025-09-28 14:54:28'),
(1031, 10192526, 'F.1,5 ( XI DKV )', '2025-09-28 14:54:28'),
(1032, 10282526, 'AGAMA ISLAM ( XII DKV )', '2025-09-28 14:54:28'),
(1033, 10282526, 'AGAMA KRISTEN ( XII DKV )', '2025-09-28 14:54:28'),
(1034, 10282526, 'B. IND ( XII DKV )', '2025-09-28 14:54:28'),
(1035, 10282526, 'MTK ( XII DKV )', '2025-09-28 14:54:28'),
(1036, 10282526, 'JEPANG ( XII DKV )', '2025-09-28 14:54:28'),
(1037, 10282526, 'B. INGGRIS ( XII DKV )', '2025-09-28 14:54:28'),
(1038, 10282526, 'PEND. PANCASILA ( XII DKV )', '2025-09-28 14:54:28'),
(1039, 10282526, 'PKK ( XII DKV )', '2025-09-28 14:54:28'),
(1040, 10282526, 'F.2 ( XII DKV )', '2025-09-28 14:54:28'),
(1041, 10282526, 'F.3 ( XII DKV )', '2025-09-28 14:54:28'),
(1042, 10282526, 'F.4 ( XII DKV )', '2025-09-28 14:54:28'),
(1043, 10282526, 'F.5 ( XII DKV )', '2025-09-28 14:54:28'),
(1044, 10282526, 'CODING ( XII DKV )', '2025-09-28 14:54:28'),
(1045, 10282526, 'F.1 ( XII DKV )', '2025-09-28 14:54:28');

-- --------------------------------------------------------

--
-- Table structure for table `a_setting`
--

CREATE TABLE `a_setting` (
  `id_setting` int(12) NOT NULL,
  `nama_sekolah` varchar(128) NOT NULL,
  `alamat_sekolah` varchar(1024) NOT NULL,
  `npsn` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_setting`
--

INSERT INTO `a_setting` (`id_setting`, `nama_sekolah`, `alamat_sekolah`, `npsn`) VALUES
(1001, 'SMK COMPUTER BASED TEST', 'JL. JAKARTA BARAT', '00001');

-- --------------------------------------------------------

--
-- Table structure for table `a_siswa`
--

CREATE TABLE `a_siswa` (
  `id` int(11) NOT NULL,
  `no_peserta` varchar(128) NOT NULL,
  `nama_siswa` varchar(512) NOT NULL,
  `kelas` varchar(16) NOT NULL,
  `jurusan` varchar(8) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_jurusan`
--
ALTER TABLE `a_jurusan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `a_kelas`
--
ALTER TABLE `a_kelas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `a_mapel`
--
ALTER TABLE `a_mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `a_setting`
--
ALTER TABLE `a_setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `a_siswa`
--
ALTER TABLE `a_siswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth`
--
ALTER TABLE `auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `a_jurusan`
--
ALTER TABLE `a_jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=506;

--
-- AUTO_INCREMENT for table `a_kelas`
--
ALTER TABLE `a_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10282527;

--
-- AUTO_INCREMENT for table `a_setting`
--
ALTER TABLE `a_setting`
  MODIFY `id_setting` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
