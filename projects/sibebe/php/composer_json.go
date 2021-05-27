package php

import(
    "errors"
    _"fmt"
    "encoding/json"
    "io/ioutil"
    "log"
    "os"
    "sort"

    "github.com/ktom/sibebe/utils"
)

type ComposerJson struct {
    Path string `json:"-"`
	Name string `json:"name"`
	Description string `json:"description"`
	License string `json:"license"`
	Require ComposerRequirement `json:"require"`
	RequireDev ComposerRequirement `json:"require-dev,omitempty"`
	Autoload ComposerAutoloaders `json:"autoload,omitempty"`
	AutoloadDev ComposerAutoloaders `json:"autoload-dev,omitempty"`
	Repositories []ComposerRepository `json:"repositories,omitempty"`
	MinimumStability string `json:"minimum-stability"`
	PreferStable bool `json:"prefer-stable"`
}

type ComposerRequirement map[string]string

type ComposerRepository struct {
    Type string `json:"type"`
    Url string `json:"url"`
}

type ComposerAutoloaders map[string]ComposerAutoloader

type ComposerAutoloader map[string]string



func (cr ComposerRequirement) Merge(req ComposerRequirement) (result ComposerRequirement, err error) {
    for dep, version := range req {
        if _, ok := cr[dep]; ok {
            if cr[dep] != version {
                return result, errors.New("merge conflict for "+ dep + ":"+ version)
            }
        } else {
            cr[dep] = version
        }
    }

    return cr, nil
}

func (cr ComposerRequirement) Sort() ComposerRequirement {
    deps := make([]string, 0, len(cr))
    for dep := range cr {
        deps = append(deps, dep)
    }

    sort.Strings(deps)

    newReq := make(ComposerRequirement)
    for _, dep := range deps {
        newReq[dep] = cr[dep]
    }

    return newReq
}



func FromFile(path string) (c ComposerJson, err error) {
    content, err := ioutil.ReadFile(path)
    if err != nil { return c, err }

    if err := json.Unmarshal(content, &c); err != nil {
        return c, err
    }

    c.Path = path
    return c, nil
}

func (c ComposerJson) String() string {
    c.Require.Sort()

    jsonString, jsonErr := utils.ToJsonString(c, true)
    if jsonErr != nil {
        log.Fatal(jsonErr)
    }

    return jsonString
}

func (c ComposerJson) DumpToFile(path string) {
    path = path +"/composer.json"
    jsonString := c.String();

    f, createErr := os.Create(path)
    if createErr != nil {
        panic(createErr)
    }

    defer f.Close()

    _, writeErr := f.WriteString(jsonString)
    if writeErr != nil {
        log.Fatal(writeErr)
    }

    f.Sync()
}
