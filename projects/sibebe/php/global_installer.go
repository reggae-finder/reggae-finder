package php

import (
    "fmt"
    "os"
    "os/exec"

    "github.com/ktom/sibebe/sibebe"
)

func (p PhpPack) GlobalInstall(workDir string) error {
    fmt.Println("Installing php global dependencies from "+ workDir +"/composer.json\n")

    command := exec.Command("composer", "install", "--no-interaction")
    command.Dir = workDir

    if sibebe.GetConfig().IsVerbose() {
        command.Stdout = os.Stdout
        command.Stderr = os.Stderr
    }

    return command.Run()
}
