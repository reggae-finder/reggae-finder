package sibebe

import (
    "fmt"
//     "log"

//     "github.com/ktom/sibebe/javascript"
//     "github.com/ktom/sibebe/php"
)

type LanguagePack interface {
    BuildMap(filename string, path string) (string, bool)
    Gather(packages []string) (fmt.Stringer, error)
    DumpGlobal(global fmt.Stringer, path string) error
    GlobalInstall(workDir string) error
    Run(packages []string, clear bool) error
    Update(packages []string) error
}

type LanguagePackConfig interface {
    GetPaths() []string
    GetActions() []string
}

type LanguagePackFactory func(config map[string]interface{}) LanguagePack

type LanguagePackFactoriesCollector struct {
    factories map[string]LanguagePackFactory
}

func (lpfc *LanguagePackFactoriesCollector) AddFactory(language string, factory LanguagePackFactory) {
    if lpfc.factories == nil {
        lpfc.factories = map[string]LanguagePackFactory{}
    }
    lpfc.factories[language] = factory
}

func (lpfc *LanguagePackFactoriesCollector) GetFactory(language string) (factory LanguagePackFactory, err error) {
    if _, ok := lpfc.factories[language]; !ok {
        return factory, fmt.Errorf("no factory for language %s", language)
    }

    return lpfc.factories[language], nil
}
