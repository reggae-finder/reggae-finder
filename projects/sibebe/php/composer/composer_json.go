package composer

import(
    "bytes"
    "encoding/json"
    "fmt"
    "log"
    "os"
)

type ComposerJson struct {
	Name string `json:"name"`
	Description string `json:"description"`
	License string `json:"license"`
	Require ComposerRequirement `json:"require"`
	RequireDev ComposerRequirement `json:"require-dev"`
	Autoload ComposerAutoloaders `json:"autoload"`
	AutoloadDev ComposerAutoloaders `json:"autoload-dev"`
	Repositories []ComposerRepository
	MinimumStability string `json:"minimum-stability"`
	PreferStable bool `json:"prefer-stable"`
}

type ComposerRequirement map[string]string

func (cr ComposerRequirement) Merge(req ComposerRequirement) ComposerRequirement {
    for dep, version := range req {
        if _, ok := cr[dep]; ok {
            if cr[dep] != version {
                log.Fatal("merge conflict for "+ dep + ":"+ version)
            }
        } else {
            cr[dep] = version
        }
    }

    return cr
}

type ComposerAutoloaders map[string]ComposerAutoloader

type ComposerAutoloader map[string]string

type ComposerRepository struct {
    Type string `json:"type"`
    Url string `json:"url"`
}

func (c ComposerJson) PrintComposer() {
    b, err := json.Marshal(c)
    if err != nil {
        log.Fatal(err)
    }

    var out bytes.Buffer
    json.Indent(&out, b, "=", "\t")
    out.WriteTo(os.Stdout)
}

func Toto() {
    fmt.Println("composer_json.go")
}
