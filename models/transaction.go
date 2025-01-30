package models

type Transaction struct {
    ID     int     `json:"id"`
    Amount float64 `json:"amount"`
    Date   string  `json:"date"`
    Note   string  `json:"note"`
}