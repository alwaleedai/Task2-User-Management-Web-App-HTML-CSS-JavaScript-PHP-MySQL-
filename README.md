Project Overview

This project was built to satisfy the following requirements:

Build a webpage using HTML, CSS, JavaScript, and PHP.
Create a one-line form with Name, Age, and a Submit button.
Store submitted data in a MySQL database table.
Display all records from the table below the form.
Add a Toggle button for each record to switch its status between 0 and 1.
Reflect the updated status immediately on the page after toggling (no page refresh).
Host the project on InfinityFree and publish the source code on GitHub.


Files in this Project
File	Purpose
index.php	Main page: renders the form, handles form submission (INSERT into MySQL), and displays all records in a table.
toggle.php	Backend endpoint called via AJAX. Receives a record id, flips its status value in the database (0 → 1 or 1 → 0), and returns the new value as JSON.
db.php	Database connection settings (hostname, username, password, database name). This file is not uploaded to GitHub — see "Security" below.
db.example.php	A placeholder version of db.php with fake values, safe to publish on GitHub as a template.
script.js	Client-side JavaScript.
Listens for clicks on any Toggle button, sends a fetch() POST request to toggle.php, and updates the status cell in the table with the response — without reloading the page.
style.css	Basic styling for the form and table.
schema.sql	SQL script that creates the users table with columns: id, name, age, status.
.gitignore	Prevents db.php (which contains real credentials) from being pushed to GitHub.

How the Application Works — Step by Step

1. Submitting the form
The user fills in Name and Age and clicks Submit.
The form sends a standard POST request to index.php.
index.php reads $_POST['name'] and $_POST['age'], validates them, and inserts a new row into the users table using a prepared statement (INSERT INTO users (name, age, status) VALUES (?, ?, 0)). New records always start with status = 0.
The page then redirects back to itself (header("Location: index.php")) to prevent the form from being resubmitted if the user refreshes the page.

2. Displaying the records
On every page load, index.php runs SELECT id, name, age, status FROM users ORDER BY id DESC.
A PHP while loop prints one <tr> row per record, with a Toggle button in the last column. Each button carries a data-id="<record id>" attribute so JavaScript knows which record it belongs to.

3. Toggling the status (the "live update" part)
Each Toggle button is caught by a single event listener in script.js (event delegation on the table).
When clicked, JavaScript sends a POST request to toggle.php with the record's id, using the Fetch API — this happens in the background,
without navigating to a new page.
toggle.php:
Reads the current status value for that id from the database.
Flips it (0 becomes 1, 1 becomes 0).
Updates the row in the database.
Returns a JSON response like {"success": true, "new_status": 1}.
Back in script.js, once the response arrives, the script finds the matching table row (#row-<id>) and updates only the Status cell's
 text — the rest of the page is untouched and no reload happens. This is what makes the update feel instant.


Deployment Steps (InfinityFree)
Created a free hosting account on InfinityFree and got a free subdomain for the site.
Opened the account's Control Panel → MySQL Databases and created a new database, which generated: database hostname, database name, and database username (password set manually).
Opened phpMyAdmin from the control panel, selected the new database, went to the SQL tab, pasted the contents of schema.sql, 
and executed it — this created the users table with the correct columns (id, name, age, status).
Edited db.php and filled in the real hostname, username, password, and database name obtained from step 2.
Uploaded index.php, toggle.php, db.php, script.js, and style.css into the htdocs folder using the InfinityFree File Manager.
Opened the live site (e.g. yoursite.fwh.is) and tested:
Submitting the form → the new record appeared in the table.
Clicking Toggle → the status value flipped instantly with no page reload.


Publishing to GitHub
Created a new repository on GitHub.
From the project folder:
   git init
   git add .
   git commit -m "Initial commit: user form with live status toggle"
   git branch -M main
   git remote add origin https://github.com/USERNAME/REPO-NAME.git
   git push -u origin main
db.php (which holds the real database password) is excluded from the repository via .gitignore.
 Instead, db.example.php is included with placeholder values so anyone who clones the project knows what credentials to fill in.



Security Note

Real database credentials should never be committed to a public GitHub repository.
This project keeps them isolated in db.php, which is git-ignored, while db.example.php documents the expected format without exposing any real secrets.
The app also uses prepared statements (mysqli::prepare / bind_param) for all database queries to protect against SQL injection.


Result
✅ Working form that stores data in MySQL.
✅ Table that displays all records dynamically from the database.
✅ Toggle button per record that updates status in real time via AJAX (Fetch API), with no page refresh.
✅ Deployed live on InfinityFree.
✅ Source code published on GitHub with this documentation.
