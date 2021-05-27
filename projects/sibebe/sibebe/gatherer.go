package sibebe

import (

)

func (s Sibebe) Gather() error {
    PrintVerbose("Gather dependencies across all packages\n")

    for language, pack := range s.packs {
        if packages, ok := s.packagesMap[language]; ok {
            global, err := pack.Gather(packages)
            if err != nil { return err }

            PrintVerbose(global)

            if err := pack.DumpGlobal(global, s.config.GetWorkDir()); err != nil {
                return err
            }
        }
    }
    return nil
}

func Gather() error { return s.Gather() }
