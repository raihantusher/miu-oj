![enter image description here](http://miuportal.manarat.ac.bd/Images/miu.png)

# Installation

 1. configure .env file 
			 1. edit application url , name etc
			 2. edit database mail configuration
			 3. edit mail configuration
 2. Run migration 

    

> php artisna migrate:refresh --seed
3. Run the app:
> 
> php artisan serve

# Users and Roles
users:
1. admin@admin.com
2. student@admin.com
both have same password **admin1234**

there has two user roles admin and student.
1. admin can create sets and questions, change the result status.
2. admin will provide a unique join id of a set to the users.
3. student will able to join with set id and view all the questions.
