
#!/bin/sh
node ./dbdata/drop_docs.js
node ./dbdata/create_docs.js
node --max-old-space-size=4096 ./dbdata/import_docs.js
node ./dbdata/print_docs.js