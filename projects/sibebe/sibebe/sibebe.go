package sibebe

import (
    "fmt"
    "log"
)

var s *Sibebe

func init() {
    s = new(Sibebe)
}

type Sibebe struct {
    config SibebeConfig
    collector LanguagePackFactoriesCollector
    packs map[string]LanguagePack
    packagesMap map[string][]string
}

func (s *Sibebe) Setup(config SibebeConfig, collector LanguagePackFactoriesCollector) error {
    s.config = config
    s.collector = collector

    if err := s.initLanguagesPack(); err != nil {
        return err
    }
    s.buildPackagesMap()

    return nil
}

func (s *Sibebe) initLanguagesPack() error {
    languages := s.config.GetLanguages()
    if len(languages) == 0 {
        log.Fatal(`Error initializing languages packs

You must enable at least one language in the configuration under the "languages" key

languages
  - php
  - javascript

`)
    }

    s.packs = map[string]LanguagePack{}

    for _, language := range languages {
        factory, err := s.collector.GetFactory(language)
        if err != nil { return err }

        packConfig := s.config.GetPackConfig(language)
        pack := factory(packConfig)

        s.packs[language] = pack
    }

    return nil
}

func (s Sibebe) GetConfig() SibebeConfig {
    return s.config
}

func Setup(config SibebeConfig, collector LanguagePackFactoriesCollector) error { return s.Setup(config, collector) }
func GetConfig() SibebeConfig { return s.GetConfig() }

func PrintVerbose(msg interface{}, args ...interface{}) {
    if s.config.IsVerbose() {
        switch message := msg.(type) {
        case string:
            if len(args) > 0 {
                fmt.Printf(message, args)
            } else {
                fmt.Print(message)
            }
        default:
            fmt.Print(append([]interface{}{message}, args...))
        }
        fmt.Println("")
    }
}

//######################################################################################################################
