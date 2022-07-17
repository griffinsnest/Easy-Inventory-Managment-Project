
How to Use:\
1.) Clone this repository by selecting one of the options from the green "Code" button or by using `git clone https://github.com/griffinsnest/Easy-Inventory-Managment-Project`\
2.) Navigate to heroku.com and login if you have an account.

 - If you do not already have an account, click "Sign Up" and enter valid credentials to create your account.

3.) On the apps page, click the "New" button in the top right and select "Create New App".\
4.) Enter a name for your app (e.g. my-inventory-manager) and click "Create".\
5.) Navigate to the resources tab and enter "ClearDB MySQL" into the search bar under "Add-ons".\
6.) Select the first entry that appears and make sure that the selected plan says "Ignite - Free" before clicking "Submit Order Form".\
7.) Navigate to the settings page and click the "Reveal Config Vars" button. You should see an entry labelled "CLEARDB_DATABASE_URL".\
8.) Copy the text in the box to the right of the "CLEARDB_DATABASE_URL" label and save it somewhere; you'll need this information in the next few steps. For ease of use, split the line into 4 pieces on different lines like so:
**mysql://b680dc6ed9ad30:609ad266@us-cdbr-east-05.cleardb.net/heroku_0111cefb86a367d?reconnect=true**\
Becomes:\
**b680dc6ed9ad30\
609ad266\
us-cdbr-east-05.cleardb.net\
heroku_0111cefb86a367d**\
9.) Navigate on your computer to wherever you cloned the database (e.g. C:\Users\%YOUR_USERNAME%\Documents\GitHub\Easy-Inventory-Managment-Project).\
10.) Open the "database" folder and then open "config.php" with a text editor or IDE.\
11.) Replace (Host) with the third line you saved, (Username) with the first line, (Password) with the second line, and (DB Name) with the last line. In my case the file should look like this:

    $host = "us-cdbr-east-05.cleardb.net";
    $db_username = "b680dc6ed9ad30";
    $db_pw = "609ad266";
    $dbname = "heroku_0111cefb86a367d";

12.) Navigate to https://devcenter.heroku.com/articles/heroku-cli and follow the instructions on the page to install the Heroku CLI.\
13.) Open the command line by holding Windows+R and typing in "CMD.EXE".\
14.) Navigate to the directory of your cloned repository using `cd (path)` (e.g. `cd C:\Users\%YOUR_USERNAME%\Documents\GitHub\Easy-Inventory-Managment-Project`).\
15.) Enter `heroku login` and follow the instructions to login to the Heroku CLI.\
16.) Once you have logged in successfully, enter `heroku git:remote -a (Your-App-Name)` (e.g. `heroku git:remote -a my-inventory-manager`).\
17.) Now enter `git push heroku main`. If you get an error: 

> failed to push some refs to 'https://git.heroku.com/(Your-App-Name).git'

 try `git push heroku master`.\
 18.) From your wamp folder go into apps and then phpmyadminVERSION# and open "config.inc.php.\
 19.) In "config.inc.php" go to the end of the file just before the closing ?> and type as follows:
 
    $i++;
    $cfg["Servers"][$i]["host"] = "hostname"; //provide hostname, e.g."us-cdbr-east-05.cleardb.net"
    $cfg["Servers"][$i]["user"] = "username"; //user name for your remote server, e.g. "b680dc6ed9ad30"
    $cfg["Servers"][$i]["password"] = "password"; //password for your remote server,  e.g. "609ad266"
    $cfg["Servers"][$i]["auth_type"] = "config"; // keep it as config for PHPMyAdmin reading of file
    
 20.) Navigate to https://sourceforge.net/projects/wampserver/. Click the files tab under the download button and navigate to WampServer 3 > WampServer 3.0.0 and click the file named "wampserver(version number)_x64.exe".

 - This is the 64 bit version of the program. If you need the 32 bit version then click the file named "wampserver(version number)_x86.exe" instead.

21.) Open the installer and follow the directions to install WampServer.\
 22.) Open WampServer64 (or WampServer32) and wait for it to run.\
 23.) Navigate to http://localhost/phpmyadmin/. It may take a few moments to load.\
 24.) Enter "root" into the username field and leave the password field blank. Then click login.\
 25.) Under the "Current server:" drop down menu there should be a new option titled `hostname (username)` entered in the last step, in our example's case `us-cdbr-east-05.cleardb.net (b680dc6ed9ad30)`.\
 26.) There should be only one database besides information_schema begining with heroku_ followed by random string of letters and numbers.\
 27.) Click on the heroku_ database and then the `SQL` tab between Structure and Search tabs in the top-middle of the page.\
 28.) Copy and Paste all of the `CREATE TABLE` and `INSERT INTO` code from the "inventory_db.sql" file and hit the "Go" button on the page.\
 29.) Back on your heroku page, click the "Open app" button in the top right. If all went well, you should be able to login with the credentials "MASTER" and "Password". Use the Manage Users page to create an account for yourself, then navigate back to (Your-App-Name).herokuapp.com and login using your new credentials. 

 - You should delete the master account using the Manage Users page once you have created your own account.

 30.) Your inventory manager should now be ready to use. If you'd like other people to be able to access the manager, create accounts for them using the Manage Users    page and send them their credentials. They can use the forgot password feature to change their passwords.
