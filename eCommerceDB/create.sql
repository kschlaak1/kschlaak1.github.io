USE eCommerceDB;

-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema eCommerceDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `CustomerAccount`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CustomerAccount` ;

CREATE TABLE IF NOT EXISTS `CustomerAccount` (
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NULL,
  `DOB` DATE NULL,
  `gender` CHAR NULL,
  `email` VARCHAR(45) NULL,
  `Fname` VARCHAR(45) NULL,
  `Lname` VARCHAR(45) NULL,
  `phone` VARCHAR(45) NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Payment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Payment` ;

CREATE TABLE IF NOT EXISTS `Payment` (
  `cardNumber` VARCHAR(16) NOT NULL,
  `CVN` INT NULL,
  `expDate` DATE NULL,
  `cardType` VARCHAR(45) NULL,
  `cardName` VARCHAR(45) NULL,
  `payUsername` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`cardNumber`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Returns`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Returns` ;

CREATE TABLE IF NOT EXISTS `Returns` (
  `RRN` INT NOT NULL,
  `returnDate` DATE NULL,
  `returnReason` VARCHAR(90) NULL,
  `returnItem` VARCHAR(45) NULL,
  `retUsername` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`RRN`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Items` ;

CREATE TABLE IF NOT EXISTS `Items` (
  `serialNumber` INT NOT NULL,
  `price` DECIMAL(10,2) NULL,
  `brand` VARCHAR(45) NULL,
  `itemQuantity` INT NULL,
  `stockDate` DATE NULL,
  `inventoryID` INT NOT NULL,
  `sessionID` INT NOT NULL,
  PRIMARY KEY (`serialNumber`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Transaction`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Transaction` ;

CREATE TABLE IF NOT EXISTS `Transaction` (
  `sessionID` INT NOT NULL,
  `transTotal` DECIMAL(10,2) NULL,
  `cart` VARCHAR(45) NULL,
  `transCardNumber` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`sessionID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Order` ;

CREATE TABLE IF NOT EXISTS `Order` (
  `OrderID` INT NOT NULL,
  `orderTotal` DECIMAL(10,2) NULL,
  `sentDate` DATE NULL,
  `orSessionID` INT NOT NULL,
  `orTrackingNumber` INT NOT NULL,
  PRIMARY KEY (`OrderID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Shipping`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Shipping` ;

CREATE TABLE IF NOT EXISTS `Shipping` (
  `trackingNumber` INT NOT NULL,
  `shippedDate` DATE NULL,
  `currentLocation` VARCHAR(45) NULL,
  `shipInventoryID` INT NOT NULL,
  `processDate` DATE NULL,
  PRIMARY KEY (`trackingNumber`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Inventory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Inventory` ;

CREATE TABLE IF NOT EXISTS `Inventory` (
  `inventoryID` INT NOT NULL,
  `inventoryInvoice` VARCHAR(45) NULL,
  `totalInventory` INT NULL,
  PRIMARY KEY (`inventoryID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Manufacturer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Manufacturer` ;

CREATE TABLE IF NOT EXISTS `Manufacturer` (
  `manufacturerInvoice` VARCHAR(45) NOT NULL,
  `manInventoryID` INT NOT NULL,
  `supplyDate` DATE NULL,
  PRIMARY KEY (`manufacturerInvoice`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Pants`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Pants` ;

CREATE TABLE IF NOT EXISTS `Pants` (
  `pantsSN` INT NOT NULL,
  `pantsSize` INT NULL,
  `pantsCut` VARCHAR(45) NULL,
  PRIMARY KEY (`pantsSN`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Shoes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Shoes` ;

CREATE TABLE IF NOT EXISTS `Shoes` (
  `shoesSN` INT NOT NULL,
  `shoeSize` INT NULL,
  `shoeStyle` VARCHAR(45) NULL,
  PRIMARY KEY (`shoesSN`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Tshirt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Tshirt` ;

CREATE TABLE IF NOT EXISTS `Tshirt` (
  `tshirtSN` INT NOT NULL,
  `shirtSize` INT NULL,
  PRIMARY KEY (`tshirtSN`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jacket`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jacket` ;

CREATE TABLE IF NOT EXISTS `Jacket` (
  `jacketSN` INT NOT NULL,
  `jacketSize` INT NULL,
  PRIMARY KEY (`jacketSN`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PicksOut`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PicksOut` ;

CREATE TABLE IF NOT EXISTS `PicksOut` (
  `pickSerialNumber` INT NOT NULL,
  `pickUsername` VARCHAR(45) NOT NULL,
  `amountPicked` INT NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ShippingAddress`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ShippingAddress` ;

CREATE TABLE IF NOT EXISTS `ShippingAddress` (
  `username` VARCHAR(45) NOT NULL,
  `shStreetNumber` INT NULL,
  `shStreetName` VARCHAR(45) NULL,
  `shCity` VARCHAR(45) NULL,
  `shState` VARCHAR(45) NULL,
  `shZip` INT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BillingAddress`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BillingAddress` ;

CREATE TABLE IF NOT EXISTS `BillingAddress` (
  `cardNumber` VARCHAR(16) NOT NULL,
  `bStreetNumber` INT NULL,
  `bStreetName` VARCHAR(45) NULL,
  `bCity` VARCHAR(45) NULL,
  `bState` VARCHAR(45) NULL,
  `bZip` INT NULL,
  PRIMARY KEY (`cardNumber`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WareHouseAddress`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WareHouseAddress` ;

CREATE TABLE IF NOT EXISTS `WareHouseAddress` (
  `trackingNumber` INT NOT NULL,
  `whStreetNumber` INT NULL,
  `whStreetName` VARCHAR(45) NULL,
  `whCity` VARCHAR(45) NULL,
  `whState` VARCHAR(45) NULL,
  `whZip` INT NULL,
  PRIMARY KEY (`trackingNumber`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
