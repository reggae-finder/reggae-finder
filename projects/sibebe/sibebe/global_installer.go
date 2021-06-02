package sibebe

import (

)

func (s Sibebe) GlobalInstall() error {
    PrintVerbose("Install dependencies globally\n")

    for _, pack := range s.packs {
        err := pack.GlobalInstall(s.config.GetWorkDir())
        if err != nil { return err }
    }

    return nil
}

func GlobalInstall() error { return s.GlobalInstall() }
