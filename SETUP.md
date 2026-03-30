exit

```

---

Now open the **`.env`** file inside your `task manager` project folder. Find this section:
```

DB_CONNECTION=sqlite

```

Replace that whole block with:
```

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=your_actual_password_here

```

Save the file.

---

Then back in PowerShell, run:
```

php artisan migrate
