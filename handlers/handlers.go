package handlers

import (
    "encoding/json"
    "net/http"
    "github.com/gorilla/mux"
    "finance-tracker/models"
    "finance-tracker/utils"
    "strconv"
)

func GetTransactions(w http.ResponseWriter, r *http.Request) {
    transactions := []models.Transaction{}
    utils.RespondWithJSON(w, http.StatusOK, transactions)
}

func CreateTransaction(w http.ResponseWriter, r *http.Request) {
    var transaction models.Transaction
    if err := json.NewDecoder(r.Body).Decode(&transaction); err != nil {
        utils.RespondWithError(w, http.StatusBadRequest, "Invalid request payload")
        return
    }
    utils.RespondWithJSON(w, http.StatusCreated, transaction)
}

func GetTransaction(w http.ResponseWriter, r *http.Request) {
    params := mux.Vars(r)
    id, err := strconv.Atoi(params["id"])
    if err != nil {
        utils.RespondWithError(w, http.StatusBadRequest, "Invalid transaction ID")
        return
    }
    transaction := models.Transaction{ID: id}
    utils.RespondWithJSON(w, http.StatusOK, transaction)
}

func UpdateTransaction(w http.ResponseWriter, r *http.Request) {
    params := mux.Vars(r)
    id, err := strconv.Atoi(params["id"])
    if err != nil {
        utils.RespondWithError(w, http.StatusBadRequest, "Invalid transaction ID")
        return
    }
    var transaction models.Transaction
    if err := json.NewDecoder(r.Body).Decode(&transaction); err != nil {
        utils.RespondWithError(w, http.StatusBadRequest, "Invalid request payload")
        return
    }
    transaction.ID = id
    utils.RespondWithJSON(w, http.StatusOK, transaction)
}

func DeleteTransaction(w http.ResponseWriter, r *http.Request) {
    params := mux.Vars(r)
    id, err := strconv.Atoi(params["id"])
    if err != nil {
        utils.RespondWithError(w, http.StatusBadRequest, "Invalid transaction ID")
        return
    }
    utils.RespondWithJSON(w, http.StatusOK, map[string]int{"deleted": id})
}