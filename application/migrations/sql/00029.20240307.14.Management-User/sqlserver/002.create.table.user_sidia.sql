USE [master]
  IF NOT EXISTS(SELECT * FROM sysdatabases WHERE name = 'd_replication')
  BEGIN
  CREATE DATABASE [d_replication] COLLATE SQL_Latin1_General_CP1_CI_AS
  END
  USE [d_replication]
  IF NOT EXISTS ( SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[t_user_sidia_notin]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
  BEGIN
  CREATE TABLE [t_user_sidia_notin] (
  	[FC_BRANCH] [char] (6) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_NIK] [varchar] (16) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_USERID] [char] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_USERSNAME] [varchar] (15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_USERLNAME] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_PASSWORD] [char] (15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_GROUPUSER] [char] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_LEVEL] [varchar] (1) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_LOCATION] [varchar] (2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_DIVISI] [varchar] (2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_BRAND] [varchar] (2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_HOLD] [char] (3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_LOCKUSR] [char] (3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_LOGIN] [char] (3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FD_EXPDATE] [datetime] NULL ,
  	[FD_TIMELOCK] [datetime] NULL ,
  	[FC_EMAIL] [varchar] (100) NULL ,
  	[FC_STATUS] [char] (1) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[fd_explocking] [datetime] NULL ,
  	[fd_retrydate] [datetime] NULL ,
  	[fc_sendstatus] [char] (1) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_CUSTCODE] [char] (6) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_DEPCODE] [char] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_SUPERVISORID] [char] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_MANAGERID] [char] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FD_INPUTDATE] [datetime] NULL ,
    [FC_INPUTBY] [varchar] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [FD_UPDATEDATE] [datetime] NULL ,
    [FC_UPDATEBY] [varchar] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	CONSTRAINT [t_user_sidia_notin_pkey] PRIMARY KEY
  	(
  		[FC_BRANCH],
  		[FC_USERID]
  	)
  ) ON [PRIMARY]
  END
IF NOT EXISTS ( SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[t_user_sidia]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
  BEGIN
  CREATE TABLE [t_user_sidia] (
  	[FC_BRANCH] [char] (6) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_NIK] [varchar] (16) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_USERID] [char] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_USERSNAME] [varchar] (15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_USERLNAME] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_PASSWORD] [char] (15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_GROUPUSER] [char] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
  	[FC_LEVEL] [varchar] (1) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_LOCATION] [varchar] (2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_DIVISI] [varchar] (2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_BRAND] [varchar] (2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_HOLD] [char] (3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_LOCKUSR] [char] (3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_LOGIN] [char] (3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FD_EXPDATE] [datetime] NULL ,
  	[FD_TIMELOCK] [datetime] NULL ,
  	[FC_EMAIL] [varchar] (100) NULL ,
  	[FC_STATUS] [char] (1) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[fd_explocking] [datetime] NULL ,
  	[fd_retrydate] [datetime] NULL ,
  	[fc_sendstatus] [char] (1) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_CUSTCODE] [char] (6) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_DEPCODE] [char] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_SUPERVISORID] [char] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FC_MANAGERID] [char] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	[FD_INPUTDATE] [datetime] NULL ,
    [FC_INPUTBY] [varchar] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [FD_UPDATEDATE] [datetime] NULL ,
    [FC_UPDATEBY] [varchar] (8) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
  	CONSTRAINT [t_user_sidia_pkey] PRIMARY KEY
  	(
  		[FC_BRANCH],
  		[FC_USERID]
  	)
  )
  END






