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

func (lpfc *LanguagePackFactoriesCollector) GetFactory(language string) LanguagePackFactory {
    return lpfc.factories[language]
}

// func LanguagePackFactory(lang string) LanguagePack {
//     switch lang {
//         case "php":
//             return new(php.PhpPack)
// //         case "javascript":
// //             return new(javascript.JavascriptPack)
//     }

//     log.Fatalf("Unsupported language %s", lang)
//     return nil
// }
