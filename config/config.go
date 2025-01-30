package config

import (
    "os"
)

var (
    DBUser     = os.Getenv("DB_USER")
    DBPassword = os.Getenv("DB_PASSWORD")
    DBName     = os.Getenv("DB_NAME")
    DBHost     = os.Getenv("DB_HOST")
    DBPort     = os.Getenv("DB_PORT")
)