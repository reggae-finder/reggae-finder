package php

import (
    "github.com/ktom/sibebe/sibebe"
)

func GetFactory() sibebe.LanguagePackFactory {
    return func(config map[string]interface{}) sibebe.LanguagePack {
        sibebe.PrintVerbose("Init php pack\n")
        pack := PhpPack{}

        paths := []string{}
        for _, path := range config["paths"].([]interface{}) {
            paths = append(paths, path.(string))
        }

        vendors := config["vendors"].(string)

        actions := []string{}
        for _, action := range config["actions"].([]interface{}) {
            actions = append(actions, action.(string))
        }

        pack.config = PhpPackConfig{
            paths: paths,
            vendors: vendors,
            actions: actions,
        }

        runnable_actions := map[string]sibebe.Action{}
        runnable_actions["clear"] = ClearAction
        runnable_actions["composer_install"] = ComposerInstallAction
        runnable_actions["phpunit"] = PhpunitAction

        pack.actions = runnable_actions

        sibebe.PrintVerbose("PhpPackConfig:\n%+v\n", pack.config)

        return pack
    }
}
