<?php
    class data
    {
        private const DBUSER    = 'rootuser';
        private const DBPASS    = 'kamran9712121212';
        protected static $instance;
    
        public static function db($dbname)
        {
            if(!self::$instance){
                self::$instance = new MongoDB\Client('mongodb://'.self::DBUSER.':'.self::DBPASS.'@mylab-shard-00-00.dzks5.mongodb.net:27017,mylab-shard-00-01.dzks5.mongodb.net:27017,mylab-shard-00-02.dzks5.mongodb.net:27017/MyLab?ssl=true&replicaSet=atlas-31i29v-shard-0&authSource=admin&retryWrites=true&w=majority');
                $db = self::$instance;
                return $db->$dbname;
            }    
        }
        
    }
?>