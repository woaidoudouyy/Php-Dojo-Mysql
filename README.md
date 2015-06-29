# Php-Dojo-Mysql
two exercises for using PHP/ Dojo /Mysql 

## Set up
 
In order to run the project, you need have install Mysql server, Apache server, 5.* php
(apache in preinstalled in mac) If you are using window OS please go to the link below and download the WAMP server
http://www.wampserver.com/en/

After you got all the servers running, you need to go to my PhpReport/MySqlScript folder and run the .sql file and you will get
two databases: client_report database(test1),  user database(test2)

Client_report database has client table, transaction table and one store procedure in order to insert client transactions quickly.

User database has user table (all user information) and username table (all registered username provent duplicate username)



![GitHub Logo](/readme/tableSchema.png)

##Screen shots

Main Page

Created a simple animation mainpage with Adobe edge

![GitHub Logo](/readme/mainpage.png)

Test1: Client report for calculate transaction cost
<50 $0.5 per transaction   >50 $0.75 per transaction

![GitHub Logo](/readme/test1.png)

Test2: Two parts (restful service: Test2.php and client: Test2Client.php)

restful service support 4 http method the client side can use ajax to get the json response

-Get get all user
-Post new user
-Put update user
-Delete delete user

![GitHub Logo](/readme/test2.png)

Can't create user with duplicated username(display error message from response object: OnError)

![GitHub Logo](/readme/addError.png)

Create a new user 
![GitHub Logo](/readme/addSuccess.jpg)

Update a user 
![GitHub Logo](/readme/update.jpg)

Delete a user 
![GitHub Logo](/readme/delete.jpg)






