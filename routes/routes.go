package routes

import (
    "github.com/gorilla/mux"
    "finance-tracker/controllers"
)

func InitRoutes() *mux.Router {
    router := mux.NewRouter()
    router.HandleFunc("/transactions", controllers.GetTransactions).Methods("GET")
    router.HandleFunc("/transactions", controllers.CreateTransaction).Methods("POST")
    router.HandleFunc("/transactions/{id}", controllers.GetTransaction).Methods("GET")
    router.HandleFunc("/transactions/{id}", controllers.DeleteTransaction).Methods("DELETE")
    return router
}