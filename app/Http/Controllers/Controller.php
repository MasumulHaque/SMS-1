<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class YourController extends BaseController
{
    public function yourMethod()
    {
        // Establish database connection
        $conn = new \mysqli('localhost', 'username', 'password', 'database');

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Use $conn for database operations
        $sql = "SELECT * FROM table";
        $result = $conn->query($sql);

        // Process query result...

        // Close the database connection
        $conn->close();
    }
}
