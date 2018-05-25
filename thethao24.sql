/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100131
 Source Host           : localhost:3306
 Source Schema         : thethao24

 Target Server Type    : MySQL
 Target Server Version : 100131
 File Encoding         : 65001

 Date: 25/05/2018 15:07:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `salt` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_active` tinyint(255) NULL DEFAULT NULL,
  `is_super` tinyint(255) NULL DEFAULT NULL,
  `is_system` tinyint(255) NULL DEFAULT NULL,
  `private_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sms_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `group_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `actions` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `updated_by` datetime(0) NULL DEFAULT NULL,
  `pass_updated_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'Doan Van Pham', 'doanpv', NULL, 'e3911d5888fb6323cea87473ef7b8c5c42e5847b482b15a272948ab93dfb9075', 'doanpv@dcv.vn', 1, 0, 1, '2016', 'dcv', NULL, '0', '', NULL, '', '0000-00-00 00:00:00', '2018-05-22 14:19:33', '2018-05-22 14:19:33', '2018-05-25 11:33:27');
INSERT INTO `admin` VALUES (2, 'Pham Van Thao123', 'thaopv', NULL, 'cd6abf19b8d964243e53a4f6cd3057b9446706c7b9df4e55163430f4a31f3143', 'thao@123.com', 0, 0, 0, '2016', 'dcv', NULL, '0', '', '', '1', '0000-00-00 00:00:00', NULL, '2018-05-25 11:44:34', '2018-05-25 11:57:35');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news`  (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `summary` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_active` int(11) NULL DEFAULT NULL,
  `topic_id` int(255) NULL DEFAULT NULL,
  `view_counter` int(255) NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `image_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for news_topic
-- ----------------------------
DROP TABLE IF EXISTS `news_topic`;
CREATE TABLE `news_topic`  (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `image_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_active` int(255) NULL DEFAULT NULL,
  `news` varchar(0) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `language` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of news_topic
-- ----------------------------
INSERT INTO `news_topic` VALUES (1, 'Nhận đinh', 'upload/ckfinder/images/Untitled.png', 1, NULL, NULL, '5b03c4856f94048c29000030', NULL, 'en', '2018-05-23 09:47:30', '2018-05-25 15:01:17');
INSERT INTO `news_topic` VALUES (2, 'Tip', 'upload/ckfinder/images/Untitled.png', 1, NULL, NULL, '5b03c4856f94048c29000030', NULL, 'en', '2018-05-23 09:47:48', '2018-05-23 09:47:48');
INSERT INTO `news_topic` VALUES (3, 'Tin tức', 'upload/ckfinder/images/Untitled.png', 1, NULL, NULL, '5b03c4856f94048c29000030', NULL, 'en', '2018-05-23 09:47:48', '2018-05-23 09:47:48');

SET FOREIGN_KEY_CHECKS = 1;
