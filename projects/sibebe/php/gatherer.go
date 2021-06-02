package php

import (
    "fmt"

    "github.com/ktom/sibebe/sibebe"
)

func (p PhpPack) Gather(packages []string) (fmt.Stringer, error) {
    sibebe.PrintVerbose("Gather PHP dependencies")

    jsons := []ComposerJson{}
    for _, path := range packages {
        json, err := ComposerJsonFromFile(path)
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

    mergedRequirements := ComposerRequirement{}
    for _, requirement := range list {
        for version, _ := range requirement.Versions {
            mergedRequirements[requirement.PackageName] = version
            break
        }
    }

    repositories := []ComposerRepository{}
    for _, path := range p.config.GetPaths() {
        repository := ComposerRepository{Type: "path", Url: "./"+ path +"/{*,*/*,*/*/*}/*"}
        repositories = append(repositories, repository)
    }

    var global = ComposerJson{
        Name: "reggae-finder/reggae-finder",
        Description: "Reggae Finder",
        License: "MIT",
        Require: mergedRequirements,
        MinimumStability: "dev",
        PreferStable: true,
        Config: ComposerConfig{"vendor-dir": p.config.vendors},
        Repositories: repositories,
    }

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
