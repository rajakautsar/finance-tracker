package database

import (
    "database/sql"
    _ "github.com/go-sql-driver/mysql"
    "fmt"
)

var DB *sql.DB

func InitDB(dataSourceName string) error {
    var err error
    DB, err = sql.Open("mysql", dataSourceName)
    if err != nil {
        return fmt.Errorf("error opening database: %v", err)
    }

    if err = DB.Ping(); err != nil {
        return fmt.Errorf("error connecting to the database: %v", err)
    }

    return nil
}