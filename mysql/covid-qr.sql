-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:3306
-- 產生時間： 2021 年 03 月 19 日 13:43
-- 伺服器版本： 10.3.25-MariaDB-0ubuntu0.20.04.1
-- PHP 版本： 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `covid-qr`
--

-- --------------------------------------------------------

--
-- 資料表結構 `activity`
--

CREATE TABLE `activity` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '流水號',
  `name` varchar(100) NOT NULL COMMENT '活動名稱',
  `type` set('1','2') NOT NULL DEFAULT '1' COMMENT '1常設2短期',
  `qrduration` int(10) UNSIGNED DEFAULT 1 COMMENT 'QRCode有效日期',
  `closedate` date DEFAULT NULL COMMENT '結束日期',
  `creator` int(11) NOT NULL COMMENT '建立者',
  `createdate` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建立時間',
  `openflag` set('0','1') NOT NULL DEFAULT '0' COMMENT '公開旗標',
  `ps` text DEFAULT NULL COMMENT '備註事項'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='實名制活動表';

-- --------------------------------------------------------

--
-- 資料表結構 `scanrecord`
--

CREATE TABLE `scanrecord` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '流水號',
  `aid` int(10) UNSIGNED NOT NULL COMMENT '活動編號',
  `scandate` datetime NOT NULL DEFAULT current_timestamp() COMMENT '掃瞄時間',
  `fullcode` varchar(40) NOT NULL COMMENT '掃瞄碼',
  `uniqid` varchar(13) NOT NULL COMMENT '訪客唯一碼'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='掃瞄紀錄';

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '流水號',
  `name` varchar(20) NOT NULL COMMENT '帳號',
  `pw` varchar(32) NOT NULL COMMENT '密碼',
  `realname` varchar(100) NOT NULL COMMENT '真實姓名',
  `office` varchar(50) NOT NULL COMMENT '單位',
  `email` varchar(100) NOT NULL COMMENT '電子郵件',
  `tel` varchar(20) DEFAULT NULL COMMENT '電話',
  `createdate` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建立時間',
  `privilege` set('0','1','2') NOT NULL DEFAULT '0' COMMENT '權限0普通1管理2最高',
  `status` set('0','1') NOT NULL DEFAULT '1' COMMENT '狀態0失效1有效'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理權限';

-- --------------------------------------------------------

--
-- 資料表結構 `vistor`
--

CREATE TABLE `vistor` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '流水號',
  `aid` int(10) UNSIGNED NOT NULL COMMENT '活動㴜號',
  `realname` varchar(50) DEFAULT NULL COMMENT '訪客姓名',
  `tel` varchar(20) DEFAULT NULL COMMENT '手機電話',
  `email` varchar(100) DEFAULT NULL COMMENT '電子郵件',
  `uniqid` varchar(13) NOT NULL COMMENT '唯一碼',
  `createdate` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建立時間',
  `expiredate` date DEFAULT NULL COMMENT '過期日期',
  `deadtime` date DEFAULT NULL COMMENT '刪除日期',
  `num` int(10) UNSIGNED DEFAULT 0 COMMENT '同行人數'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='訪客表';

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `scanrecord`
--
ALTER TABLE `scanrecord`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `vistor`
--
ALTER TABLE `vistor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`),
  ADD KEY `tel` (`tel`),
  ADD KEY `uniqid` (`uniqid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '流水號';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `scanrecord`
--
ALTER TABLE `scanrecord`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '流水號';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '流水號';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `vistor`
--
ALTER TABLE `vistor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '流水號';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
