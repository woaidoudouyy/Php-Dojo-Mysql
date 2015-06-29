DROP DATABASE IF EXISTS client_report;
CREATE DATABASE IF NOT EXISTS client_report;


DROP TABLE IF EXISTS client_report.client;
DROP TABLE IF EXISTS client_report.transaction;

CREATE TABLE client_report.client(
  id INT(7) NOT NULL AUTO_INCREMENT, 
  name VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
  );

CREATE TABLE client_report.transaction(
  id INT(7) NOT NULL AUTO_INCREMENT,
  client_id INT(7),
  tran_date DATE,
  PRIMARY KEY (id),
  FOREIGN KEY (client_id)
      REFERENCES client_report.client(id)
  );



/*insert transactions into transactions table for three clients in 3/25   4/25  5/25 date*/
DROP PROCEDURE IF EXISTS client_report.insert_transaction;
DELIMITER //
CREATE PROCEDURE client_report.insert_transaction()
BEGIN
   DECLARE number_of_tran1_tony  INT;
   DECLARE number_of_tran1_many  INT;
   DECLARE number_of_tran1_runsheng  INT;
   DECLARE DATE1 DATE;
   
   DECLARE number_of_tran2_tony  INT;
   DECLARE number_of_tran2_many  INT;
   DECLARE number_of_tran2_runsheng  INT;
   DECLARE DATE2 DATE;
   
   DECLARE number_of_tran3_tony  INT;
   DECLARE number_of_tran3_many  INT;
   DECLARE number_of_tran3_runsheng  INT;
   DECLARE DATE3 DATE;

   SET number_of_tran1_tony = 50;
   SET number_of_tran2_tony = 100;
   SET number_of_tran3_tony = 75;
   
   SET number_of_tran1_many = 10;
   SET number_of_tran2_many = 20;
   SET number_of_tran3_many = 30;
   
   SET number_of_tran1_runsheng = 30;
   SET number_of_tran2_runsheng = 20;
   SET number_of_tran3_runsheng = 10;
   
   SET DATE1 ="2015/3/25";
   SET DATE2 ="2015/4/25";
   SET DATE3 ="2015/5/25";
	   /*insert some clients to client table*/
	INSERT INTO client_report.client
	VALUES (default, "Runsheng");

	INSERT INTO client_report.client
	VALUES (default, "Mary");

	INSERT INTO client_report.client
	VALUES (default, "Tony");

    WHILE number_of_tran1_tony >0 DO
      INSERT INTO client_report.transaction
      VALUES (default, 3 ,DATE1);
            
            SET number_of_tran1_tony = number_of_tran1_tony-1;
    END WHILE;
        
        WHILE number_of_tran2_tony >0 DO
      INSERT INTO client_report.transaction
      VALUES (default, 3 ,DATE2);
            
            SET number_of_tran2_tony = number_of_tran2_tony-1;
    END WHILE;
        
         WHILE number_of_tran3_tony >0 DO
      INSERT INTO client_report.transaction
      VALUES (default, 3 ,DATE3);
            
            SET number_of_tran3_tony = number_of_tran3_tony-1;
    END WHILE;
        
        WHILE number_of_tran1_many >0 DO
      INSERT INTO client_report.transaction
      VALUES (default, 2 ,DATE1);
            
            SET number_of_tran1_many = number_of_tran1_many-1;
    END WHILE;
        
         WHILE number_of_tran2_many >0 DO
      INSERT INTO client_report.transaction
      VALUES (default, 2 ,DATE2);
            
            SET number_of_tran2_many = number_of_tran2_many-1;
    END WHILE;
        
        WHILE number_of_tran3_many >0 DO
      INSERT INTO client_report.transaction
      VALUES (default, 2 ,DATE3);
            
            SET number_of_tran3_many = number_of_tran3_many-1;
    END WHILE;
        
        WHILE number_of_tran1_runsheng >0 DO
      INSERT INTO client_report.transaction
      VALUES (default, 1 ,DATE1);
            
            SET number_of_tran1_runsheng = number_of_tran1_runsheng-1;
    END WHILE;
        
    WHILE number_of_tran2_runsheng >0 DO
      INSERT INTO client_report.transaction
      VALUES (default, 1 ,DATE2);
            
            SET number_of_tran2_runsheng = number_of_tran2_runsheng-1;
    END WHILE;
        
        WHILE number_of_tran3_runsheng >0 DO
      INSERT INTO client_report.transaction
      VALUES (default, 1 ,DATE3);
            
            SET number_of_tran3_runsheng = number_of_tran3_runsheng-1;
    END WHILE;
               
  
END //
DELIMITER ;

/* populate data*/
call client_report.insert_transaction;

/*	 query used for report
SELECT t.tran_date, c.name, COUNT(*) AS "total_trans" FROM client_report.transaction t 
JOIN client_report.client c ON c.id = t.client_id
GROuP BY t.tran_date, t.client_id
ORDER BY t.tran_date DESC;
*/