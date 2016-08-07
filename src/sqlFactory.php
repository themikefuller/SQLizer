<?php

class sqlFactory {

    private $dbs = [];

    public function NewSQL($settings) {
        require_once(__DIR__ . '/sqlizer.php');
        $id = sizeof($this->dbs);
        $this->dbs[$id] = new SQLizer(
                $settings['host'],
                $settings['port'],
                $settings['user'],
                $settings['pass'],
                $settings['name']
        );
        return $this->dbs[$id];
    }

    public function ListCon() {
        $response = [];
        $dbs = $this->dbs;
        $id = 0;
        foreach ($dbs as $db) {
            $response[$id]['id'] = $id;
            $response[$id]['db']= $db;
            $id++;
        }
        return $response;
    }

    public function useCon($id) {
        if (isset($this->dbs[$id])) {
            return $this->dbs[$id];
        } else {
            return false;
        }
    }


    // Add Disconnect in the future here

}
