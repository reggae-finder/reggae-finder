package php

import (
    "fmt"
    "os"

    "github.com/ktom/sibebe/sibebe"
)

func (p PhpPack) DumpGlobal(global fmt.Stringer, path string) error {
    path = path +"/composer.json"
    jsonString := global.String();

    f, err := os.Create(path)
    if err != nil { return err }

    defer f.Close()

    if _, err := f.WriteString(jsonString); err != nil {
        return err
    }

    f.Sync()

    sibebe.PrintVerbose("Dumped global dependencies in "+ path)

    return nil
}
