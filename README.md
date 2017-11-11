# CS3219-Assignment-5-Group-1
Everyday, there are thousands of scientific documents being added to our knowledge base. It is thus of great interest in the scientific community to track the current trends on research topics and their future implications. However, it is a challenge to digest a big source of text and make meaning insights from data. Thus, the aim of this project is to come up with a tool, Conference Information Retrieval (CIR), to aid the process. 
Since data is more easily understood when it is visually presented, patterns which often go unnoticed in a dataset, quickly becomes obvious when we visualise it on for example a graphical chart. Thus, CIR has been tailored to communicate information in a quick and visual way to ease the process of analysing the data. 

## Set up
1. Set up MongoDB (Windows)
	1. Download and install [Windows Server 2008 R2 64-bit and later, with SSL support x64](https://www.mongodb.com/download-center#community).
	2. You can install MongoDB in any folder which can be change during the installation phase.
	3. After installation, in the mongodb folder create 2 folders 'data' and 'log'.
	4. In the data folder, create another folder 'db'.
	5. Open cmd as administrator and navigate to the mongodb bin folder:
		```
		cd <Your directory>\mongodb\bin
		```
	6. Run the command to set up the database:
		```
		mongod --directoryperdb --dbpath C:\Users\User\Documents\GitHub\Test\mongodb\data\db --logpath C:\Users\User\Documents\GitHub\Test\mongodb\log\mongo.log --logappend --rest --install
		```
	7. Start MongoDB (make sure you run the cmd interface as administrator):
		```
		net start mongodb
		```
	* Using the MongoDB shell in cmd:
		```
		mongo
		```
	* Stop MongoDB:
		```
		net stop mongodb
		```
2. Set up Bitnami Wamp Stack (Windows)
	1. Download and install [bitnami-wampstack-7.1.11-0-windows for win 32-bits / bitnami-wampstack-7.1.11-0-windows-x64 for win 64-bits](https://bitnami.com/stack/wamp/installer) under C:\ drive.
	2. Open Bitnami Wamp Stack Manager tool
		i. Under Manage Servers
			a. Click Configure
				- Change port to 80.
	3. Copy cir/web_server/cir folder to C:\Bitnami\wampstack-7.1.11-0 folder.
	4. Copy cir/web_server/index.php file to C:\Bitnami\wampstack-7.1.11-0 folder.
	5. Start Apache server in Bitnami Wamp Stack Manager tool under Manage Server.
	
3. Set up Node.js
	* Download and install [node.js](https://nodejs.org/en/) version 8.
	* View version of node.js and npm:
		```
		node -v
		npm -v
		```

4. Clone Repo and in Repo folder run cmd line:
	```
	npm install express body-parser mongojs --save
	npm install chai chai-http mocha --save-dev
	```

5. Populate data to MongoDB
	1. Make sure to start MongoDB.
	2. In the Repo folder 'dbdata', change 'main.sh' to 'main.bat' (For Windows User).
	3. Run main.bat.

6. Run Program using cmd in the Repo folder (Ctrl+C to stop):
	```
	npm start
	```
	
7. Run Test using cmd in the Repo folder:
	```
	npm test
	```
	
## Note
1. Do not push the node_modules up to git.
2. Do not push mongodb data to to git.
3. Travis only uses the [sample data of 10MB](http://labs.semanticscholar.org/corpus/) as there is file size limit for git.
4. The test folder should have the same structure as the cir folder.
