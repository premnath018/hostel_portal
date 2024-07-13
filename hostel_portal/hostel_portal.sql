-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.31 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for hostel_portal
CREATE DATABASE IF NOT EXISTS `hostel_portal` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `hostel_portal`;

-- Dumping structure for table hostel_portal.informations
CREATE TABLE IF NOT EXISTS `informations` (
  `staff_id` varchar(15) NOT NULL,
  `name` varchar(40) NOT NULL,
  `department` varchar(20) NOT NULL,
  `desigination` varchar(20) NOT NULL,
  `hostel` varchar(15) DEFAULT NULL,
  `room_no` int DEFAULT NULL,
  `floor` enum('G','1','2','3') DEFAULT NULL,
  `responsible` varchar(15) DEFAULT NULL,
  `phone` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Hostel staff and wardens details';

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.likes
CREATE TABLE IF NOT EXISTS `likes` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `post_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `action` enum('0','1') NOT NULL COMMENT '0 -> Not Liked and 1 -> Liked',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.master_category
CREATE TABLE IF NOT EXISTS `master_category` (
  `id` int NOT NULL,
  `category_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.master_resource
CREATE TABLE IF NOT EXISTS `master_resource` (
  `resource_id` bigint NOT NULL AUTO_INCREMENT,
  `label` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sort_id` int DEFAULT NULL,
  `status` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '0 - Not active, 1 - Active, 2 - Deleted',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`resource_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.master_users
CREATE TABLE IF NOT EXISTS `master_users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `email_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('0','1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `resource` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.room_query
CREATE TABLE IF NOT EXISTS `room_query` (
  `query_id` bigint NOT NULL AUTO_INCREMENT,
  `reported_by` bigint NOT NULL COMMENT 'Contain the user id (i.e Student DB ib)',
  `hostel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `room_no` int NOT NULL,
  `date` date NOT NULL,
  `problem_category` enum('1','2','3','4','5','6') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '''1'' -> Electricity , ''2'' -> Plumbing , ''3'' -> Carpentary, ''4'' -> Cleaning, ''5'' -> Civil Work, ''6'' -> Others',
  `problem_statement` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `query_photo_link` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remarks` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT 'Remarks about the resolution',
  `rating` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '0 -> Not Satisfied, 1 -> Satisfied',
  `status` enum('0','1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0' COMMENT '0 -> Rejected, 1 -> Request, 2 -> Request Accepted, 3 -> Reques Completed , 4 -> Closed',
  `task_id` bigint DEFAULT NULL,
  `task_status` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '0 -> Queued 1 -> Assigned For Work (Initiated) 2 -> Completed',
  KEY `query_id` (`query_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.staff_info
CREATE TABLE IF NOT EXISTS `staff_info` (
  `s_id` bigint NOT NULL AUTO_INCREMENT,
  `s_rollno` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `role` enum('1','2','3','4','5') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `category` enum('1','2','3','4','5','6') DEFAULT NULL,
  UNIQUE KEY `unique_email` (`email`,`s_rollno`) USING BTREE,
  KEY `s_id` (`s_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.students_info
CREATE TABLE IF NOT EXISTS `students_info` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `rollno` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `year` enum('I','II','III','IV') NOT NULL,
  `hostel` varchar(15) NOT NULL,
  `room_no` int NOT NULL,
  `floor` enum('G','1','2','3') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  UNIQUE KEY `unique_email_rollno` (`email`,`rollno`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.suggestions
CREATE TABLE IF NOT EXISTS `suggestions` (
  `sg_id` bigint NOT NULL AUTO_INCREMENT,
  `reported_by` varchar(15) NOT NULL,
  `hostel` varchar(20) NOT NULL,
  `for_place` enum('1','2','3','4','5','6') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `suggestion_title` varchar(50) NOT NULL,
  `sg_descrip` varchar(150) NOT NULL,
  `sg_photo_link` varchar(150) DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`sg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table hostel_portal.suggestions_tasks
CREATE TABLE IF NOT EXISTS `suggestions_tasks` (
  `task_id` bigint NOT NULL AUTO_INCREMENT,
  `sg_id` bigint NOT NULL,
  `reported_by` bigint NOT NULL,
  `hostel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `for_place` enum('1','2','3','4','5','6') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `suggestion_title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `task_date` date NOT NULL,
  `category` enum('1','2','3','4','5','6') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `task_title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `task_descrip` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('0','1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0' COMMENT '0 -> Rejected, 1 -> Request, 2 -> Request Accepted, 3 -> Reques Completed , 4 -> Closed',
  `task_status` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT '0 -> Queued 1 -> Assigned For Work (Initiated) 2 -> Completed',
  PRIMARY KEY (`task_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
