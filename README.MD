Sorted Linked list
=======

Prerequisites
-------------

Install git: `https://git-scm.com/book/en/v2/Getting-Started-Installing-Git`

Install PHP 8.1 or higher and these PHP extensions (which are installed and enabled by default in most PHP 8 installations): Ctype, iconv, PCRE, Session, SimpleXML, and Tokenizer;
Install Composer, which is used to install PHP packages.
Optionally, you can also install Symfony CLI. This creates a binary called symfony that provides all the tools you need to develop and run your Symfony application locally.

The symfony binary also provides a tool to check if your computer meets all requirements. Open your console terminal and run this command:

`symfony check:requirements`

Plase refer to official documentation: `https://symfony.com/doc/current/setup.html`

Installation
------------

1. `git clone https://github.com/ketyidody/sorted-linked-list.git`
2. `cd sorted-linked-list`
3. edit `.env` file and set your database credentials
4. `composer install`
5. `php bin/console doctrine:migrations:migrate`
6. optional: `symfony server:start`
7. go to `http://localhost:8000/` or where you have linked your application
8. go to `Add` to start adding strings to the list