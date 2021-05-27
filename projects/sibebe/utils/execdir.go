package utils

import (
    "fmt"
    "log"
    "path/filepath"
)

func GetExecDir() string {
    execDir, err := filepath.Abs(filepath.Dir("."))

    if err != nil {
        fmt.Println("Failed locating the working directory")
        log.Fatal(err)
    }

    return execDir
}
