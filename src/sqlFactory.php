<?php

class sqlFactory {

    private $dbs = [];

    // Create a new connection
    public function NewSQL($settings) {
        // SQLizer
        require_once(__DIR__ . '/sqlizer.php');
        $sqlizer = new SQLizer(
                $settings['host'],
                $settings['port'],
                $settings['user'],
                $settings['pass'],
                $settings['name']
        );
        $sqlizer->id = sizeof($this->dbs);
        $this->dbs[] = $sqlizer;
        return $sqlizer;
    }

    public function ListCon() {
        $response = [];
        $dbs = $this->dbs;
        foreach ($dbs as $db) {
            $response[] = $db['id']; 
        }
        return $response;
    }

    public function useCon($id) {
        if (isset($this->dbs[$id])) {
            $sqlizer = $this->dbs[$id];
        } else {
            return false;
        }
    }


    // Add Disconnect in the future here

}
