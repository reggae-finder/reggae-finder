package php

import (
    "fmt"
    "os/exec"

    "github.com/ktom/sibebe/sibebe"
)

func ComposerInstallAction(packageDir string) sibebe.ActionResult {
    result := sibebe.ActionResult{Name: "composer_install"}

    _, lookPathErr := exec.LookPath("composer")

    if lookPathErr != nil {
        result.Success = false
        result.Error = lookPathErr
        result.Output = fmt.Sprintln("composer not found", packageDir, " => skipped")

        return result
    }

    //sibebe.PrintVerbose("Installing php dependencies from " + packageDir + "/composer.json\n")

    command := exec.Command("composer", "install")
    command.Dir = packageDir

    out, err := command.CombinedOutput()

    result.Output = string(out)

    if err != nil {
        fmt.Println("install error")
        result.Success = false
        result.Error = err
    } else {
        result.Success = true
    }

    return result
}