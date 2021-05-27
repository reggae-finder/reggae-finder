package php

import (
    "fmt"

    "github.com/ktom/sibebe/sibebe"
)

func (p PhpPack) Gather(packages []string) (fmt.Stringer, error) {
    sibebe.PrintVerbose("Gather PHP dependencies")

    jsons := []ComposerJson{}
    for _, path := range packages {
        json, err := FromFile(path)
        if (err != nil) { return nil, err }

        jsons = append(jsons, json)
    }

    list, err := p.createRequirementsList(jsons)
    if err != nil {
        return nil, err
    }

    if err := list.Analyse(); err != nil {
        if e, ok := err.(sibebe.RequirementsConflictsError); ok {
            e.AddPack(p)
            return nil, e
        }
        return nil, err
    }

//     mergedRequirements := ComposerRequirement{}
//     for _, json := range jsons {
//         merge, err := mergedRequirements.Merge(json.Require)
//         if err != nil {
//             return nil, errors.New(err.Error() +" in file "+ json.Path)
//         }
//         mergedRequirements = merge
//
//         merge2, err2 := mergedRequirements.Merge(json.RequireDev)
//         if err2 != nil {
//             return nil, errors.New(err2.Error() +" in file "+ json.Path)
//         }
//         mergedRequirements = merge2
//     }

    var global = ComposerJson{
        Name: "reggae-finder/reggae-finder",
        Description: "Reggae Finder",
        License: "MIT",
//         Require: mergedRequirements,
        MinimumStability: "dev",
        PreferStable: true,
    }

    fmt.Println(global.String())

    return global, nil
}

func (p PhpPack) createRequirementsList(jsons []ComposerJson) (sibebe.RequirementsList, error) {
    list := sibebe.RequirementsList{}

    for _, composer := range jsons {
        for dependency, version := range composer.Require {
            requirementOrigins := map[string]struct{}{}
            requirementOrigins[composer.Path] = struct{}{}

            requirementVersions := sibebe.RequirementVersions{}
            requirementVersions[version] = requirementOrigins

            requirement := sibebe.Requirement{PackageName: dependency, Versions: requirementVersions}
            list.AddRequirement(requirement)
        }
    }

    sibebe.PrintVerbose(list.ToTableString()+"\n")
    return list, nil
}
