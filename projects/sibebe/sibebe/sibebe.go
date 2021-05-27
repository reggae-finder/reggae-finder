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

func (s *Sibebe) Setup(config SibebeConfig, collector LanguagePackFactoriesCollector) {
    s.config = config
    s.collector = collector

    s.initLanguagesPack()
    s.buildPackagesMap()
}

func (s *Sibebe) initLanguagesPack() {
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
        packConfig := s.config.GetPackConfig(language)
        s.packs[language] = s.collector.GetFactory(language)(packConfig)
    }
}

func Setup(config SibebeConfig, collector LanguagePackFactoriesCollector) { s.Setup(config, collector) }

func PrintVerbose(msg interface{}) {
    if s.config.IsVerbose() {
        fmt.Println(msg)
    }
}

//######################################################################################################################
