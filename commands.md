
# Disable MySQL's ONLY_FULL_GROUP_BY in sql_mode

1. Add following line in `/etc/mysql/my.cnf` to disable ONLY_FULL_GROUP_BY in sql_mode
    ```conf
    [mysqld]
    sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"
    ```

2. Restart mysql service
    ```bash
    sudo systemctl restart mysql
    ```

3. Disable `ONLY_FULL_GROUP_BY` in `MySQL`
    ```sql
    SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
    ```
