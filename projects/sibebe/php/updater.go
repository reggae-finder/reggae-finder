package php

import (
	"fmt"
	"os"
	"os/exec"
	"path/filepath"
)

func (p PhpPack) Update(packages []string) error {

	if _, lookPathErr := exec.LookPath("composer"); lookPathErr != nil {
		return lookPathErr
	}

	for _, pathToComposerJson := range packages {
		fmt.Printf("\nUpdating dependencies in %s\n\n", filepath.Dir(pathToComposerJson))

		command := exec.Command("composer", "update", "--no-interaction", "--optimize-autoloader")
		command.Dir = filepath.Dir(pathToComposerJson)
		command.Stdout = os.Stdout
		command.Stderr = os.Stderr

		err := command.Run()
		if err != nil {
			return err
		}
	}

	return nil
}
