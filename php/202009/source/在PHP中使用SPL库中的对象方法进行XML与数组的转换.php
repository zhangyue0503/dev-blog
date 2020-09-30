<?php

class ConvertXml
{
    public function xmlToArray(SimpleXMLIterator $xml): array
    {
        $res = [];

        for ($xml->rewind(); $xml->valid(); $xml->next()) {
            $a = [];
            if (!array_key_exists($xml->key(), $a)) {
                $a[$xml->key()] = [];
            }
            if ($xml->hasChildren()) {
                $a[$xml->key()][] = $this->xmlToArray($xml->current());
            } else {
                $a[$xml->key()] = (array) $xml->current()->attributes();
                $a[$xml->key()]['value'] = strval($xml->current());
            }
            $res[] = $a;
        }

        return $res;
    }

    const UNKNOWN_KEY = 'unknow';
    
    public function arrayToXml(array $a)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" standalone="yes"?><root></root>');
        $this->phpToXml($a, $xml);
        return $xml->asXML();
    }
    
    protected function phpToXml($value, &$xml)
    {
        $node = $value;
        if (is_object($node)) {
            $node = get_object_vars($node);
        }
        if (is_array($node)) {
            foreach ($node as $k => $v) {
                if (is_numeric($k)) {
                    $k = 'number' . $k;
                }
                if (!is_array($v) && !is_object($v)) {
                    $xml->addChild($k, $v);
                } else {
                    $newNode = $xml->addChild($k);
                    $this->phpToXml($v, $newNode);
                }
            }
        } else {
            $xml->addChild(self::UNKNOWN_KEY, $node);
        }
    }

}

//
$wsdl = 'http://flash.weather.com.cn/wmaps/xml/china.xml';

$xml = new SimpleXMLIterator($wsdl, 0, true);
$convert = new ConvertXml();
// var_dump($convert->xmlToArray($xml));
// array(37) {
//     [0]=>
//     array(1) {
//       ["city"]=>
//       array(2) {
//         ["@attributes"]=>
//         array(9) {
//           ["quName"]=>
//           string(9) "黑龙江"
//           ["pyName"]=>
//           string(12) "heilongjiang"
//           ["cityname"]=>
//           string(9) "哈尔滨"
//           ["state1"]=>
//           string(1) "7"
//           ["state2"]=>
//           string(1) "3"
//           ["stateDetailed"]=>
//           string(15) "小雨转阵雨"
//           ["tem1"]=>
//           string(2) "21"
//           ["tem2"]=>
//           string(2) "16"
//           ["windState"]=>
//           string(21) "南风6-7级转4-5级"
//         }
//         ["value"]=>
//         string(0) ""
//       }
//     }
//     [1]=>
//     array(1) {
//       ["city"]=>
//       array(2) {

$data = array(
    'unlikely-outliner' => ['subject' => [
        'mongo-db' => [
            'outline' => [
                // chapter titles / left column menu
                'chapter' => [
                    'getting-started' => ['Getting Started', 'Getting Started'],
                    'what-is-mongo-db' => ['What is MongoDB?', 'What is MongoDB?'],
                    'install-and-config' => ['Installation and Configuration', 'Install / Config'],
                    'c-r-u-d-operations' => ['Create, Read, Update and Delete Operations', 'C.R.U.D. Ops'],
                    'data-modeling' => ['Data Modeling', 'Data Modeling'],
                    'database-management' => ['MongoDB Database Management', 'Database Mgmt'],
                ],
                // actual outline
                'getting-started' => [
                    1 => ['chap' => 'What does the course cover?',
                        'topic' => [1 => ['item' => '', 'answer' => ['']],
                        ],
                    ],
                    2 => ['chap' => 'How do you set up for the course?',
                        'topic' => [1 => ['item' => 'Make sure you have LAMP / MAMP / WAMP / XAMPP installed', 'answer' => ['']],
                            2 => ['item' => 'Command line / terminal application', 'answer' => ['Make sure you know how to open up a command prompt for your operating system', 'For Mac users this is the "Terminal" application', 'For Windows users, from the Start menu, type <b>cmd</b>', 'For Linux users usually CTRL+ALT+T works, otherwise look for a command "Terminal"']],
                            3 => ['item' => 'The installation of MongoDB will be covered in the installation lab', 'answer' => ['']],
                            4 => ['item' => 'Download or copy the Working Files folder into your home folder', 'answer' => ['']],
                            5 => ['item' => 'Demo test programs used in the course', 'answer' => ['Use PHP from the command line', 'In some cases use the <b>mongo</b> command shell']],
                            6 => ['item' => 'Sample data', 'answer' => ['The Working Files folder for the installation chapter has sample data which can be imported once you have MongoDB running']],
                        ],
                    ],
                    3 => ['chap' => 'About the Author',
                        'topic' => [1 => ['item' => 'Work', 'answer' => ['<b>unlikelysource.com</b>', 'Contract instructor for Zend Technologies', 'Simple Email Form Joomla extension']],
                            2 => ['item' => 'Programming Languages Used', 'answer' => ['PHP, PERL, Javascript/jQuery', 'Java, XSLT, C / C++', 'FORTH, Assembler, BASIC', 'Prolog, FORTRAN, PL/I']],
                            3 => ['item' => 'OS, Environments and Protocols', 'answer' => ['Novell NetWare', 'Windows: 3 to 8', 'Linux/Unix: Red Hat, SuSE, Ubuntu, System V', 'Active Directory, eDirectory (NDS)', 'TCP/UDP, IPv4, IPv6, IPX', 'LDAP, SNMP, SMTP', 'XML, SOAP, REST']],
                            4 => ['item' => 'Education', 'answer' => ['State University of New York at Potsdam', 'Golden Gate University, San Francisco: C and AI', 'UC Santa Cruz Extension, Silicon Valley: SNMP and BASH', 'Novell Technical Training: TCP/IP, Java J2EE and Struts, ', 'HTML, XSLT, DirXML, Protocol Analysis, Security and Management, ', 'Web Services, Routing, Network Design, and OS Integration', 'Zend: PHP and Zend Framework']],
                            5 => ['item' => 'Certifications', 'answer' => ['Zend Certified Engineer:', 'PHP 5.1, 5.3, 5.5, Zend Framework 1, Zend Framework 2', 'Novell: MCNE, MCNI', 'CompTIA: Certified Tech Trainer']],
                        ],
                    ],
                    4 => ['chap' => 'Outro',
                        'topic' => [1 => ['item' => 'The MongoDB configuration filename', 'answer' => ['Referred to as "mongod.conf" in the course', 'Depends on the installation', 'Could also be "mongodb.conf" or "mongo.conf"']],
                            2 => ['item' => 'Installing the MongoDB PHP programming driver', 'answer' => ['Make sure you have LAMP / MAMP / WAMP / XAMPP installed', 'Run "phpinfo()" to find out what version of PHP is installed', 'Find out details on your operating system (i.e. 32 bit, 64 bit, etc.)', 'Choose the appropriate MongoDB driver accordingly']],
                        ],
                    ],
                ],
                'what-is-mongo-db' => [
                    //http://martinfowler.com/nosql.html
                    1 => ['chap' => 'What is meant by NoSQL?',
                        'topic' => [1 => ['item' => 'No "official" definition exists', 'answer' => ['No SQL, or Not Only SQL', 'Non-relational, distributed, open source, scalable']],
                            2 => ['item' => 'Does not use relational model', 'answer' => ['No tables, rows, columns and relations', 'Different models used:', 'Column, document, key-value and graph', 'Other models:', 'Multimodel (OrientDB), Object (db4o), Grid/Cloud, XML (Berkeley DB XML), Multidimensional (GT.M), Multivalue (TigerLogic PICK)']],
                            3 => ['item' => 'No fixed schema', 'answer' => ['Lowest unit of MongoDB data is a "document"', 'Uses a JSON document as basis', 'Allows considerable flexibility', 'JSON is converted to BSON for storage']],
                            4 => ['item' => 'Driven by "big data"', 'answer' => ['Scales extremely well', 'Works well in clustered/cloud environment', 'Google Bigtable', 'Amazon SimpleDB']],
                            5 => ['item' => 'Examples', 'answer' => ['MongoDB, CouchDB, RavenDB : <b>Document</b> ', 'Cassandra, Apache HBase (Hadoop) : <b>Column</b>', 'Redis, Riak, DynamoDB : <b>Key/Value</b> ', 'Neo4j, Titan : <b>Graph</b>']],
                        ],
                    ],
                    2 => ['chap' => 'Why use MongoDB?',
                        'topic' => [1 => ['item' => 'Has all advantages mentioned for NoSQL', 'answer' => ['Non-relational, distributed, open source, scalable', 'Works well in clustered/cloud environment', 'Data is modeling matches application objects']],
                            2 => ['item' => 'Well supported', 'answer' => ['<b>Languages supported:</b>', 'C, C++, C#', 'Scala, Haskell, Java, javascript', 'PHP, PERL, Ruby']],
                            3 => ['item' => 'Fits better with object oriented programming', 'answer' => ['Your data structures can match your application', 'Data stored as JSON documents', 'JSON is converted to BSON for storage']],
                            4 => ['item' => 'Extremely fast and scalable', 'answer' => ['No complex relations between tables', 'Related data stored together', 'Capacity can be increased through "sharding" without down-time']],
                            5 => ['item' => 'How popular is MongoDB?', 'answer' => ['Depending on the rankings, RDBMS are solidly in the Top 10', 'According to some, MongoDB is number 6<a target="_blank" href="http://db-engines.com/en/ranking">.</a>']],
                            6 => ['item' => 'What are some common use cases for MongoDB', 'answer' => ['Archiving, CMS, eCommerce, Analytics, Social Networking', 'Session and user profile storage', 'Heavily used content-driven websites', 'Delivering content to mobile apps', 'Data aggregation (i.e. getting P.O.S. info for loyalty points)']],
                        ],
                    ],
                    3 => ['chap' => 'What are some common MongoDB terms?',
                        'topic' => [1 => ['item' => 'Document', 'answer' => ['Basic unit of data', 'Based on objects represented as JSON', 'Stored in a binary format BSON', 'Can have one or more fields', 'Grouped together as <i>collections</i>', 'Examples ...']],
                            2 => ['item' => 'Field', 'answer' => ['Smallest subdivision within a <i>document</i>', 'Analogous to a column in a database table', 'Examples ...']],
                            3 => ['item' => 'Collection', 'answer' => ['Group of <i>documents</i>', 'Like an RDBMS <i>table</i>', 'Exists within a mongoDB <i>database</i>', 'No fixed/rigid schema: documents can have different fields', 'Collections should represent data with a common purpose', 'Examples ...']],
                            4 => ['item' => 'Referencing', 'answer' => ['Used for 1-to-many relationships', 'More efficient storage', 'Allows for <i>normalized</i> data structures', 'Slower and less efficient to read', 'Examples ...']],
                            5 => ['item' => 'Embedding', 'answer' => ['Lets you to represent 1-to-1 and 1-to-many relationships', 'Allows for <i>de-normalized</i> complex modeling', 'Brings in data where it is needed', '"Document Growth" can affect writes and risk fragmentation', 'Examples ...']],
                            6 => ['item' => 'Cursor', 'answer' => ['Used to iterate through results of a query', 'Produced by <i>find()</i>', 'Further ops are possible: sort(),limit(),etc.']],
                        ],
                    ],
                    4 => ['chap' => 'What are the more important MongoDB features?',
                        // http://docs.mongodb.org/manual/core/indexes-introduction/
                        'topic' => [1 => ['item' => 'Indexes', 'answer' => ['Improves performance for frequent queries', 'Indexes are based on a field or set of fields', 'Queries containing only indexed fields are optimal', 'Can affect other operations such as sort()', 'Main Types: <i>single field</i> and <i>compound</i>', 'Other types: multikey, geospatial, text, hashed', 'Properties: unique, sparse']],
                            // http://docs.mongodb.org/manual/core/read-preference/
                            2 => ['item' => 'Distributed queries', 'answer' => ['Sharded clusters allow you to partition a data set', 'Reads are most efficient when directed to a specific shard', 'Scatter gather queries (no shard key) can be inefficient']],
                            3 => ['item' => 'Read preferences', 'answer' => ['Allows you to control queries (reads)', 'Concerns <i>replica sets</i>', '<b>Modes:</b> primary, primaryPreferred, secondary, <br />secondaryPreferred, nearest']],
                            4 => ['item' => 'Distributed write operations', 'answer' => ['Directs write operations from apps to shard clusters', 'Partitions data into ranges based on value of the shard key', 'Write operations go to the primary', 'Secondaries continuously replicating the primary oplog <br />and apply the operations to themselves', 'Write concerns can apply']],
                            // http://docs.mongodb.org/manual/core/write-concern/
                            5 => ['item' => 'Write concerns', 'answer' => ['Guaranteed delivery', 'Stronger settings: slower, better guarantee', '<b>Levels:</b> Errors Ignored, Unacknowledged, Acknowledged, <br />Journaled, Replica Acknowledged']],
                            // http://docs.mongodb.org/manual/core/query-plans/
                            6 => ['item' => 'Query plans and optimizers', 'answer' => ['Optimizer processes queries', 'Chooses the most efficient query plan', 'Over time deletes and re-evaluates the plan']],
                        ],
                    ],
                    5 => ['chap' => 'What is MongoDB Aggregation?',
                        // http://docs.mongodb.org/manual/core/indexes-introduction/
                        'topic' => [1 => ['item' => 'Modalities: Pipeline, Map-Reduce, Single Purpose', 'answer' => ['Pipeline', 'Map Reduce', 'Single Purpose']],
                            2 => ['item' => 'Pipeline Aggregation', 'answer' => ['Groups values from multiple documents', 'Performs ops on grouped data', 'Returns single result', 'Like SQL GROUP BY and HAVING']],
                            // http://docs.mongodb.org/manual/core/aggregation-introduction/
                            3 => ['item' => 'Map-Reduce Aggregation', 'answer' => ['Condenses large volumes of data into useful aggregated results', 'Operation: Map, Reduce, Finalize', '<b>Map:</b> function emits key-value pairs', '<b>Reduce:</b> collects and condenses the aggregated data', '<b>Finalize:</b> further condenses or processes the results']],
                            // http://docs.mongodb.org/manual/core/single-purpose-aggregation/
                            4 => ['item' => 'Single Purpose Aggregation', 'answer' => ['Operations: <i>count</i>, <i>distinct</i> and <i>group</i>', 'Easy to use', 'Limited in scope']],
                        ],
                    ],
                    6 => ['chap' => 'LAB: Official Try MongoDB Tutorial',
                        'topic' => [1 => ['item' => 'Take the MongoDB Tutorial', 'answer' => ['http://try.mongodb.org/']],
                            2 => ['item' => 'Save a document', 'answer' => ['db.test.save({a:1})']],
                            3 => ['item' => 'Find documents', 'answer' => ['db.test.find()']],
                        ],
                    ],
                ],
                'install-and-config' => [
                    1 => ['chap' => 'General considerations',
                        'topic' => [1 => ['item' => 'How do you test the installation?', 'answer' => ['Open another command prompt', 'Run the command to start MongoDB', 'Use the default database: <b>use mydb</b>', 'Save a test document: <b>db.test.save({a:1})</b>', 'Find the test document: <b>db.test.find()</b>']],
                            2 => ['item' => 'What if MongoDB does not start?', 'answer' => ['Make sure you have added "dbpath" and "logpath" parameters to the MongoDB config file', 'Make sure the "dbpath" and "logpath" directories have been created', 'Make sure that MongoDB has permissions to read from <br />and write to the log and database path directories', 'Did you install the right version?']],
                            3 => ['item' => 'What about security?', 'answer' => ['Authentication is disabled by default', 'Review the security videos to learn how to enable authentication']],
                        ],
                    ],
                    // http://docs.mongodb.org/manual/tutorial/install-mongodb-on-windows/
                    2 => ['chap' => 'Installing MongoDB on Windows -- Part 1',
                        // http://support.microsoft.com/kb/2731284
                        // part 1
                        'topic' => [1 => ['item' => 'Download correct version', 'answer' => ['Run <i>wmic os get osarchitecture</i> from command prompt', 'MongoDB for Windows Server 2008 R2', 'MongoDB for Windows 64-bit', 'MongoDB for Windows 32-bit', 'Windows XP and versions below are not supported', 'Windows Server 2008 R2 or Windows 7 need hotfix 2731284']],
                            2 => ['item' => 'Extract to C:\\', 'answer' => ['You can then rename the folder created', 'MongoDB is self-contained']],
                            3 => ['item' => 'Create <i>data</i> and <i>log</i> folders', 'answer' => ['Data folder: <b>md c:\\data\\db</b>', 'Log folder: <b>md c:\\path\\to\\mongodb\\log</b>']],
                            4 => ['item' => 'Create config file <i>mongo.cfg</i>', 'answer' => ['Enter log file path into new config file: <br /><b>echo logpath=c:\\path\\to\\mongodb\\log\\mongo.log > c:\\path\\to\\mongodb\\mongod.cfg</b>']],
                            5 => ['item' => 'Starting: from a command prompt', 'answer' => ['Open a command prompt', 'Type: <b>c:\\path\\to\\mongodb\\bin\\mongod.exe</b>', 'If using another data folder: <br />c:\\path\\to\\mongodb\\bin\\mongod.exe --dbpath "drive:\\path\\to\\data"']],
                            6 => ['item' => 'Connect to MongoDB', 'answer' => ['Open another command prompt', 'Type: <b>c:\\path\\to\\mongodb\\bin\\mongod.exe</b>', 'Use the default database: <b>use mydb</b>', 'Save a test document: <b>db.test.save({a:1})</b>', 'Find the test document: <b>db.test.find()</b>']],
                        ],
                    ],
                    3 => ['chap' => 'Installing MongoDB on Windows -- Part 2',
                        // http://support.microsoft.com/kb/2731284
                        // part 1
                        'topic' => [1 => ['item' => 'Starting: as a Windows service', 'answer' => ['Open a command prompt', 'Install the MongoDB service: <br /><b>c:\\path\\to\\mongodb\\bin\\mongod.exe --config c:\\path\\to\\mongodb\\mongod.cfg --install</b>', 'Start the service: <b>net start MongoDB</b>']],
                            2 => ['item' => 'Stopping / Removing Windows service', 'answer' => ['Open a command prompt', 'Stop the service: <b>net stop MongoDB</b>', 'Remove the MongoDB service: <br /><b>c:\\path\\to\\mongodb\\bin\\mongod.exe --remove</b>']],
                            3 => ['item' => 'Connect to MongoDB', 'answer' => ['Open another command prompt', 'Type: <b>c:\\path\\to\\mongodb\\bin\\mongod.exe</b>', 'Use the default database: <b>use mydb</b>', 'Save a test document: <b>db.test.save({a:1})</b>', 'Find the test document: <b>db.test.find()</b>']],
                        ],
                    ],
                    //http://docs.mongodb.org/manual/tutorial/install-mongodb-on-os-x/
                    //http://www.codeproject.com/Articles/275812/Setting-up-MongoDB-on-OSX
                    4 => ['chap' => 'Installing MongoDB on a Mac',
                        'topic' => [1 => ['item' => 'Download from <b>mongodb.org/downloads</b>', 'answer' => ['']],
                            2 => ['item' => 'Extract to a folder', 'answer' => ['Open the terminal app', 'tar xvfz Downloads/mongodb-osx-x86_62-nn-nn-nn.nn.nn.tgz']],
                            3 => ['item' => 'Rename the folder <b>mv </b>', 'answer' => ['mv mongodb-osx-x86_62-nn-nn-nn.nn.nn mongodb']],
                            4 => ['item' => 'Create a data folder', 'answer' => ['mkdir data', 'mkdir data/db']],
                            5 => ['item' => 'Put the binaries in the path', 'answer' => ['echo "export PATH=$PATH:/path/to/mongodb">.bash_profile', 'Exit the terminal app', 'Reopen the terminal app']],
                            6 => ['item' => 'Create a /path/to/mongodb/mongod.conf file', 'answer' => ['Copy the sample from github.com/mongodb/mongo/blob/master/rpm/mongod.conf', 'Open TextEdit', 'Format - Make Plain Text', 'Change "logpath=" and "dbpath="', 'Save to /path/to/mongodb/mongod.conf']],
                            7 => ['item' => 'Start mongod', 'answer' => ['mongod -f /path/to/mongodb/mongod.conf']],
                            8 => ['item' => 'Test', 'answer' => ['mongo', 'use mydb', 'db.test.save({a:1})', 'db.test.find()']],
                        ],
                    ],
                    // http://docs.mongodb.org/manual/tutorial/install-mongodb-on-linux/
                    5 => ['chap' => 'Installing MongoDB on Debian / Ubuntu Linux',
                        'topic' => [1 => ['item' => 'Find the version of Linux', 'answer' => ['Run <b>uname -a</b> from a terminal window']],
                            2 => ['item' => 'Download from browser and install', 'answer' => ['Go to Downloads: <b>www.mongodb.org/downloads</b>', 'Double click on the completed download filename', 'Extract to an appropriate folder', 'Create <b>mongodb</b> user', 'Create <b>/data/db</b>', 'Assign ownership to <b>mongodb</b> user']],
                            3 => ['item' => 'Install from the command line: Ubuntu Linux', 'answer' => ['Import MongoDB public key: <br /><b>sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10</b>', 'Configure software sources list: <br /><b>echo "deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen" <br />| sudo tee /etc/apt/sources.list.d/mongodb.list</b>', 'Install: <br /><b>sudo apt-get install mongodb-10gen</b>']],
                            4 => ['item' => 'Install from the command line: Debian Linux', 'answer' => ['Import MongoDB public key: <br /><b>sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10</b>', 'Configure software sources list: <br /><b>echo "deb http://downloads-distro.mongodb.org/repo/debian-sysvinit dist 10gen" <br />| sudo tee /etc/apt/sources.list.d/mongodb.list</b>', 'Install: <br /><b>sudo apt-get install mongodb-10gen</b>']],
                            5 => ['item' => 'Start / Stop MongoDB', 'answer' => ['Open another command prompt', 'Start: <b>sudo service mongod start</b>', 'Stop: <b>sudo service mongod stop</b>', 'Restart:  <b>sudo service mongod restart</b>', 'Start after reboot: ']],
                            6 => ['item' => 'Connect to MongoDB', 'answer' => ['Open another command prompt', 'Start the MongoDB service', 'Connect to the MongoDB shell: <b>mongo</b>', 'Use the default database: <b>use mydb</b>', 'Save a test document: <b>db.test.save({a:1})</b>', 'Find the test document: <b>db.test.find()</b>']],
                        ],
                    ],
                    6 => ['chap' => 'Installing MongoDB on RedHat / CentOS / Fedora Linux',
                        'topic' => [1 => ['item' => 'Find the version of Linux', 'answer' => ['Run <b>uname -a</b> from a terminal window']],
                            2 => ['item' => 'Download from browser and install', 'answer' => ['Go to Downloads: <b>www.mongodb.org/downloads</b>', 'Double click on the completed download filename', 'Extract to an appropriate folder', 'Create <b>mongodb</b> user', 'Create <b>/data/db</b>', 'Assign ownership to <b>mongodb</b> user']],
                            //http://stackoverflow.com/questions/11081822/mongodb-service-not-running-in-fedora/11083391#11083391
                            3 => ['item' => 'Install from the command line', 'answer' => ['Documented installation does not work!', 'yum erase mongodb', 'yum erase mongo-10gen', 'yum --disablerepo=* --enablerepo=fedora,updates install mongodb mongodb-server']],
                            4 => ['item' => 'Start / Stop MongoDB', 'answer' => ['Open another command prompt', 'Start: <b>systemctl start mongod.service</b>', 'Stop: <b>systemctl stop mongod.service</b>', 'Restart:  <b>systemctl restart mongod.service</b>', 'Start after reboot: <b>systemctl enable mongod.service</b>']],
                            5 => ['item' => 'Connect to MongoDB', 'answer' => ['Open another command prompt', 'Start the MongoDB service', 'Connect to the MongoDB shell: <b>mongo</b>', 'Use the default database: <b>use mydb</b>', 'Save a test document: <b>db.test.save({a:2})</b>', 'Find the test document: <b>db.test.find()</b>']],
                        ],
                    ],
                    7 => ['chap' => 'Programming language drivers: C, C++, C#',
                        // http://docs.mongodb.org/ecosystem/drivers/
                        'topic' => [1 => ['item' => 'Why are drivers important?', 'answer' => ['Using the <b>mongo</b> command shell is of limited usefulness', 'Opens up MongoDB to real world applications']],
                            2 => ['item' => 'What drivers are available?', 'answer' => ['JavaScript, Python, Ruby, <br />PHP, Perl, Java, Scala, <br />C#, C, C++, <br />Haskell, Erlang']],
                            3 => ['item' => 'How do you install a driver?', 'answer' => ['Check for pre-compiled binary or installer package', 'Specific instructions next']],
                            4 => ['item' => 'C, C++ and C#', 'answer' => ['Get <b>c</b> driver source from <b>github.com/mongodb/mongo-c-driver</b>', 'MongoDB is written in C++', 'For C# get <b>msi</b> and <b>zip</b> files from <b>github.com/mongodb/mongo-csharp-driver/releases</b>']],
                        ],
                    ],
                    8 => ['chap' => 'Drivers: Javascript, Python and Ruby',
                        // http://docs.mongodb.org/ecosystem/drivers/
                        'topic' => [1 => ['item' => 'Javascript, Python and Ruby', 'answer' => ['Javascript runs server-side using Node.js or as the shell', 'Python driver best installed using <b>pip</b> or <b>easy_install</b>', 'Ruby driver supported as a "gem"']],
                        ],
                    ],
                    9 => ['chap' => 'Drivers: Java, PHP, perl, others',
                        // http://docs.mongodb.org/ecosystem/drivers/
                        'topic' => [1 => ['item' => 'Java',
                            'answer' => ['Java driver jar file: central.maven.org/maven2/org/mongodb/mongo-java-driver/',
                                'Java driver source: github.com/mongodb/mongo-java-driver/']],
                            2 => ['item' => 'PHP',
                                'answer' => ['MongoDB PHP driver should be installed using <b>pecl</b>',
                                    'Make sure you have installed <b>pear</b> which also installs <b>pecl</b>']],
                            3 => ['item' => 'perl',
                                'answer' => ['For Windows and Mac: use <b>cpan</b>', 'For Linux: find the appropriate MongoDB perl driver package']],
                            4 => ['item' => 'Other Programming Languages', 'answer' => ['Erlang', 'Scala', 'Community Supported']],

                        ],
                    ],
                    10 => ['chap' => 'Management tools',
                        'topic' => [1 => ['item' => 'Are there any management tools available?', 'answer' => ['Fang of Mongo, UMongo, MongoExplorer, MongoHub', 'MongoVision, MongoVUE, Opricot, phpMoAdmin', 'RockMongo, Genghis, mongobird, Robomongo']],
                        ],
                    ],
                    11 => ['chap' => 'MongoDB configuration, import and export',
                        // http://docs.mongodb.org/manual/reference/configuration-options/
                        'topic' => [1 => ['item' => 'How do I configure MongoDB?', 'answer' => ['Edit the <i>mongodb.conf</i> file', 'More info: docs.mongodb.org/manual/reference/configuration-options/']],
                            2 => ['item' => 'How do you export data?', 'answer' => ['<b>mongoexport --host &lt;name>&lt;:port> --db DDD --collection CCC --out &lt;FILE><br />[--query &lt;JSON> --username &lt;username> --password &lt;password>]</b>', 'docs.mongodb.org/manual/reference/program/mongoexport/', '', '']],
                            3 => ['item' => 'How do you import data?', 'answer' => ['<b>mongoimport --host &lt;name>&lt;:port> --db DDD --collection CCC --file &lt;FILE> <br />[--type &lt;json|csv|tsv>]</b>', 'docs.mongodb.org/manual/reference/program/mongoimport/', '', '']],
                        ],
                    ],
                    12 => ['chap' => 'Using the <i>mongo</i> built-in javascript shell: access, insert,find',
                        // http://docs.mongodb.org/manual/tutorial/getting-started-with-the-mongo-shell/
                        'topic' => [1 => ['item' => 'What is the mongo javascript shell?', 'answer' => ['Javascript based interactive interface', 'Lets you interact with MongoDB directly']],
                            2 => ['item' => 'Why is the mongo javascript shell important?', 'answer' => ['You are dealing with the data directly', 'You can see EXACTLY what is in the database']],
                            4 => ['item' => 'How do you access a database?', 'answer' => ['show databases', '<b>db</b> shows the current database', '<b>use</b> selects a database']],
                            5 => ['item' => 'How do you create a new collection?', 'answer' => ['show collections', 'db.<i>collection</i>.save({document})']],
                            6 => ['item' => 'How do you find documents in a collection?', 'answer' => ['db.collection.find()', 'db.collection.find( { field : "value" } )']],
                        ],
                    ],
                    13 => ['chap' => 'Using the <i>mongo</i> built-in javascript shell: update, remove, functions',
                        // http://docs.mongodb.org/manual/tutorial/getting-started-with-the-mongo-shell/
                        'topic' => [1 => ['item' => 'How do you update documents in a collection?', 'answer' => ['db.collection.update( { &lt;query> }, {$set: { field: "value" }} )']],
                            2 => ['item' => 'How do you remove documents from a collection?', 'answer' => ['db.collection.remove( { &lt;query> } )']],
                            3 => ['item' => 'How do you use javascript functions in the shell?', 'answer' => ['db.system.js.save()', 'db.eval("function-name")']],
                        ],
                    ],
                    14 => ['chap' => 'LAB Instructions: Install MongoDB and the PHP driver',
                        // https://www.udemy.com/blog/modern-language-wars/
                        // http://w3techs.com/technologies/details/pl-php/all/all
                        // http://news.netcraft.com/archives/2013/01/31/php-just-grows-grows.html
                        'topic' => [1 => ['item' => 'Why PHP?', 'answer' => ['Easily understood language', 'Used on over 244 M websites as of 1-1-2013 (Netcraft)', 'Largest number of developers']],
                            2 => ['item' => 'Make sure you have LAMP / MAMP / XAMPP installed', 'answer' => ['Not covered in this course']],
                            3 => ['item' => 'Install MongoDB', 'answer' => ['mongodb.org/downloads']],
                            4 => ['item' => 'Test using <b>mongo</b> shell', 'answer' => ['Open a command prompt', 'Make sure MongoDB is running', 'c:\mongodb\bin\mongod -f c:\mongodb\mongod.cfg', 'Open a MongoDB shell:', 'c:\mongodb\bin\mongo']],
                            5 => ['item' => 'Install the PHP programming language driver', 'answer' => ['']],
                            6 => ['item' => 'Run the <b>test.php</b> script', 'answer' => ['']],
                        ],
                    ],
                    15 => ['chap' => 'LAB Solution: Install MongoDB and the PHP driver',
                        'topic' => [1 => ['item' => 'Solution', 'answer' => ['']],
                        ],
                    ],
                ],
                'c-r-u-d-operations' => [
                    1 => ['chap' => 'Performing Queries: Overview',
                        'topic' => [1 => ['item' => 'How do you establish query criteria?', 'answer' => ['Criteria consists of one or more fields', 'Use the minimum number of fields to identify the document', 'Demo: customers collection']],
                            // http://docs.mongodb.org/manual/reference/operator/query/
                            2 => ['item' => 'What <i>query operators</i> are available?', 'answer' => ['Query operators modify the query', 'Comparison: $gt, $gte, $in, $lt, $lte, $ne, $nin', 'Logical: $and, $or, $not, $nor', 'Element: $exists, $type', 'Evaluation: $mod, $regex, $where', 'Geospatial: $geoWithin, $geoIntersects, $near, $nearSphere', 'Array: $all, $elemMatch, $size']],
                            3 => ['item' => 'What are projections?', 'answer' => ['find( { query }, { projection } )', 'Allows you to specify which fields are returned', 'In the projection document, 1 = include, 0 = exclude', 'find( {query},{name:1,_id:0})']],
                            4 => ['item' => 'What <i>projection operators</i> are available?', 'answer' => ['$, $elemMatch, $slice']],
                            5 => ['item' => 'What about <i>modifiers</i>?', 'answer' => ['Included in the query:', '$comment, $explain, $hint, $maxScan, $max, $min', '$orderBy, $returnKey, $showDiskLoc, $snapshot, $query, $natural', 'Outside the query:', 'explain(), hint(), limit(), max(), min(), sort(), snapshot()']],
                            6 => ['item' => 'How can you optimize queries?', 'answer' => ['Create an index to cover fields used in query', 'db.collection.ensureIndex({field:1})', '1 = ascending, -1 = descending', 'Use projections and limit() to limit fields and documents returned', 'Use explain() to analyze performance', 'Use hint() to force MongoDB to use a particular index']],
                        ],
                    ],
                    2 => ['chap' => 'Performing Queries: Using the Cursor',
                        'topic' => [1 => ['item' => 'What is a <i>cursor</i>?', 'answer' => ['Pointer to the result set of a query', 'You need to <i>iterate</i> through a cursor to retrieve results', 'Cursors timeout after 10 minutes of inactivity']],
                            2 => ['item' => 'How do you produce a <i>cursor</i>?', 'answer' => ['Cursor produced from <i>find()</i>', 'Performance is enhanced if find() uses an index']],
                            3 => ['item' => 'How do you use the <i>cursor</i>?', 'answer' => ['MongoDB command shell iterates automatically', 'When using a driver, use a loop']],
                        ],
                    ],
                    3 => ['chap' => 'Performing Queries: Query Modifications -- Part 1',
                        'topic' => [1 => ['item' => 'How can you limit the fields returned?', 'answer' => ['Use projections', 'find({query},{field1:1,field2:0})', '1 = include, 0 = exclude']],
                            2 => ['item' => 'How do you limit the number of documents returned?', 'answer' => ['db.collection.find().limit()']],
                            3 => ['item' => 'How do you find one document?', 'answer' => ['db.collection.findOne()', 'db.collection.find().limit(1)']],
                            4 => ['item' => 'How do you find a document where the value is in an array?', 'answer' => ['db.world_gdp.find({"field.element":{value}})']],
                        ],
                    ],
                    4 => ['chap' => 'Performing queries: Query Modifications -- Part 2',
                        'topic' => [1 => ['item' => 'How do you sort documents?', 'answer' => ['db.collection.find().sort()']],
                            2 => ['item' => 'How do you group documents?', 'answer' => ['db.collection.distinct()', 'db.collection.aggregate()']],
                        ],
                    ],
                    5 => ['chap' => 'Adding Information: Database, Collection and Document',
                        'topic' => [1 => ['item' => 'How do you create a new database?', 'answer' => ['Type <b>use <i>name</i></b> where <i>name</i> is the new database', 'Add a document to a collection']],
                            // c-r-u-d-ops-add-info-new-db.php
                            2 => ['item' => 'How do you create a new collection?', 'answer' => ['Select a database: <i>use name</i>', 'Save a document: <i><b>db.name-of-collection.save({document})</b></i>', 'A collection <i>name-of-collection</i> will be created', 'Alternatively use <i>insert()</i> instead of <i>save()</i>']],
                            3 => ['item' => 'How do you insert a single document?', 'answer' => ['<i>db.name-of-collection.save({document})</i>', '<i>db.name-of-collection.insert({document})</i>']],
                            // c-r-u-d-ops-add-info-batch-insert.php
                            4 => ['item' => 'How can you insert a group of documents in a batch?', 'answer' => ['<i>db.name-of-collection.insert(array of [{document},{document}])</i>', 'May want to specify the <i>write concern</i>']],
                            // c-r-u-d-ops-add-info-different-fields.php
                            5 => ['item' => 'Can you have different fields?', 'answer' => ['Yes']],
                            6 => ['item' => 'What problems can occur when adding information?', 'answer' => ['Beware of typos! You could accidentally create a new database or collection.']],
                        ],
                    ],
                    6 => ['chap' => 'Adding Information: Arrays',
                        // c-r-u-d-ops-add-info-arrays.php
                        'topic' => [1 => ['item' => 'What if your document contains arrays?', 'answer' => ['No problem: use your programming language array syntax']],
                            // c-r-u-d-ops-add-info-arrays-associative.php
                            2 => ['item' => 'Are numeric and associative arrays handled differently?', 'answer' => ['Numeric:', 'Reference elements by number', 'In the MongoDB shell: field:[ value, value ]', 'Associative:', 'Reference elements by label', 'In the MongoDB shell: field:[{label1:value1,label2:value2},{etc.}]']],
                            // c-r-u-d-ops-add-info-arrays-find.php
                            3 => ['item' => 'How do you find info in array fields?', 'answer' => ['Use <i>find()</i>', 'Numeric arrays: use <i>$in</i>', 'Associative arrays: use <i>array.key</i> syntax']],
                        ],
                    ],
                    7 => ['chap' => 'Adding Information: Objects',
                        // c-r-u-d-ops-add-info-objects.php
                        'topic' => [1 => ['item' => 'What if your document contains objects?', 'answer' => ['Programming language objects should not have private or protected properties']],
                            // c-r-u-d-ops-add-info-objects-in-objects.php
                            2 => ['item' => 'What about objects inside objects?', 'answer' => ['Make sure the internal objects are represented as public properties']],
                            // c-r-u-d-ops-add-info-objects-find.php
                            3 => ['item' => 'How do you find info in object fields?', 'answer' => ['Use <i>find()</i> and the <i>object-field.property</i> syntax']],
                        ],
                    ],
                    8 => ['chap' => 'Adding Information: the _id field',
                        'topic' => [1 => ['item' => 'Should you include or exclude the <b>_id</b> field?', 'answer' => ['<i>_id</i> is like an RDBMS "auto-increment" field', 'If <i>_id</i> is not specified, MongoDB creates this for you', 'If you specify <i>_id</i> it <b>must</b> be unique within the collection!', 'ObjectID is generated by the client', '4 byte Timestamp . 3 byte machine ID . 2 byte PID . 3 byte counter', 'More info: docs.mongodb.org/manual/reference/object-id/']],
                            2 => ['item' => 'What are the advantages of overwriting the <b>_id</b> field?', 'answer' => ['Easier to locate documents']],
                            3 => ['item' => 'What are the disadvantages of overwriting the <b>_id</b> field?', 'answer' => ['Duplicate key error can occur when inserting a document while overwriting the <i>_id</i> field', 'Fatal error: Uncaught exception MongoCursorException with message localhost:27017: E11000 duplicate key error index: mydb.collection.$_id_  dup key: { : ObjectId(528908a9ef5c881f68000000) }']],
                            4 => ['item' => 'How can you uniquely ID a document without overwriting <b>_id</b>?', 'answer' => ['Add an additional field with a your own unique identifying system']],
                            // c-r-u-d-ops-add-info-_id-field-find.php
                            // c-r-u-d-ops-add-info-_id-field.php
                            // c-r-u-d-ops-add-info-_id-field-duplicate.php
                        ],
                    ],
                    9 => ['chap' => 'Performing Modifications: Basic Document Updates',
                        // http://docs.mongodb.org/manual/reference/method/db.collection.update/#db.collection.update
                        // c-r-u-d-ops-update-single.php
                        'topic' => [1 => ['item' => 'How do you update a single document?', 'answer' => ['Using <i>update({query},{update})</i>']],
                            // c-r-u-d-ops-update-multi.php
                            2 => ['item' => 'Can you update multiple documents?', 'answer' => ['Yes: using <i>update({query},{update},{upsert},{multi => TRUE}</i>', 'If <i>multi</i> is TRUE, all documents matching <i>query</i> are updated', 'Default value of <i>multi</i> = FALSE']],
                            // c-r-u-d-ops-update-set-rename.php
                            3 => ['item' => 'What basic update operators are available?', 'answer' => ['Basic: $inc, $set, $unset, $rename, $setOnInsert', 'More info: docs.mongodb.org/manual/reference/operator/update/#id1']],
                            // c-r-u-d-ops-update-save.php
                            4 => ['item' => 'Can you save and update?', 'answer' => ['Using <i>save()</i> or <i>update({query},{update},TRUE)</i>', 'If <i>_id</i> is unique a new document is saved', 'If <i>_id</i> matches the existing document is updated', 'A new document is added if the <i>upsert</i> parameter of <i>update()</i> is TRUE']],
                        ],
                    ],
                    10 => ['chap' => 'Performing Modifications: Updating Arrays and Fields',
                        // http://docs.mongodb.org/manual/reference/method/db.collection.update/#db.collection.update
                        'topic' => [ // c-r-u-d-ops-update-array-value.php
                            1 => ['item' => 'How do you update a value in an array field?', 'answer' => ['<i>update({query:array_element},{$set|$inc:{field.$.array_element:value}})</i>']],
                            // c-r-u-d-ops-update-array-push-each-sort-slice.php
                            2 => ['item' => 'What other update operators are available?', 'answer' => ['Array Operators: $, $addToSet, $pop, $pull, $pullAll, $push, $pushAll', 'Array Modifiers: $each, $slice, $sort', 'Others: $bit, $isolated']],
                            // c-r-u-d-ops-update-add-remove-field.php
                            3 => ['item' => 'How do you add or remove a field?', 'answer' => ['<i>update()</i> using <i>$set</i> or <i>$unset</i>']],
                        ],
                    ],
                    11 => ['chap' => 'Performing Modifications: Deleting Documents',
                        // c-r-u-d-ops-remove-one-doc.php
                        'topic' => [1 => ['item' => 'How do you delete a single document?', 'answer' => ['db.collection.remove({query}, justOne = TRUE)']],
                            // c-r-u-d-ops-remove-many.php
                            2 => ['item' => 'Can you delete a group of documents at one time?', 'answer' => ['db.collection.remove({query}, justOne = FALSE)', '<i>justOne</i> defaults to FALSE']],
                            // c-r-u-d-ops-remove-field.php
                            3 => ['item' => 'Can you remove a single field?', 'answer' => ['db.collection.update({query},{$unset:{field:1}})']],
                            // c-r-u-d-ops-remove-drop-collection-database.php
                            4 => ['item' => 'How do you delete a collection?', 'answer' => ['To remove all documents: db.collection.remove()', 'To remove the collection completely: db.collection.drop()']],
                            5 => ['item' => 'How do you remove a database?', 'answer' => ['Use the database', 'db.dropDatabase()']],
                            6 => ['item' => 'What problems can you run into when removing documents?', 'answer' => ['Be careful to not delete the wrong document!', 'Be aware that if the {query} provided to <i>remove()</i> is null ... <br />you could accidentally erase all documents in the collection!']],
                        ],
                    ],
                    12 => ['chap' => 'LAB Instructions: C.R.U.D. Operations on <br />Sweetscomplete Website',
                        'topic' => [1 => ['item' => 'Deploy the "sweetscomplete" website', 'answer' => ['Create a folder "sweetscomplete" off the document root for your webserver', 'Locate the "sweetscomplete" website files in the Working Files folder for the course', 'Copy these files and folders into the new website folder', 'Assign ownership to your webserver user (i.e. www-data) to:', 'sweetscomplete/captcha', 'sweetscomplete/Model/*.csv and *.bak']],
                            2 => ['item' => 'Test and make sure the website is running', 'answer' => ['From your browser: http://localhost/sweetscomplete/', 'Select "Products" and verify you can scan through the list of products']],
                            3 => ['item' => 'Import sweetscomplete "Products" data into MongoDB', 'answer' => ['mongoimport -d sweetscomplete -c products --headerline --type csv <br />--file /path/to/document/root/Model/sweetscomplete_products.csv']],
                            4 => ['item' => 'Rewrite "Model/Products.php" to use MongoDB instead of a CSV file', 'answer' => ['Look for comments starting with "// ***" for clues', 'Check the Working Files folder "sweetscomplete.complete/Model/Products.php" for a solution']],
                            5 => ['item' => 'Test and make sure the website is running', 'answer' => ['From your browser: http://localhost/sweetscomplete/', 'Select "Products" and verify you can scan through the list of products', 'Correct any errors as needed']],
                        ],
                    ],
                    13 => ['chap' => 'LAB Solution: C.R.U.D. Operations on <br />Sweetscomplete Website',
                        'topic' => [1 => ['item' => 'Solution', 'answer' => ['']],
                        ],
                    ],
                ],
                'data-modeling' => [
                    1 => ['chap' => 'One to One Relationships: Overview',
                        'topic' => [1 => ['item' => 'What is a "one to one" relationship?', 'answer' => ['One item maps directly to another item', 'Example: Person --> Birthdate', 'Example: Vehicle --> Registration Number']],
                            2 => ['item' => 'When would you use a "one to one" relationship?', 'answer' => ['When the amount of data is too large for a single item', 'Split the data into separate collections', 'Provide a common key']],
                            3 => ['item' => 'What is a <i>normalized</i> data model?', 'answer' => ['Collections of data which share common identifying keys', 'Customers --> Purchases --> Products']],
                            4 => ['item' => 'How can you build "one to one" relationships in MongoDB?', 'answer' => ['Use either the "manual", the "embedded", or the "DBRef" approach']],
                        ],
                    ],
                    2 => ['chap' => 'One to One Relationships: Manual Approach',
                        // data-model-1-to-1-manual-approach.php
                        // data-model-1-to-1-class-defs.php
                        'topic' => [1 => ['item' => 'How do you model your data using the "manual" approach?', 'answer' => ['Create separate collections', 'Create a unique identifying key', 'Perform two queries']],
                            2 => ['item' => 'How do you store data using the "manual" approach?', 'answer' => ['var id = ObjectId()', 'db.parent_collection.insert({_id:id, field:value})', 'db.child_collection.insert({field:value,parent_key:id.toString()})']],
                            3 => ['item' => 'How do you query using the "manual" approach?', 'answer' => ['var parent = db.parent_collection.find({query})', 'db.child_collection.find({parent_key:parent._id.toString()})']],
                        ],
                    ],
                    3 => ['chap' => 'One to One Relationships: Embedded Approach',
                        // data-model-1-to-1-embedded-approach.php
                        // data-model-1-to-1-class-defs-embedded.php
                        'topic' => [1 => ['item' => 'What is an "embedded" document?', 'answer' => ['If you think of a document as an object: <br />an embedded document is an object within an object', 'Example: <br />{name:"Joe",address:<br />{street:"Main St.",city:"New York"}}']],
                            2 => ['item' => 'How do you store data using the "embedded" approach?', 'answer' => ['Group the data to be embedded in a child document X', 'Add a field Y in the parent document', 'Assign the child document X to the field Y']],
                            3 => ['item' => 'How would you query info contained in the embedded document?', 'answer' => ['db.collection.find({"parent_field.child_field":value})']],
                        ],
                    ],
                    4 => ['chap' => 'One to One Relationships: DBRef Approach',
                        // data-model-1-to-1-dbref-approach.php
                        // data-model-1-to-1-class-defs-dbref.php
                        'topic' => [1 => ['item' => 'What is a "DBRef"', 'answer' => ['A convention for representing a document in another collection']],
                            2 => ['item' => 'What are the restrictions in using the "DBRef" approach?', 'answer' => ['Not all programming language drivers support this', 'DBRefs supported in: C#, Java, JavaScript, PHP, Python, Ruby', 'DBRefs NOT supported in: C, C++ and perl']],
                            3 => ['item' => 'How do you store data using the "DBRef" approach?', 'answer' => ['db.customers.insert({dbref_field:{"$ref":"collection","$id":ObjectId(of linked document),"$db":"database"});']],
                            4 => ['item' => 'How do you query data from a "DBRef"?', 'answer' => ['Use the appropriate class and method supplied by your driver', 'PHP: MongoCollection::getDBRef']],
                        ],
                    ],
                    5 => ['chap' => 'One to Many Relationships: Overview',
                        'topic' => [1 => ['item' => 'What is a "one to many" relationship?', 'answer' => ['One item maps directly to many related items']],
                            2 => ['item' => 'When would you use a "one to many" relationship?', 'answer' => ['Example: Customer --> Purchases']],
                            3 => ['item' => 'How can you build "one to many" relationships in MongoDB?', 'answer' => ['"Normalized" approach: multiple collections linked with common keys', 'Using an array of embedded documents', 'Using an array of DBRef documents']],
                        ],
                    ],
                    6 => ['chap' => 'One to Many Relationships: Normalized Approach',
                        // data-model-1-to-many-normalized-approach.php
                        // data-model-1-to-many-normalized-approach-make-purchase.php
                        // data-model-1-to-many-normalized-approach-record-purchase.php
                        // data-model-1-to-many-class-defs.php
                        'topic' => [1 => ['item' => 'How do you model your data using the "normalized" approach?', 'answer' => ['Store data in separate collections', 'Create a unique identifying key', 'Perform multiple queries']],
                            2 => ['item' => 'How do you store data using the "normalized" approach?', 'answer' => ['var id = ObjectId()', 'db.parent_collection.insert({_id:id, field:value})', 'db.child_collection.insert({field:value,parent_key:id.toString()})']],
                            3 => ['item' => 'How do you query using the "normalized" approach?', 'answer' => ['var parent = db.parent_collection.find({query})', 'db.child_collection.find({parent_key:parent._id.toString()})']],
                        ],
                    ],
                    7 => ['chap' => 'One to Many Relationships: Embedded Approach',
                        // data-model-1-to-many-embedded-approach.php
                        // data-model-1-to-many-embedded-approach-make-purchase.php
                        // data-model-1-to-many-embedded-approach-record-purchase.php
                        // data-model-1-to-many-class-defs-embedded.php
                        'topic' => [1 => ['item' => 'What is an "embedded" document?', 'answer' => ['If you think of a document as an object: <br />an embedded document is an object within an object', 'Example: <br />{name:"Joe",address:<br />{street:"Main St.",city:"New York"}}']],
                            2 => ['item' => 'How do you store data using the "embedded" approach?', 'answer' => ['Group the data to be embedded in a child document X', 'Add a field Y in the parent document', 'Assign the child document X to the field Y']],
                            3 => ['item' => 'How would you query info contained in the embedded document?', 'answer' => ['db.collection.find({"parent_field.child_field":value})']],
                        ],
                    ],
                    8 => ['chap' => 'One to Many Relationships: DBRef Approach',
                        // data-model-1-to-many-dbref-approach.php
                        // data-model-1-to-many-embedded-approach-make-purchase.php
                        // data-model-1-to-many-embedded-approach-record-purchase.php
                        // data-model-1-to-many-class-defs-dbref.php
                        'topic' => [1 => ['item' => 'What is a "DBRef"', 'answer' => ['A convention for representing a document in another collection']],
                            2 => ['item' => 'What are the restrictions in using the "DBRef" approach?', 'answer' => ['Not all programming language drivers support this', 'DBRefs supported in: C#, Java, JavaScript, PHP, Python, Ruby', 'DBRefs NOT supported in: C, C++ and perl']],
                            3 => ['item' => 'How do you store data using the "DBRef" approach?', 'answer' => ['var id = ObjectId()', 'db.child_collection.insert({_id:id, field:value})', 'db.parent_collection.insert({dbref_field:{"$ref":"parent_collection","$id":id,"$db":name_of_child_database"})']],
                            4 => ['item' => 'How do you query data from a "DBRef"?', 'answer' => ['Use the appropriate class supplied by your driver']],
                        ],
                    ],
                    9 => ['chap' => 'Tree structures: Overview',
                        'topic' => [1 => ['item' => 'What are tree structures?', 'answer' => ['Tree structures represent a hierarchy of items']],
                            2 => ['item' => 'Why would you use tree structures?', 'answer' => ['Use tree structures when the nature of your data is hierarchical']],
                            3 => ['item' => 'What types of tree structures are supported in MongoDB?', 'answer' => ['Parent references', 'Child references', 'Array of ancestors', 'Materialized paths', 'Nested sets']],
                        ],
                    ],
                    10 => ['chap' => 'Tree structures: Parent References',
                        // data-model-tree-approach-include.php, data-model-tree-approach-parent.php
                        'topic' => [1 => ['item' => 'What are "parent" references?', 'answer' => ['A special property "parent"', 'Stores the _id of the document one level up in the tree']],
                            2 => ['item' => 'Why use parent references?', 'answer' => ['Used to navigate tree-structured or hierarchical data']],
                            3 => ['item' => 'How do you implement parent references in MongoDB?', 'answer' => ['When you save a document, include a "parent" property <br />which stores the _id of the level above']],
                        ],
                    ],
                    11 => ['chap' => 'Tree structures: Child References',
                        // data-model-tree-approach-include.php, data-model-tree-approach-children.php
                        'topic' => [1 => ['item' => 'What are "child" references?', 'answer' => ['A special property "children"', 'Stores an array of _ids of the document one level below in the tree']],
                            2 => ['item' => 'Why use child references?', 'answer' => ['Used to navigate tree-structured or hierarchical data']],
                            3 => ['item' => 'How do you implement child references in MongoDB?', 'answer' => ['When you save a document, include a "children" property <br />which stores an array _ids one level below']],
                            4 => ['item' => 'Can you have both parent and child references?', 'answer' => ['Yes, as shown in the example']],
                        ],
                    ],
                    12 => ['chap' => 'LAB Instructions: Build One to Many Model for Purchases',
                        'topic' => [1 => ['item' => 'Import sweetscomplete "Members" data into MongoDB', 'answer' => ['mongoimport -d sweetscomplete -c members --headerline --type csv <br />--file /path/to/document/root/Model/sweetscomplete_members.csv']],
                            2 => ['item' => 'Rewrite "Model/Members.php" to use MongoDB instead of a CSV file', 'answer' => ['Look for comments starting with "// ***" for clues', 'Check the Working Files folder "sweetscomplete.complete/Model/Members.php" for a solution']],
                            3 => ['item' => 'Embed purchases into the "members" collection', 'answer' => ['Complete "Model/purchases_into_members.php"', 'Run the script to move purchase history into "members"']],
                            4 => ['item' => 'Rewrite the "getHistoryById()" method', 'answer' => ['Copy the "getHistoryById()" method from "Purchases.php" into "Members.php"', 'Rewrite using MongoDB']],
                            5 => ['item' => 'Modify "View/members.php"', 'answer' => ['Rewrite using named params instead of offset numbers <br />(i.e. "user_id" instead of 0, etc.)']],
                            6 => ['item' => 'Modify "View/change.php"', 'answer' => ['Use "$member" instance instead of "$purchases" to call "getHistoryById()"']],
                            7 => ['item' => 'Test and make sure the website is running', 'answer' => ['From your browser: http://localhost/sweetscomplete/', 'Select "Members" (top right) and verify you can scan through the list of members', 'Login as "admin@sweetscomplete.com"', 'Select "Admin" and view purchase history for a member', 'Correct any errors as needed']],
                        ],
                    ],
                    13 => ['chap' => 'LAB Solution: Build One to Many Model for Purchases -- Part 1',
                        'topic' => [1 => ['item' => 'Solution', 'answer' => ['']],
                        ],
                    ],
                    14 => ['chap' => 'LAB Solution: Build One to Many Model for Purchases -- Part 2',
                        'topic' => [1 => ['item' => 'Solution', 'answer' => ['']],
                        ],
                    ],
                ],
                'database-management' => [
                    1 => ['chap' => '<b>Database Security Overview</b>',
                        // http://docs.mongodb.org/manual/tutorial/enable-authentication/
                        // http://docs.mongodb.org/manual/tutorial/control-access-to-mongodb-with-kerberos-authentication/
                        'topic' => [1 => ['item' => 'How do you enable authentication?', 'answer' => ['Authentication is disabled by default', 'Configure the <i>mongod.conf</i> file', 'Set the <i>auth</i> mongod.conf setting to "true"', 'For replica set security: set the <i>keyFile</i> setting']],
                            2 => ['item' => 'How do you use <i>auth</i> setting?', 'answer' => ['Set the <i>auth</i> mongod.conf param to <i>true</i>', 'Restart <i>mongod</i>', 'If no users are in the <i>admin</i> database, localhost access is allowed']],
                            // http://docs.mongodb.org/manual/reference/user-privileges/
                            4 => ['item' => 'What are the user privilege roles?', 'answer' => ['What a user can do with the database', 'read, readWrite']],
                            5 => ['item' => 'What are the database admin roles?', 'answer' => ['How a user can manage the database, users, or cluster', 'dbAdmin, userAdmin, clusterAdmin']],
                            6 => ['item' => 'What are the "Any" privileges?', 'answer' => ['[read|readWrite|userAdmin|dbAdmin]AnyDatabase']],
                        ],
                    ],
                    2 => ['chap' => 'How to Add Database and User Administrators',
                        // http://docs.mongodb.org/manual/tutorial/enable-authentication/
                        // http://docs.mongodb.org/manual/tutorial/control-access-to-mongodb-with-kerberos-authentication/
                        'topic' => [1 => ['item' => 'How do you add an overall admin user?', 'answer' => ['Edit mongod.conf and set <i>auth=true</i>', 'Restart <i>mongod</i>', 'Access mongodb using the <i>mongo</i> shell', 'use admin', 'db.addUser("admin","password")']],
                            2 => ['item' => 'How do you add a user administrator?', 'answer' => ['<b>For one database:</b>', 'use db-name', 'db.addUser({user:"xxx",pwd:"xxx",roles:["userAdmin"]})', '<b>For any database:</b>', 'use admin', 'db.addUser({user:"xxx",pwd:"xxx",roles:["userAdminAnyDatabase"]})']],
                            3 => ['item' => 'How do you add a database administrator?', 'answer' => ['<b>For one database:</b>', 'use db-name', 'db.addUser({user:"xxx",pwd:"xxx",roles:["dbAdmin"]})', '<b>For any database:</b>', 'use admin', 'db.addUser({user:"xxx",pwd:"xxx",roles:["dbAdminAnyDatabase"]})']],
                            4 => ['item' => 'How do you perform actions on other databases?', 'answer' => ['use admin', 'db.addUser({user:"xxx",pwd:"xxx",roles:[],otherDBRoles:<br />{db-user:["role"],next-db-user:["role","role"],etc.})']],
                        ],
                    ],
                    3 => ['chap' => 'Managing Users',
                        // http://www.hacksparrow.com/mongodb-add-users-and-authenticate.html
                        'topic' => [1 => ['item' => 'How do you add a user to a single database?', 'answer' => ['use db-name', 'db.addUser({user:"xxx",pwd:"xxx",roles:["read|readWrite"]})']],
                            2 => ['item' => 'How do you add a user to a multiple databases?', 'answer' => ['use admin', 'db.addUser({user:"xxx",pwd:"xxx",roles:[],otherDBRoles:<br />{db-name:["read|readWrite"],other-db-name:["read|readWrite"],etc.}})']],
                            3 => ['item' => 'How do you get a list of database users?', 'answer' => ['Login as a user admin', 'use db-name', 'db.system.users.find()']],
                            4 => ['item' => 'How do you change a user password?', 'answer' => ['Authenticate as user admin', 'use db-name', 'db.changeUserPassword("username","new-password")']],
                            5 => ['item' => 'How do you modify user privileges?', 'answer' => ['Login as a user admin', 'use db-name', 'db.system.users.update({user:"xxx"},{$set:{roles:["readWrite",etc.]}})']],
                            6 => ['item' => 'How do you get rid of a user?', 'answer' => ['Login as a user admin', 'use db-name', 'db.system.users.find({user:"name"})', 'db.removeUser("name")']],
                        ],
                    ],
                    4 => ['chap' => 'Authenticating and Handling Errors',
                        // http://stackoverflow.com/questions/16506000/fail-to-authenticate-in-mongo-as-localhost
                        'topic' => [1 => ['item' => 'How do you authenticate from outside the MongoDB shell?', 'answer' => ['mongo -u name -p password --authenticationDatabase db-name']],
                            2 => ['item' => 'How do you authenticate from inside the MongoDB shell?', 'answer' => ['use db-name', 'db.auth("name","password")']],
                            3 => ['item' => 'How do you authenticate from an application?', 'answer' => ['Depends on your driver', 'PHP: $client = new MongoClient("mongodb://username:password@localhost/db-name")']],
                            4 => ['item' => 'What errors might you see and how can they be resolved?', 'answer' => ['<b>Insufficient rights to perform an operation:</b>', '"$err" : "not authorized for query on db-name.system.namespaces"', 'XXX failed:{ "ok" : 0, "errmsg" : "unauthorized" }', '<b>Did not provide authentication database</b>', 'Error: 18 { code: 18, ok: 0.0, errmsg: "auth fails" }', '<b>Incorrect credentials in application:</b>', 'Uncaught exception XXX ... "localhost:27017: not authorized for XXX on YYY.ZZZ"']],
                            5 => ['item' => 'How do you regain access to a database?', 'answer' => ['Disable <i>auth</i> in mongod.conf', 'Restart <i>mongod</i>', 'use db-name', 'db.system.users.remove()']],
                            6 => ['item' => 'Where can you find more information?', 'answer' => ['docs.mongodb.org/manual/tutorial/enable-authentication', 'docs.mongodb.org/manual/reference/configuration-options']],
                        ],
                    ],
                    5 => ['chap' => '<b>Replication Overview</b>',
                        // http://docs.mongodb.org/manual/core/replication-introduction/
                        'topic' => [1 => ['item' => 'What is replication?', 'answer' => ['Copies of the same data on different servers']],
                            2 => ['item' => 'When would you use replication?', 'answer' => ['Provides redundancy', 'Safeguards data when a server goes down']],
                            3 => ['item' => 'What is a <i>primary</i>?', 'answer' => ['The <i>primary</i> is the <i>mongod</i> instance which accepts read and write requests for the data set']],
                            4 => ['item' => 'What are <i>secondaries</i>?', 'answer' => ['<i>Secondaries</i> store a backup copy of the data set held by the <i>primary</i>']],
                            5 => ['item' => 'What happens when a <i>primary</i> fails?', 'answer' => ['The <i>secondaries</i> elect a new primary']],
                            6 => ['item' => 'When would you use an <i>arbiter</i>', 'answer' => ['An <i>arbiter</i> is a <i>mongod</i> instance which holds no data', 'Use an <i>arbiter</i> if you have an even number of <i>secondaries</i>', 'The <i>arbiter</i> has "voting rights" to help decide ties']],
                            7 => ['item' => 'How can "reads" take advantage of replication?', 'answer' => ['<b>Read preference modes which can be set:</b>', 'primary, primaryPreferred', 'secondary, secondaryPreferred, nearest']],
                            8 => ['item' => 'How many MongoDB instances should go into a replica set?', 'answer' => ['A minimum of 3 is recommended: <br />1 primary and 2 secondaries', 'There is no upper limit', 'Objective: redundancy', 'Geographic considerations may apply']],
                        ],
                    ],
                    6 => ['chap' => 'Configuring a Replica Set: Adding the First Member',
                        'topic' => [1 => ['item' => 'How do you start?', 'answer' => ['Backup any existing data', 'Recommended: start with a fresh MongoDB installation']],
                            2 => ['item' => 'How do you configure replica set names?', 'answer' => ['Add an entry to DNS or the local "/etc/hosts" file', 'Example: mongo0rs0.company.com = replica set rs0, 1st server', 'Make sure you can connect to the secondaries']],
                            3 => ['item' => 'How do you configure the <i>mongod.conf</i> file?', 'answer' => ['Set the parameters as appropriate to your system', 'Comment out <b>bind_ip</b> to allow MongoDB to respond to all network cards', 'You must configure the <b>replSet</b> parameter', 'Example: <b>replSet=rs0</b>', 'Do not set <b>priority</b> here!', 'Master/Slave configuration is not recommended: use replica sets']],
                            4 => ['item' => 'What is the startup sequence?', 'answer' => ['Restart MongoDB', 'Access the <i>mongo</i> shell', 'Authenticate if necessary', 'Initialize: <b>rs.initiate()</b>']],
                            5 => ['item' => 'How do you know the replica set is running?', 'answer' => ['Access the <i>mongo</i> shell', 'The command prompt should reflect the status', 'View status: <b>rs.status()</b>', 'View config: <b>rs.conf()</b>']],
                        ],
                    ],
                    7 => ['chap' => 'Configuring a Replica Set: Adding a Secondary',
                        'topic' => [1 => ['item' => 'How do you start?', 'answer' => ['Make sure MongoDB is installed but stopped', 'Add an entry to DNS or the local "/etc/hosts" file to identify all replica hosts', 'Example: mongo0rs0.company.com, mongo1rs0.company.com, etc.', 'Ensure that the secondary can connect to the primary']],
                            2 => ['item' => 'How many MongoDB instances should go into a set?', 'answer' => ['A minimum of 3 is recommended: <br />1 primary and 2 secondaries', 'Maximum of 7 "voting" members', 'Add as many non-voting members as desired', 'Set <b>priority=0</b> to make a member non-voting']],
                            3 => ['item' => 'How do you configure the <i>mongod.conf</i> file?', 'answer' => ['Set the parameters as appropriate to your system', 'Comment out <b>bind_ip</b> to allow MongoDB to respond to all network cards', 'You must configure the <b>replSet</b> parameter', 'Example: <b>replSet=rs0</b>', 'Do not set <b>priority</b> here!', 'Master/Slave configuration is not recommended: use replica sets']],
                            4 => ['item' => 'How do you initialize the secondary?', 'answer' => ['Follow one of these strategies:', '<b>1A</b> backup the /data/db folder of the primary', '<b>1B</b> restore to the /data/db folder of the secondary', 'OR <b>2A</b> remove all files and folders from the /data/db folder of the secondary']],
                            5 => ['item' => 'What needs to be done on the primary?', 'answer' => ['Add an entry to DNS or the local "/etc/hosts" file to identify the secondaries', 'Example: mongo1rs0.company.com, mongo2rs0.company.com, etc.', 'From the <i>mongo</i> command shell on the primary:', 'rs.add("dns.address|hostname")', 'Wait for the synchronization to occur']],
                            6 => ['item' => 'How do you know the replica set is running?', 'answer' => ['Access the <i>mongo</i> shell', 'The command prompt should reflect the status', 'View status: <b>rs.status()</b>', 'View config: <b>rs.conf()</b>']],
                        ],
                    ],
                    8 => ['chap' => 'Configuring a Replica Set: Reconfiguring or Removing',
                        'topic' => [1 => ['item' => 'How do you set "primary" or "secondary"?', 'answer' => ['An up-to-date MongoDB instance with the <br />highest <b>priority</b> setting will become the Primary']],
                            2 => ['item' => 'How do you use <b>rs.reconfig()</b> to set the priority?', 'answer' => ['View config: <b>rs.conf()</b>', 'Make a note of the <b>_id</b> number under members', 'Assign config to a variable: <b>config = rs.conf()</b>', 'Set the priority: <b>config.members[X].priority=N</b>', 'Where <b>X</b> is the member _id to change', 'and where <b>N</b> is the priority number', 'Reconfigure: <b>rs.reconfig(config)</b>']],
                            3 => ['item' => 'How else can you use <b>rs.reconfig()</b>?', 'answer' => ['Remove replica set members', 'Rename DNS or hostnames']],
                            4 => ['item' => 'What has to be done before removing a member?', 'answer' => ['Stop MongoDB on the replica set member to be removed', 'Disable the <b>replSet</b> setting in the mongod.conf file']],
                            5 => ['item' => 'How do you use <b>rs.remove()</b>?', 'answer' => ['Connect to the Primary', 'Use <b>db.isMaster()</b> to ensure the replica member is the Primary', '<b>Type:</b> rs.remove("dns.address|hostname")', '<b>Or:</b> rs.remove("dns.address|hostname:port")']],
                            6 => ['item' => 'How do you force a member to become primary?', 'answer' => ['From the mongo shell of the current primary: <b>rs.stepDown(120)</b>', 'From the mongo shell of the undesired secondaries: <b>rs.freeze(120)</b>', 'The remaining secondary will become primary', 'Alternatively:', 'use local', 'db.system.replset.update({_id:"rs0"},{$set:{members:[{_id:0,host:"HOSTNAME:27017"}]}})']],
                        ],
                    ],
                    /*
                    9 => [    'chap' => 'Replica Set Security',
                    // http://docs.mongodb.org/manual/core/inter-process-authentication/#replica-set-security
                    'topic' => [1 => ['item' => 'How do you configure replica set security?', 'answer' => ['Generate a <i>key file</i>','In the <i>mongod.conf</i> file:','keyFile=/path/to/key-file-generated','Copy file to all members of the replica set','Contents need to be same for all members of replica set','Restart MongoDB on all servers in the set']],
                    // http://docs.mongodb.org/manual/tutorial/generate-key-file/
                    2 => ['item' => 'What goes into a key file?', 'answer' => ['ASCII text file','Any <b>base64</b> characters:','A-Z, a-z, 0-9, + /','6 to 1024 characters in length','On *nix systems: no rights outside of owner']],
                    // http://stackoverflow.com/questions/94445/using-openssl-what-does-unable-to-write-random-state-mean
                    3 => ['item' => 'Can you generate a key file?', 'answer' => ['<b>openssl rand -base64 741</b>','NOTE: grant permissions to the ".rnd" file in your home folder']],
                    ],
                    ],
                     */
                    9 => ['chap' => 'Replica Set Troubleshooting',
                        // http://docs.mongodb.org/manual/core/inter-process-authentication/#replica-set-security
                        'topic' => [1 => ['item' => 'What if you have two primaries?', 'answer' => ['You can run <b>rs.initiate()</b> ONLY on the first member of the replica set!', 'On the secondary which acts like a primary, clear the folder indicated by <b>dbpath</b>', 'Restart the secondary']],
                            2 => ['item' => 'What if the primary can "see" the secondary, <br />but not the other way around?', 'answer' => ['Run <b>rs.conf()</b> and make sure all servers can access all hostnames', 'Check firewall settings']],
                            3 => ['item' => 'What about firewall settings?', 'answer' => ['You need to allow an exception for MongoDB', 'Messages you might see when attempting to sync:', '<b>SELinux:</b> security alert', '<b>Windows:</b> Windows Firewall alert']],
                            4 => ['item' => 'What if replicas are not syncing?', 'answer' => ['<b>FIRST:</b> run rs.conf()', 'Make sure all hostnames are entered into DNS', 'or in the local "hosts" file of all computers in the replica set', '<b>THEN TRY:</b>', 'ping hostname|DNS name', 'mongo --host hostname|DNS name --port 27017', 'Correct any communcations errors']],
                            5 => ['item' => 'What if you have only one secondary?', 'answer' => ['use local', ' db.system.replset.update({_id:"XXX"},{$set:{members:[{_id:0,host:"HHH:27017"}]}})', 'Where "XXX" is the replica set ID', 'and "HHH" is the hostname of the secondary', 'Restart MongoDB']],
                            6 => ['item' => 'How can you get more information?', 'answer' => ['docs.mongodb.org/manual/tutorial/troubleshoot-replica-sets/']],
                        ],
                    ],
                    10 => ['chap' => '<b>Sharding Overview</b>',
                        //http://docs.mongodb.org/manual/reference/program/mongos/#bin.mongos
                        'topic' => [1 => ['item' => 'What is "sharding"?', 'answer' => ['Splitting a single collection among several MongoDB instances', 'In production, each shard should be a <b>replica set</b>']],
                            2 => ['item' => 'Why would you use sharding?', 'answer' => ['When a collection becomes too large for a single server']],
                            3 => ['item' => 'What is a "sharded cluster"?', 'answer' => ['A combination of the following:', 'MongoDB Shard Routing Service (mongos)', 'Configuration Server', 'Two or more shards']],
                            4 => ['item' => 'How is key space allocated?', 'answer' => ['Range based', 'Hash function based']],
                            5 => ['item' => 'How should you choose a shard key?', 'answer' => ['The key should be:', 'Relatively random, and', 'Provide for an even distribution of data']],
                        ],
                    ],
                    11 => ['chap' => 'Implementing Sharding',
                        'topic' => [1 => ['item' => 'How do you start the <i>config server(s)</i>?', 'answer' => ['In production have 3 separate config servers', 'Add a DNS or "hosts" file host name for each config server', 'Make a data folder (i.e. /data/configdb)', 'mongod --configsvr --dbpath path-to-data-folder --port 27019']],
                            2 => ['item' => 'How do you start the <i>mongos</i> instance(s)?', 'answer' => ['Assign a DNS or "hosts" file name to the <i>mongos</i> instance', 'mongos --port 27018 --configdb config-server-host-1, config-server-host-2, etc.']],
                            3 => ['item' => 'How do you add shards to the cluster?', 'answer' => ['<b>Connect to the <i>mongos</i> instance:</b>', 'mongo --host mongos-hostname --port 27018', '<b>Add shard to stand-alone MongoDB instance:</b>', 'sh.addShard("hostname:port")', '<b>Add shard to a MongoDB replica set:</b>', 'sh.addShard("rs/hostname:port")', 'Where "rs" is the replica set identifier']],
                            4 => ['item' => 'How do you enable sharding for a database?', 'answer' => ['<b>Connect to the <i>mongos</i> instance:</b>', 'mongo --host mongos-hostname --port 27018', '<b>Enable sharding for database "db-name":</b>', 'sh.enableSharding("db-name")']],
                            5 => ['item' => 'How do you enable sharding for a collection', 'answer' => ['Identify one or more fields to be used as the <i>shard key</i>', 'If the collection contains data:', 'Create an index on the shard key field(s): <b>ensureIndex()</b>', '<i>Enable sharding for the collection:</i>', 'sh.shardCollection("db-name.collection",{shard_key_field_1: 1 [,shard_key_field_2: 1]})']],
                            6 => ['item' => 'How can you confirm sharding is successful?', 'answer' => ['<b>Connect to the <i>mongos</i> instance:</b>', 'mongo --host mongos-hostname --port 27018', 'sh.status()']],
                        ],
                    ],
                    12 => ['chap' => '<b>Indexing and Performance Considerations</b>',
                        'topic' => [1 => ['item' => 'How does an index affect performance?', 'answer' => ['Indexes will greatly enhance database queries']],
                            2 => ['item' => 'How do you create an index?', 'answer' => ['Create an index on fields usually involved in queries', '<i>db.collection.ensureIndex({field(s)})</i>']],
                            // http://docs.mongodb.org/manual/faq/developers/#why-are-mongodb-s-data-files-so-large
                            3 => ['item' => 'How can you reduce MongoDB file sizes?', 'answer' => ['MongoDB pre-allocates space to increase speed', 'Change the <i>smallfiles</i> setting in <i>mongod.conf</i>']],
                            // http://docs.mongodb.org/manual/faq/developers/#how-do-i-optimize-storage-use-for-small-documents
                            4 => ['item' => 'How can you reduce the overhead for each document?', 'answer' => ['By default <i>_id</i> is a 12 byte ObjectId', 'Explicitly set <i>_id</i> to a smaller value', 'Keep field names short', 'Use embedded documents as much as possible']],
                            5 => ['item' => 'What about using GridFS for large files?', 'answer' => ['Store large files as <i>GridFS</i> objects', 'Works well for files larger than 16MB in size', 'Use the <i>mongofiles</i> command from the command line', 'From an application, usage varies', 'PHP uses the <i>MongoGridFS</i> class', 'More info: docs.mongodb.org/manual/core/gridfs/<br />docs.mongodb.org/manual/reference/program/mongofiles/']],
                            // http://docs.mongodb.org/manual/reference/connection-string/#connections-write-concern
                            6 => ['item' => 'What affect does replication have on performance?', 'answer' => ['Read concerns allow you to influence which replica set responds', 'Read concerns can potentially improve performance']],
                            7 => ['item' => 'What affect do "write concerns" have on performance?', 'answer' => ['Strengthening write concerns will improve reliability but reduce performance']],
                        ],
                    ],
                    13 => ['chap' => 'Backup Procedures',
                        'topic' => [1 => ['item' => 'How do you backup a database?', 'answer' => ['<b>mongodump</b>', 'Backing up the <i>dbpath</i> folder', 'From the <i>mongo</i> shell:', 'Copy local database: <b>db.copyDatabase()</b>', 'Copy remote database: <b>db.cloneDatabase()</b>', 'OR: use a replica set!']],
                            2 => ['item' => 'How do you restore data?', 'answer' => ['<b>mongorestore</b>', 'Restoring up the <i>dbpath</i> folder']],
                            3 => ['item' => 'How do you backup a single collection', 'answer' => ['<b>Command line:</b>', 'mongoexport -d db-name -c collection-name --out export-file [--csv]', 'From the <i>mongo</i> shell:', 'db.cloneCollection()']],
                            4 => ['item' => 'How do you restore a single collection', 'answer' => ['<b>Command line:</b>', 'mongoimport -d db-name -c collection-name --file export-file --type csv|json [--headerline]']],
                            5 => ['item' => 'How do you repair data?', 'answer' => ['Login as a database admin', 'use db-name', 'db.repairDatabase()']],
                            // http://docs.mongodb.org/manual/core/backups/#sharded-cluster-backups
                            // http://docs.mongodb.org/manual/core/backups/#replica-set-backups
                            6 => ['item' => 'How can sharding and replication affect backups?', 'answer' => ['Backing up and restoring individual shards or members of a replica set can pose problems', 'Make sure you backup or restore the <b>entire</b> database on that server', 'If possible, make sure no write operations are taking place']],
                        ],
                    ],
                    14 => ['chap' => 'Monitoring MongoDB',
                        'topic' => [1 => ['item' => 'MongoDB command shell', 'answer' => ['db.stats()', 'db.serverStatus()']],
                            2 => ['item' => 'Command line', 'answer' => ['mongostat', 'mongotop']],
                            3 => ['item' => 'Using management tools', 'answer' => ['MongoBird', 'RockMongo:', 'Make sure authentication is enabled', 'Edit /path/to/rockmongo/config.php and set <br />$MONGO["servers"][$i]["mongo_auth"] = true;']],
                            4 => ['item' => 'How do you monitor the state of the replica set?', 'answer' => ['From the <i>mongo</i> shell:', 'rs.status()', 'rs.conf()']],
                        ],
                    ],
                    15 => ['chap' => 'LAB Instructions: Manage MongoDB Database for Sweetscomplete',
                        'topic' => [1 => ['item' => 'Configure MongoDB for authentication', 'answer' => ['Modify the MongoDB config file', 'Set the "auth" parameter to "true"', 'Restart MongoDB']],
                            2 => ['item' => 'Create an admin database user', 'answer' => ['Access the <b>mongo</b> command shell', 'use admin', 'db.addUser("admin","password")']],
                            3 => ['item' => 'Create a user with "readWrite" privileges', 'answer' => ['From the <b>mongo</b> shell as an admin user:', 'use sweetscomplete', 'db.addUser({user:"sweet",pwd:"password",roles:[{"readWrite"}]})']],
                            4 => ['item' => 'Verify the website no longer works', 'answer' => ['From your browser: http://localhost/sweetscomplete', 'The website should no longer be working']],
                            5 => ['item' => 'Add authentication to "Products.php" and "Members.php"', 'answer' => ['Modify the "getClient()" method in "Model/Products.php" and "Model/Members.php"', 'Add a connection string: new MongoClient("mongodb://sweet:password@localhost/sweetscomplete")']],
                            6 => ['item' => 'Add indexes to improve performance', 'answer' => ['Go into the <b>mongo</b> shell (with authentication)', 'use sweetscomplete', 'db.products.ensureIndex({product_id:1})', 'Establish indexes for these "products" fields:', 'title, special', 'Establish indexes for these "members" fields:', 'user_id, email']],
                            7 => ['item' => 'Backup the Sweetscomplete database', 'answer' => ['From the command line: <b>mongodump</b>']],
                            8 => ['item' => 'Monitor the Sweetscomplete database', 'answer' => ['From the command line: ', '<b>mongostat</b>', '<b>mongotop</b>']],
                        ],
                    ],
                    16 => ['chap' => 'LAB Solution: Manage MongoDB Database for Sweetscomplete',
                        'topic' => [1 => ['item' => 'Solution', 'answer' => ['']],
                        ],
                    ],
                ],
            ],
        ],
    ]],
);

var_dump($convert->arrayToXml($data));
