/*
SELECT 
    *
FROM
    pants,
    items,
    picksout,
    customerAccount
WHERE
    serialNumber = pantsSN
        AND serialNumber = pickserialNumber
        AND pantsSN = 0001
        AND pickUsername = username
        AND username = 'kschlaak1';
*/

/*
SELECT 
    customerAccount.username
FROM
    customerAccount
WHERE
    gender = 'f';
*/

/*
SELECT
	*
FROM
	customerAccount, payment, transaction
WHERE
	customerAccount.username=payment.payUsername AND cardNumber=transCardNumber AND transaction.transTotal > 30;
*/

/*
SELECT 
    customerAccount.Fname, customerAccount.Lname, picksout.amountPicked
FROM
    customerAccount,
    picksout
WHERE
    pickUsername = username
        AND amountPicked > 1;
        */

/*
SELECT 
    customerAccount.username, items.brand
FROM
    customerAccount,
    picksout,
    items
WHERE
    username = pickUsername
        AND pickSerialNumber = serialNumber
        AND serialNumber = '2121';
*/

SELECT 
    customerAccount.username, returns.returnReason
FROM
    customerAccount,
    returns
WHERE
    username = retUsername