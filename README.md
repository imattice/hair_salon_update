# Hair Salon

##### Code Review for Epicodus - One-to-Many database relationships, 8-21-2015

#### By Ike Mattice

## Description

Allows the user to manage several independant hair stylists and their clients, individually.  Allows user to edit and delete each stylist and client, as well as clear all data from one of those categories.

## Setup


1. Clone repository from GitHub.
2. Run $ composer install.
3. Run $ mysql.server start
4. Run $ mysql -uroot -proot
5. Run $ apachectl start
6. Import database hair_salon to mysql by logging on to localhost:8080/phpmyadmin and clicking the import button
7. Start php server in web directory.
8. Direct browser to localhost:8000/


## Testing

After the initial set up, you can test the functionality of both classes to ensure correct functionality.

1. In phpMyAdmin, select the database hair_salon and click the "operations" button near the top.
2. Locate the "Copy database to:" section and title the new database hair_salon_test.  Select the structure only option and create this test database by clicking "go".
3. After the test database has been created, you can run $ phpunit tests to run tests for all functions.

## Technologies Used

Twig
Silex
PHPUnit
PHP
mySQL

### Legal


Copyright (c) 2015 Ike Mattice

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
