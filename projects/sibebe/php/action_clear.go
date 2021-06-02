package php

import (
    "fmt"
    "os"

    "github.com/ktom/sibebe/sibebe"
)

func ClearAction(packageDir string) sibebe.ActionResult {

    if err := os.RemoveAll(packageDir +"/vendor/"); err != nil {
        fmt.Println("clear error")
        return sibebe.ActionResult{Success: false, Error: err}
    }

    return sibebe.ActionResult{Success: true, Output: fmt.Sprintf("Cleared %s\n", packageDir)}
}
