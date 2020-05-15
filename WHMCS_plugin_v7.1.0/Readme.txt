Descriptions:
=============
This Webcash API is for WHMCS ver 4.1.0. and above



Installation:
=============

1. Open the "wccallback.php" and look for line 10 and Check the following :


$yourdomain = "https://****/clientarea.php?action=invoices";

replace **** with your domain name


2. Open the "webcash.php" and look for line 73 and Check the following :

<INPUT type="hidden" name="ord_returnURL" value="https://****/modules/gateways/callback/wccallback.php">

replace **** with your domain name


3. Copy the file webcash.php   to /modules/gateways

4. Copy the file wccallback.php to /modules/gateways/callback

5. Log in to WHMCS admin backend

6. Go to Setup - > Payment Gateways -> Activate Gateway -> chose Webcash

7. Tick "Show on Order Form" , key in Merchant Code (ex. 8000XXXX) , Merchant Key (ignore) , Payment Instructions.

8. Tick "Test Mode", if you want to test in testmode.

9. Save changes

10. Done.


NOTE - WEBCASH TEST SERVER:
==========================

Webcash provides test server for merchant to do testing before going for live.

Please follow the following instruction:


1) Please use the following merchant ID -->   80000155

2) For payment, use the following dummy account:

Account: 20000030
Password: tmp1234

(please keep value low to avoid dummy account balance depleted)


3) Please remember to change back merchant ID to your ID when moving to live server.

TQ