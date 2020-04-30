# Tehtäväpäiväkirjan API

Tehtäväpäiväkirja API contains PHP scripts in a one-per-table basis. Index file is an exception in that it does not communicate with database at all. There are basic CRUD operations for each API. Meaning Create (POST), Read (GET), Update (PUT), and Delete (DELETE) where value in parenthesis is the HTTP method used.

NB! Most important part to change in scripts is to define the location of settings file. Now it is named `my_app_specific_ini` in file [settings.php](settings.php).

NB2! Second most important thing is to define authentication or what authentication is used.

## Setup

Create and modify files on server manually
- [tehtavapaivakirja.ini] with location and name of your choosing

Example content:

```
[api]
user = "[TODO API USER NAME]"
pass = "[TODO API USER PASSWORD]"
[database]
host = "[TODO DATABASE HOST]"
port = [TODO DATABASE PORT]
name = "[TODO DATABASE NAME]"
schm = "[TODO DATABASE SCHEMA]"
user = "[TODO DATABASE USER NAME]"
pass = "[TODO DATABASE USER PASSWORD]"
```

Edit files
- [auth.php](auth.php) and change authentication method to your liking
- [settings.php](settings.php) and change location of settings file now named `my_app_specific_ini`
