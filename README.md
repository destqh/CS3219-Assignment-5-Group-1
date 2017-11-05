# CS3219-Assignment-5-Group-1
Everyday, there are thousands of scientific documents being added to our knowledge base. It is thus of great interest in the scientific community to track the current trends on research topics and their future implications. However, it is a challenge to digest a big source of text and make meaning insights from data. Thus, the aim of this project is to come up with a tool, Conference Information Retrieval (CIR), to aid the process. 
Since data is more easily understood when it is visually presented, patterns which often go unnoticed in a dataset, quickly becomes obvious when we visualise it on for example a graphical chart. Thus, CIR has been tailored to communicate information in a quick and visual way to ease the process of analysing the data. 

## Set up
1. In Repo folder run cmd line:
```
npm install express body-parser mongojs --save
npm install chai chai-http mocha --save-dev
```

## Note:
1. Do not push the node_modules up to git
2. Do not push mongodb data to to git
3. Travis only uses the [sample data of 10MB](http://labs.semanticscholar.org/corpus/) as there is file size limit for git.
4. The test folder should have the same structure as the cir folder