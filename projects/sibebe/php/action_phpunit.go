package php

import (
    "fmt"
    "github.com/ktom/sibebe/utils"
    "os/exec"

    "github.com/ktom/sibebe/sibebe"
)

func PhpunitAction(packageDir string) sibebe.ActionResult {
    result := sibebe.ActionResult{Name: "phpunit"}
    phpunit := packageDir + "/vendor/bin/phpunit"

    if !utils.FileExists(phpunit) {
        result.Success = false
        result.Output = fmt.Sprintln("PHPUnit not found in package", packageDir, " => skipped")

        return result
    }

    if !utils.DirExists(packageDir +"/tests") {
        result.Success = false
        result.Output = fmt.Sprintln("No tests directory found in", packageDir)

        return result
    }

    //if _, err := os.Stat(packageDir + "/vendor/bin/phpunit"); os.IsNotExist(err) {
    //    result.Success = false
    //    result.Error = err
    //    result.Output = fmt.Sprintln("PHPUnit not found in", packageDir, " => skipped")
    //
    //    return result
    //}

    //path, lookPathErr := exec.LookPath(packageDir + "/vendor/bin/phpunit")
    //
    //if lookPathErr != nil {
    //    result.Success = false
    //    result.Error = lookPathErr
    //    result.Output = fmt.Sprintln("PHPUnit not found in", packageDir, " => skipped")
    //
    //    return result
    //}

    //sibebe.PrintVerbose("Running phpunit in", packageDir)

    output := fmt.Sprintln("Executing PHPUnit tests in", packageDir)

    command := exec.Command("vendor/bin/phpunit", "--do-not-cache-result")
    command.Dir = packageDir

    out, err := command.CombinedOutput()

    result.Output = output + string(out)

    if err != nil {
        fmt.Println("phpunit error", packageDir)
        fmt.Println(err)
        result.Success = false
        result.Error = err
    } else {
        result.Success = true
    }

    return result
}
