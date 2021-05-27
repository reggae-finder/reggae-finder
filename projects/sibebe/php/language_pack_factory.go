package php

import (
    "github.com/ktom/sibebe/sibebe"
)

func GetFactory() sibebe.LanguagePackFactory {
    return func(config map[string]interface{}) sibebe.LanguagePack {
        sibebe.PrintVerbose("Init php pack")
        pack := PhpPack{}

        paths := []string{}
        for _, path := range config["paths"].([]interface{}) {
            paths = append(paths, path.(string))
        }

        actions := []string{}
        for _, action := range config["actions"].([]interface{}) {
            actions = append(actions, action.(string))
        }

        pack.config = PhpPackConfig{paths: paths, actions: actions}

        sibebe.PrintVerbose("PhpPackConfig:")
        sibebe.PrintVerbose(pack.config)
        sibebe.PrintVerbose("")

        return pack
    }
}
