-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 06 月 26 日 10:43
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `thinkphp_init`
--

-- --------------------------------------------------------

--
-- 表的结构 `think_admin`
--

CREATE TABLE IF NOT EXISTS `think_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `adminname` char(60) NOT NULL COMMENT '管理员用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(60) NOT NULL COMMENT '邮箱',
  `gender` tinyint(1) NOT NULL COMMENT '性别：1男、2女',
  `tel` varchar(11) NOT NULL COMMENT '手机号',
  `pic` varchar(255) NOT NULL COMMENT '头像的id，在resource表中',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：正常 2：删除',
  `login_time` int(11) NOT NULL COMMENT '最后登录时间',
  `login_ip` char(30) NOT NULL COMMENT '最后登录ip',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_name` (`adminname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- 表的结构 `think_menu`
--

CREATE TABLE IF NOT EXISTS `think_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL COMMENT '标题',
  `icon` varchar(125) NOT NULL COMMENT '图标',
  `module_name` varchar(125) NOT NULL COMMENT '模块名',
  `controller_name` varchar(125) NOT NULL COMMENT '控制器名',
  `action_name` varchar(125) NOT NULL COMMENT '方法名',
  `param` varchar(125) NOT NULL COMMENT '参数',
  `replace` varchar(125) NOT NULL COMMENT '替换',
  `remark` varchar(255) NOT NULL COMMENT '介绍',
  `pid` int(11) NOT NULL COMMENT '上级id',
  `path` varchar(255) NOT NULL DEFAULT '0' COMMENT 'pid层级',
  `level` tinyint(1) unsigned NOT NULL COMMENT '层级',
  `view_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序，越大越在前',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示 1：显示',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1：正常 2：删除',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='rbac 菜单、节点表' AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- 表的结构 `think_resource`
--

CREATE TABLE IF NOT EXISTS `think_resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` char(255) NOT NULL COMMENT '上传文件的原名',
  `type` char(64) NOT NULL COMMENT '上传文件的MIME类型',
  `size` char(64) NOT NULL COMMENT '大小，单位字节',
  `ext` char(64) NOT NULL COMMENT '后缀名',
  `savename` char(64) NOT NULL COMMENT '保存后的名字',
  `savepath` char(64) NOT NULL COMMENT '保存的路径',
  `add_time` int(11) NOT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='上传资源表，如photo，file' AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- 表的结构 `think_role`
--

CREATE TABLE IF NOT EXISTS `think_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：正常 2：删除',
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `think_role_admin`
--

CREATE TABLE IF NOT EXISTS `think_role_admin` (
  `role_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色和用户的关系表';

-- --------------------------------------------------------

--
-- 表的结构 `think_role_menu`
--

CREATE TABLE IF NOT EXISTS `think_role_menu` (
  `role_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(125) NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色和节点菜单的关系表';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
