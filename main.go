package main

import (
	"finance-tracker/database"
	"finance-tracker/routes"
	"log"
	"net/http"
)

func main() {
	// Initialize the database
	dataSourceName := "root@tcp(127.0.0.1:3306)/finance_db"
	if err := database.InitDB(dataSourceName); err != nil {
		log.Fatalf("Could not connect to the database: %v", err)
	}

	// Print success message
	log.Println("Successfully connected to the database")

	// Initialize the routes
	router := routes.InitRoutes()

	// Start the server
	log.Println("Starting server on :8080")
	if err := http.ListenAndServe(":8080", router); err != nil {
		log.Fatalf("Could not start server: %v", err)
	}
}
