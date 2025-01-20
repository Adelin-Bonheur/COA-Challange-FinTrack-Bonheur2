# COA-Challange-FinTrack-Bonheur2
FinTrack

Use the following credentials to log in:  
   - **Username**: admin  
   - **Password**: admin123

## **Description**  
This project is used to track all user expenses, setting a budget not to exceed and notify when exceeded.  

## **Technologies Used**  
- Programming Language: PHP, JavaScript, HTML & CSS  
- Database: MySQL 
- Hosting: awardspace.net

## **Setup and Installation**  
To set up this project locally, follow these steps:  

1. Clone the repository:  
   ```bash  
   git clone https://github.com/Adelin-Bonheur/COA-Challange-FinTrack-Bonheur2.git
   [OR]
   gh repo clone Adelin-Bonheur/COA-Challange-FinTrack-Bonheur2
   ```  

2. Import the database:  
   - Locate the SQL file in the `database` folder.  
   - Import it into your database management tool (e.g., phpMyAdmin).
  Refer to my tutorial to import data base
  Link: https://bit.ly/4gXirjD
  Start (From 4:47 to 6:32)

3. Configure the database connection:  
   - Open the `initialize.php` file.  
   - Update the database credentials:  
     ```php  
     $servername = "your_server";  
     $username = "your_username";  
     $password = "your_password";  
     $dbname = "your_database";  
     ```  

4. Start the server:  
   - Use a local server (e.g., XAMPP, WAMP) or deploy on your hosting platform.  

## **Usage**  
1. Access the system via the provided URL or localhost.  
2. Use the following credentials to log in:  
   - **Username**: admin  
   - **Password**: admin123  

## **How System works?** 

After you logged in you reach the Dashboard Page.

On that page you will see **Current Overall Budget** which shows all budget set to be used in total.
When the Budget exceeds 100000 you will see a red notification saying **Budget Exceeded**

**Today's Budget Entries** For the budget amount entered the day we are on.

**Today's Budget Expenses** For money spent on the day we are on.

**Buget Management** on  side bar menu to used for adding budgets in categories.

**Transactions** for showing all transactions (expenses) and to add expenses (transactions).

**Reports** to generate budget and transaction reports.

**Categories** to add categories for things user spent money on, for them to be given a budget.

**Settings** to change system logo or name.


## **Contact**  
If you have any questions or issues, feel free to reach out:  
- **Email**: adelinbonheur@gmail.com 
- **GitHub**: https://github.com/Adelin-Bonheur
