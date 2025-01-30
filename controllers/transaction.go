package controllers

import (
    "net/http"
    "encoding/json"
    "strconv"
    "github.com/gorilla/mux"
    "finance-tracker/models"
    "finance-tracker/database"
    "finance-tracker/utils"
)

func GetTransactions(w http.ResponseWriter, r *http.Request) {
    rows, err := database.DB.Query("SELECT id, amount, date, note FROM transactions")
    if err != nil {
        utils.RespondWithError(w, http.StatusInternalServerError, "Error fetching transactions")
        return
    }
    defer rows.Close()

    transactions := []models.Transaction{}
    for rows.Next() {
        var t models.Transaction
        if err := rows.Scan(&t.ID, &t.Amount, &t.Date, &t.Note); err != nil {
            utils.RespondWithError(w, http.StatusInternalServerError, "Error scanning transaction")
            return
        }
        transactions = append(transactions, t)
    }

    utils.RespondWithJSON(w, http.StatusOK, transactions)
}

func CreateTransaction(w http.ResponseWriter, r *http.Request) {
    var transaction models.Transaction
    if err := json.NewDecoder(r.Body).Decode(&transaction); err != nil {
        utils.RespondWithError(w, http.StatusBadRequest, "Invalid request payload")
        return
    }

    result, err := database.DB.Exec("INSERT INTO transactions (amount, date, note) VALUES (?, ?, ?)", transaction.Amount, transaction.Date, transaction.Note)
    if err != nil {
        utils.RespondWithError(w, http.StatusInternalServerError, "Error inserting transaction")
        return
    }

    id, err := result.LastInsertId()
    if err != nil {
        utils.RespondWithError(w, http.StatusInternalServerError, "Error getting last insert ID")
        return
    }

    transaction.ID = int(id)
    utils.RespondWithJSON(w, http.StatusCreated, transaction)
}

func GetTransaction(w http.ResponseWriter, r *http.Request) {
    params := mux.Vars(r)
    id, err := strconv.Atoi(params["id"])
    if err != nil {
        utils.RespondWithError(w, http.StatusBadRequest, "Invalid transaction ID")
        return
    }

    var transaction models.Transaction
    err = database.DB.QueryRow("SELECT id, amount, date, note FROM transactions WHERE id = ?", id).Scan(&transaction.ID, &transaction.Amount, &transaction.Date, &transaction.Note)
    if err != nil {
        utils.RespondWithError(w, http.StatusInternalServerError, "Error fetching transaction")
        return
    }

    utils.RespondWithJSON(w, http.StatusOK, transaction)
}

func DeleteTransaction(w http.ResponseWriter, r *http.Request) {
    params := mux.Vars(r)
    id, err := strconv.Atoi(params["id"])
    if err != nil {
        utils.RespondWithError(w, http.StatusBadRequest, "Invalid transaction ID")
        return
    }

    _, err = database.DB.Exec("DELETE FROM transactions WHERE id = ?", id)
    if err != nil {
        utils.RespondWithError(w, http.StatusInternalServerError, "Error deleting transaction")
        return
    }

    utils.RespondWithJSON(w, http.StatusOK, map[string]int{"deleted": id})
}