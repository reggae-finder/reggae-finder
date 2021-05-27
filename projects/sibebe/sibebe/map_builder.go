package sibebe

import (
    "fmt"
    "log"
    "os"
    "path/filepath"

    "github.com/jedib0t/go-pretty/v6/table"
)

func (s *Sibebe) buildPackagesMap() {
    PrintVerbose("Building packages map")

    packagesMap := PackagesMap{}
    workDir := s.config.GetWorkDir()

    err := filepath.Walk(workDir, func(path string, info os.FileInfo, err error) error {
        for language, pack := range s.packs {
            if path, ok := pack.BuildMap(info.Name(), path); ok {
                packagesMap[language] = append(packagesMap[language], path)
            }
        }
        return nil
    })

    if err != nil {
        log.Fatal(err)
    }

    s.packagesMap = packagesMap

    if s.config.IsVerbose() {
        fmt.Println(packagesMap.ToTableString()+"\n")
    }
}

type PackagesMap map[string][]string

func (pm PackagesMap) ToTableString() string {
    t := table.NewWriter()
    t.SetTitle("Packages map")
    for language, paths := range pm {
        for _, path := range paths {
            t.AppendRow(table.Row{language, path})
        }
        t.AppendSeparator()
    }
    t.SetColumnConfigs([]table.ColumnConfig{
        {Number: 1, AutoMerge: true},
    })
    t.SetStyle(table.StyleRounded)

    return "\n" + t.Render()
}
