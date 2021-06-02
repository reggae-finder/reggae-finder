package sibebe

import (
    "fmt"
)

func (s Sibebe) Gather() error {
    PrintVerbose("Gather dependencies across all packages\n")

    for language, pack := range s.packs {
        // check that we have some packages in the map otherwise nothing to do
        if packages, ok := s.packagesMap[language]; ok {
            global, err := pack.Gather(packages)
            if err != nil { return err }

            fmt.Printf("Gathered dependencies from %s pack\n\n", language)

            if err := pack.DumpGlobal(global, s.config.GetWorkDir()); err != nil {
                return err
            }

            PrintVerbose(global)
            PrintVerbose("")
        }
    }
    return nil
}

func Gather() error { return s.Gather() }
