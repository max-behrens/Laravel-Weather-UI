<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MyController extends Controller
{
    public function hello() {
        $data = config('admin.admin');
        $data = $data[0];
        $user = ['abc@xyz.com', 'ABC', 'XYZ'];
        return view("welcome.hello", compact('data', 'user'));
    }

    public function insert() {
        $userModel = new User();
        $userModel->insert(); // Call your insert method from the User model

        // Flash a message to the session
        return redirect()->route('users.index')->with('success', 'Record Inserted');
    }

    public function edit() {
        // Your edit logic here
    }

    public function read() {
        // Your read logic here
    }

    public function delete() {
        // Your delete logic here
    }
}