package main

import (
    "database/sql"
    "fmt"
    "log"
    "net/http"

    _ "github.com/go-sql-driver/mysql"
)

var db *sql.DB

func main() {
    var err error
    db, err = sql.Open("mysql", "root:@tcp(127.0.0.1:3306)/finance_db")
    if err != nil {
        log.Fatal(err)
    }
    defer db.Close()

    http.HandleFunc("/login", loginHandler)
    http.HandleFunc("/register", registerHandler)

    fmt.Println("Server is running on port 8080")
    log.Fatal(http.ListenAndServe(":8080", nil))
}

func loginHandler(w http.ResponseWriter, r *http.Request) {
    if r.Method == http.MethodPost {
        username := r.FormValue("username")
        password := r.FormValue("password")

        var dbPassword string
        err := db.QueryRow("SELECT password FROM users WHERE username = ?", username).Scan(&dbPassword)
        if err != nil {
            http.Error(w, "Invalid username or password", http.StatusUnauthorized)
            return
        }

        if password == dbPassword {
            fmt.Fprintf(w, "Login successful")
        } else {
            http.Error(w, "Invalid username or password", http.StatusUnauthorized)
        }
    } else {
        http.Error(w, "Invalid request method", http.StatusMethodNotAllowed)
    }
}

func registerHandler(w http.ResponseWriter, r *http.Request) {
    if r.Method == http.MethodPost {
        username := r.FormValue("username")
        password := r.FormValue("password")

        _, err := db.Exec("INSERT INTO users (username, password) VALUES (?, ?)", username, password)
        if err != nil {
            http.Error(w, "Error creating user", http.StatusInternalServerError)
            return
        }

        fmt.Fprintf(w, "User registered successfully")
    } else {
        http.Error(w, "Invalid request method", http.StatusMethodNotAllowed)
    }
}