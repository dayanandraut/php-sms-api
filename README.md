# php-sms-api
restful api created in php to send sms through sparrow sms (Nepal’s leading Bulk SMS Service)

## Description
There are two endpoint:
1. [GET] '..../php-sms-api/api/user/getByEmail?email=abc@cde.com' 
to fetch user details based on email.

2. [POST] '..../php-sms-api/api/message/create.php'
    i. sends sms to the number of mobile numbers (contacts separated by comma)
    ii. saves the message and and calculates the number of messages left for user and updates it

## Steps
1. create database from the sql script
2. configure database in config/database.php
3. add sparrow provided token in the message/create.php

Hit the endpoint '..../php-sms-api/api/message/create.php' with body in the following format.

{	
    "date":"2019-08-09",
    "contacts":"1234567890,9876543210",
    "message":"I am testing",
    "tbUserId":"10001",
    "purpose":"Test"
}
